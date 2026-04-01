<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Asesoria;
use App\Models\CompromisoAsesoria;
use App\Models\Emprendimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormularioAsesoriaController extends Controller
{
    /**
     * Muestra el formulario de asesoría (reemplazo del formulario KoboToolbox).
     */
    public function create()
    {
        $emprendimientos = Emprendimiento::orderBy('nombre')->get();

        // Pre-seleccionar emprendimiento si el usuario es Emprendedor
        $emprendimientoPreseleccionado = null;
        if (session('usuario_rol') === 'Emprendedor' && session('emprendedor_id')) {
            $emprendimientoPreseleccionado = \App\Models\Emprendedor::find(session('emprendedor_id'))?->id_emprendimiento;
        }

        return view('asesorias.formulario', compact('emprendimientos', 'emprendimientoPreseleccionado'));
    }

    /**
     * Procesa y guarda el formulario de asesoría directamente en el sistema.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_emprendimiento'   => 'required|exists:emprendimientos,id_emprendimiento',
            'fecha'               => 'required|date',
            'hora_inicio'         => 'required',
            'hora_fin'            => 'required',
            'nombre_participante_2' => 'required|string|max:255',
            'nombre_participante_3' => 'nullable|string|max:255',
            'tipo'                => 'required|string|max:100',
            'tematica'            => 'required|array|min:1',
            'tematica.*'          => 'string',
            'tematica_otro'       => 'nullable|string|max:255',
            'descripcion'         => 'nullable|string',
            'observaciones'       => 'nullable|string',
            // Seguimiento a asesoría anterior
            'seguimiento_actividad'   => 'nullable|array',
            'seguimiento_actividad.*' => 'nullable|string|max:500',
            'seguimiento_estado'      => 'nullable|array',
            'seguimiento_estado.*'    => 'nullable|string|max:100',
            // Compromisos nuevos
            'compromiso_actividad'    => 'nullable|array',
            'compromiso_actividad.*'  => 'nullable|string|max:500',
            'compromiso_responsable'  => 'nullable|array',
            'compromiso_responsable.*'=> 'nullable|string|max:255',
            'compromiso_fecha'        => 'nullable|array',
            'compromiso_fecha.*'      => 'nullable|date',
        ]);

        DB::transaction(function () use ($request) {

            // === Construir campo TEMATICA ===
            $tematicas = $request->tematica ?? [];
            if ($request->filled('tematica_otro')) {
                $tematicas[] = 'Otro: ' . $request->tematica_otro;
            }
            $tematicaStr = implode(' | ', array_map('strtoupper', $tematicas));

            // === Construir campo OBSERVACIONES (incluye participantes) ===
            $obs = "PARTICIPANTES:\n";
            $obs .= "- " . $request->nombre_participante_2 . "\n";
            if ($request->filled('nombre_participante_3')) {
                $obs .= "- " . $request->nombre_participante_3 . "\n";
            }
            if ($request->filled('observaciones')) {
                $obs .= "\nOBSERVACIONES:\n" . $request->observaciones;
            }

            // === Crear Asesoría ===
            $asesoria = Asesoria::create([
                'id_emprendimiento' => $request->id_emprendimiento,
                'fecha'             => $request->fecha,
                'hora_inicio'       => $request->hora_inicio,
                'hora_fin'          => $request->hora_fin,
                'tipo'              => $request->tipo,
                'tematica'          => $tematicaStr,
                'descripcion'       => $request->descripcion,
                'observaciones'     => $obs,
            ]);

            // === Crear compromisos: Seguimiento a Asesoría Anterior ===
            $segActividades = $request->seguimiento_actividad ?? [];
            $segEstados     = $request->seguimiento_estado ?? [];

            foreach ($segActividades as $i => $actividad) {
                if (empty(trim($actividad ?? ''))) continue;

                CompromisoAsesoria::create([
                    'id_asesoria' => $asesoria->id_asesoria,
                    'actividad'   => '[Seguimiento anterior] ' . $actividad,
                    'responsable' => 'Sin especificar',
                    'fecha'       => $request->fecha,
                    'estado'      => $segEstados[$i] ?? 'pendiente',
                ]);
            }

            // === Crear compromisos: Nuevos compromisos ===
            $cmpActividades  = $request->compromiso_actividad ?? [];
            $cmpResponsables = $request->compromiso_responsable ?? [];
            $cmpFechas       = $request->compromiso_fecha ?? [];

            foreach ($cmpActividades as $i => $actividad) {
                if (empty(trim($actividad ?? ''))) continue;

                CompromisoAsesoria::create([
                    'id_asesoria' => $asesoria->id_asesoria,
                    'actividad'   => $actividad,
                    'responsable' => !empty($cmpResponsables[$i]) ? $cmpResponsables[$i] : 'Sin especificar',
                    'fecha'       => !empty($cmpFechas[$i]) ? $cmpFechas[$i] : $request->fecha,
                    'estado'      => 'pendiente',
                ]);
            }

            session(['ultima_asesoria_id' => $asesoria->id_asesoria]);
        });

        $id = session('ultima_asesoria_id');

        if (session('usuario_rol') === 'Emprendedor') {
            return redirect('/mi-perfil')
                ->with('success', 'Asesoría registrada exitosamente.');
        }

        return redirect('/asesorias/' . $id)
            ->with('success', 'Asesoría registrada exitosamente.');
    }
}
