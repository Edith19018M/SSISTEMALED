<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActividadEmprendimiento extends Model
{
    protected $table = 'actividades_emprendimiento';
    protected $primaryKey = 'id_actividad';
    protected $fillable = [
        'id_seguimiento',
        'descripcion',
        'estado',
        'id_compromiso_origen'
    ];

    /**
     * Relación: Una actividad pertenece a un seguimiento
     */
    public function seguimiento(): BelongsTo
    {
        return $this->belongsTo(SeguimientoEmprendimiento::class, 'id_seguimiento', 'id_seguimiento');
    }

    /**
     * Relación: Una actividad puede provenir de un compromiso
     */
    public function compromiso(): BelongsTo
    {
        return $this->belongsTo(CompromisoEmprendimiento::class, 'id_compromiso_origen', 'id_compromiso');
    }
}
