<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialUnidad extends Model
{
    protected $table = 'historial_unidad';
    protected $primaryKey = 'id_historial';
    protected $fillable = [
        'id_unidad',
        'fecha',
        'descripcion_cambio'
    ];
    protected $casts = [
        'fecha' => 'datetime'
    ];

    /**
     * Relación: Un historial pertenece a una unidad
     */
    public function unidad(): BelongsTo
    {
        return $this->belongsTo(UnidadProductiva::class, 'id_unidad', 'id_unidad');
    }
}
