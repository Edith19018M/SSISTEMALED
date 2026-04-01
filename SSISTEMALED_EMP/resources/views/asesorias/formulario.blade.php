@extends(session('usuario_rol') === 'Emprendedor' ? 'layouts.emprendedor' : 'layouts.app')

@section('title', 'Formulario de Asesoría')
@section('titulo', 'Formulario de Asesoría')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/asesorias">Asesorías</a></li>
    <li class="breadcrumb-item active">Nuevo Registro</li>
@endsection

@push('styles')
<style>
    .section-header {
        background: #343a40;
        color: #fff;
        padding: 8px 14px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        margin-bottom: 1rem;
        text-transform: uppercase;
    }
    .fila-dinamica { border-left: 3px solid #17a2b8; padding-left: 10px; margin-bottom: 8px; }
    .fila-dinamica-compromiso { border-left: 3px solid #ffc107; padding-left: 10px; margin-bottom: 8px; }
    .btn-eliminar-fila { cursor: pointer; }
    .tematica-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 6px; }
    .tematica-grid .custom-control { margin-bottom: 0; }
</style>
@endpush

@section('content')

<form action="/asesorias/formulario" method="POST" id="formularioAsesoria">
@csrf

{{-- ══════════════════════════════════════════════════════ --}}
{{-- SECCIÓN 1: IDENTIFICACIÓN --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="card card-outline card-dark">
    <div class="card-body">
        <div class="section-header"><i class="fas fa-id-card mr-1"></i> Identificación</div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Emprendimiento <span class="text-danger">*</span></label>
                    <select name="id_emprendimiento" class="form-control @error('id_emprendimiento') is-invalid @enderror" required>
                        <option value="">— Seleccionar emprendimiento —</option>
                        @foreach($emprendimientos as $emp)
                            <option value="{{ $emp->id_emprendimiento }}" {{ old('id_emprendimiento') == $emp->id_emprendimiento ? 'selected' : '' }}>
                                {{ $emp->nombre }}
                                @if($emp->municipio) — {{ $emp->municipio->nombre_municipio }} @endif
                            </option>
                        @endforeach
                    </select>
                    @error('id_emprendimiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Fecha <span class="text-danger">*</span></label>
                    <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                           value="{{ old('fecha', date('Y-m-d')) }}" required>
                    @error('fecha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Hora Inicio <span class="text-danger">*</span></label>
                    <input type="time" name="hora_inicio" class="form-control @error('hora_inicio') is-invalid @enderror"
                           value="{{ old('hora_inicio') }}" required>
                    @error('hora_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Hora Final <span class="text-danger">*</span></label>
                    <input type="time" name="hora_fin" class="form-control @error('hora_fin') is-invalid @enderror"
                           value="{{ old('hora_fin') }}" required>
                    @error('hora_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- SECCIÓN 2: PARTICIPANTES --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="card card-outline card-dark mt-3">
    <div class="card-body">
        <div class="section-header"><i class="fas fa-users mr-1"></i> Registro de Asesoría — Participantes</div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre completo (Participante 1) <span class="text-danger">*</span></label>
                    <input type="text" name="nombre_participante_2"
                           class="form-control @error('nombre_participante_2') is-invalid @enderror"
                           placeholder="Ej: Juan Pérez Mamani"
                           value="{{ old('nombre_participante_2') }}" required>
                    @error('nombre_participante_2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre completo (Participante 2) <span class="text-muted small">— opcional</span></label>
                    <input type="text" name="nombre_participante_3"
                           class="form-control @error('nombre_participante_3') is-invalid @enderror"
                           placeholder="Ej: María Condori"
                           value="{{ old('nombre_participante_3') }}">
                    @error('nombre_participante_3')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- SECCIÓN 3: SEGUIMIENTO A ASESORÍA ANTERIOR --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="card card-outline card-info mt-3">
    <div class="card-body">
        <div class="section-header" style="background:#17a2b8;"><i class="fas fa-history mr-1"></i> Seguimiento a Asesoría Anterior</div>
        <p class="text-muted small mb-3">Registra el estado de los compromisos de la asesoría anterior.</p>

        <div id="contenedor-seguimiento">
            <div class="fila-dinamica row align-items-center" id="seg-fila-0">
                <div class="col-md-8">
                    <input type="text" name="seguimiento_actividad[]"
                           class="form-control form-control-sm"
                           placeholder="Descripción de la actividad / compromiso anterior">
                </div>
                <div class="col-md-3">
                    <select name="seguimiento_estado[]" class="form-control form-control-sm">
                        <option value="">— Estado —</option>
                        <option value="ejecutado">Ejecutado</option>
                        <option value="en_proceso">En proceso</option>
                        <option value="no_realizado">No realizado</option>
                        <option value="espera">En espera</option>
                        <option value="suspendido">Suspendido</option>
                    </select>
                </div>
                <div class="col-md-1 text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-eliminar-fila" onclick="eliminarFila(this, 'contenedor-seguimiento')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-sm btn-outline-info mt-2"
                onclick="agregarFilaSeguimiento()">
            <i class="fas fa-plus mr-1"></i> Agregar actividad
        </button>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- SECCIÓN 4: TIPO DE ASESORÍA --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="card card-outline card-dark mt-3">
    <div class="card-body">
        <div class="section-header"><i class="fas fa-tag mr-1"></i> Tipo de Asesoría</div>
        @error('tipo')<div class="alert alert-danger py-1 small">{{ $message }}</div>@enderror
        <div class="row">
            @php
            $tipos = [
                'plan_de_negocio'  => 'PLAN DE NEGOCIO',
                'at__productivo'   => 'AT. PRODUCTIVO',
                'at__comercial'    => 'AT. COMERCIAL',
                'at__de_gestion'   => 'AT. DE GESTIÓN',
                'mentoring'        => 'MENTORING',
            ];
            @endphp
            @foreach($tipos as $val => $label)
            <div class="col-auto mb-2">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="tipo_{{ $val }}" name="tipo" value="{{ $val }}"
                           class="custom-control-input" {{ old('tipo') == $val ? 'checked' : '' }} required>
                    <label class="custom-control-label font-weight-bold" for="tipo_{{ $val }}">{{ $label }}</label>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- SECCIÓN 5: TEMÁTICA --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="card card-outline card-dark mt-3">
    <div class="card-body">
        <div class="section-header"><i class="fas fa-list-ul mr-1"></i> Temática <span class="text-warning small">(una o varias)</span></div>
        @error('tematica')<div class="alert alert-danger py-1 small">{{ $message }}</div>@enderror
        @php
        $tematicas = [
            'identificacion_producto_servicio' => 'Identificación de producto/servicio',
            'produccion_producto_servicio'     => 'Producción de producto/servicio',
            'produccion_mas_limpia'            => 'Producción más limpia',
            'envasado_etiquetado'              => 'Envasado o etiquetado',
            'gestion_personal'                 => 'Gestión de personal',
            'estudio_mercado'                  => 'Estudio de mercado',
            'articulacion_comercial'           => 'Articulación comercial',
            'comercio_electronico'             => 'Comercio electrónico',
            'marketing'                        => 'Marketing',
            'impuestos_tributacion'            => 'Impuestos - Tributación',
            'capital_semilla'                  => 'Capital Semilla',
            'formalizacion_normativa'          => 'Formalización y normativa',
            'contabilidad'                     => 'Contabilidad',
            'calculo_ingresos_costos'          => 'Cálculo de ingresos y costos',
            'calculo_inversion'                => 'Cálculo de inversión',
            'analisis_financiero_eeff'         => 'Análisis financiero (EEFF)',
        ];
        $oldTematicas = old('tematica', []);
        @endphp
        <div class="tematica-grid">
            @foreach($tematicas as $val => $label)
            <div class="custom-control custom-checkbox">
                <input type="checkbox" id="tem_{{ $val }}" name="tematica[]" value="{{ $val }}"
                       class="custom-control-input" {{ in_array($val, $oldTematicas) ? 'checked' : '' }}>
                <label class="custom-control-label" for="tem_{{ $val }}">{{ $label }}</label>
            </div>
            @endforeach
        </div>
        <div class="form-group mt-3 mb-0">
            <label class="small text-muted">Otro (especificar):</label>
            <input type="text" name="tematica_otro" class="form-control form-control-sm"
                   placeholder="Temática no listada..." value="{{ old('tematica_otro') }}" style="max-width:400px;">
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- SECCIÓN 6: DESCRIPCIÓN DE LA ASESORÍA --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="card card-outline card-dark mt-3">
    <div class="card-body">
        <div class="section-header"><i class="fas fa-align-left mr-1"></i> Breve Descripción de la Asesoría Desarrollada</div>
        <div class="form-group mb-0">
            <textarea name="descripcion" class="form-control" rows="4"
                      placeholder="Describe los temas abordados, metodología utilizada, resultados de la sesión...">{{ old('descripcion') }}</textarea>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- SECCIÓN 7: COMPROMISOS NUEVOS --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="card card-outline card-warning mt-3">
    <div class="card-body">
        <div class="section-header" style="background:#856404; color:#fff;"><i class="fas fa-tasks mr-1"></i> Compromisos</div>
        <p class="text-muted small mb-3">Registra los compromisos acordados en esta asesoría.</p>

        <div class="row d-none d-md-flex mb-1">
            <div class="col-md-5"><small class="text-muted font-weight-bold">Actividad / Compromiso</small></div>
            <div class="col-md-4"><small class="text-muted font-weight-bold">Responsable</small></div>
            <div class="col-md-2"><small class="text-muted font-weight-bold">Fecha límite</small></div>
        </div>

        <div id="contenedor-compromisos">
            <div class="fila-dinamica-compromiso row align-items-center mb-2">
                <div class="col-md-5">
                    <input type="text" name="compromiso_actividad[]"
                           class="form-control form-control-sm"
                           placeholder="Descripción del compromiso">
                </div>
                <div class="col-md-4">
                    <input type="text" name="compromiso_responsable[]"
                           class="form-control form-control-sm"
                           placeholder="Nombre del responsable">
                </div>
                <div class="col-md-2">
                    <input type="date" name="compromiso_fecha[]"
                           class="form-control form-control-sm">
                </div>
                <div class="col-md-1 text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-eliminar-fila"
                            onclick="eliminarFila(this, 'contenedor-compromisos')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-sm btn-outline-warning mt-2"
                onclick="agregarFilaCompromiso()">
            <i class="fas fa-plus mr-1"></i> Agregar compromiso
        </button>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- SECCIÓN 8: OBSERVACIONES --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="card card-outline card-dark mt-3">
    <div class="card-body">
        <div class="section-header"><i class="fas fa-sticky-note mr-1"></i> Observaciones</div>
        <div class="form-group mb-0">
            <textarea name="observaciones" class="form-control" rows="3"
                      placeholder="Observaciones adicionales, notas, próximos pasos...">{{ old('observaciones') }}</textarea>
        </div>
    </div>
</div>

{{-- BOTONES --}}
<div class="row mt-4 mb-5">
    <div class="col-md-6">
        <button type="submit" class="btn btn-primary btn-lg btn-block">
            <i class="fas fa-save mr-1"></i> Guardar Asesoría
        </button>
    </div>
    <div class="col-md-6">
        <a href="/asesorias" class="btn btn-secondary btn-lg btn-block">
            <i class="fas fa-times mr-1"></i> Cancelar
        </a>
    </div>
</div>

</form>
@endsection

@push('scripts')
<script>
// ── Seguimiento: agregar fila ──────────────────────────────
function agregarFilaSeguimiento() {
    const contenedor = document.getElementById('contenedor-seguimiento');
    const fila = document.createElement('div');
    fila.className = 'fila-dinamica row align-items-center mt-1';
    fila.innerHTML = `
        <div class="col-md-8">
            <input type="text" name="seguimiento_actividad[]"
                   class="form-control form-control-sm"
                   placeholder="Descripción de la actividad / compromiso anterior">
        </div>
        <div class="col-md-3">
            <select name="seguimiento_estado[]" class="form-control form-control-sm">
                <option value="">— Estado —</option>
                <option value="ejecutado">Ejecutado</option>
                <option value="en_proceso">En proceso</option>
                <option value="no_realizado">No realizado</option>
                <option value="espera">En espera</option>
                <option value="suspendido">Suspendido</option>
            </select>
        </div>
        <div class="col-md-1 text-center">
            <button type="button" class="btn btn-sm btn-outline-danger"
                    onclick="eliminarFila(this, 'contenedor-seguimiento')">
                <i class="fas fa-times"></i>
            </button>
        </div>`;
    contenedor.appendChild(fila);
}

// ── Compromisos: agregar fila ──────────────────────────────
function agregarFilaCompromiso() {
    const contenedor = document.getElementById('contenedor-compromisos');
    const fila = document.createElement('div');
    fila.className = 'fila-dinamica-compromiso row align-items-center mb-2';
    fila.innerHTML = `
        <div class="col-md-5">
            <input type="text" name="compromiso_actividad[]"
                   class="form-control form-control-sm"
                   placeholder="Descripción del compromiso">
        </div>
        <div class="col-md-4">
            <input type="text" name="compromiso_responsable[]"
                   class="form-control form-control-sm"
                   placeholder="Nombre del responsable">
        </div>
        <div class="col-md-2">
            <input type="date" name="compromiso_fecha[]"
                   class="form-control form-control-sm">
        </div>
        <div class="col-md-1 text-center">
            <button type="button" class="btn btn-sm btn-outline-danger"
                    onclick="eliminarFila(this, 'contenedor-compromisos')">
                <i class="fas fa-times"></i>
            </button>
        </div>`;
    contenedor.appendChild(fila);
}

// ── Eliminar fila ──────────────────────────────────────────
function eliminarFila(btn, contenedorId) {
    const contenedor = document.getElementById(contenedorId);
    const filas = contenedor.querySelectorAll('.fila-dinamica, .fila-dinamica-compromiso');
    if (filas.length <= 1) return; // Mantener al menos una fila
    btn.closest('.fila-dinamica, .fila-dinamica-compromiso').remove();
}

// ── Validación: al menos una temática ─────────────────────
document.getElementById('formularioAsesoria').addEventListener('submit', function(e) {
    const checks = document.querySelectorAll('input[name="tematica[]"]:checked');
    const otro = document.querySelector('input[name="tematica_otro"]').value.trim();
    if (checks.length === 0 && !otro) {
        e.preventDefault();
        alert('Debe seleccionar al menos una temática.');
    }
});
</script>
@endpush
