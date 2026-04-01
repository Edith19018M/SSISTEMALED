<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeguimientoUnidad extends Model
{
    protected $table = 'seguimientos_unidad';
    protected $primaryKey = 'id_seguimiento';
    protected $fillable = [
        'id_unidad',
        'numero_seguimiento',
        'fecha'
    ];
    protected $casts = [
        'fecha' => 'datetime'
    ];

    /**
     * Relación: Un seguimiento pertenece a una unidad
     */
    public function unidad(): BelongsTo
    {
        return $this->belongsTo(UnidadProductiva::class, 'id_unidad', 'id_unidad');
    }

    /**
     * Relación: Un seguimiento tiene muchos compromisos
     */
    public function compromisos(): HasMany
    {
        return $this->hasMany(CompromisoUnidad::class, 'id_seguimiento', 'id_seguimiento');
    }

    /**
     * Relación: Un seguimiento tiene muchas actividades
     */
    public function actividades(): HasMany
    {
        return $this->hasMany(ActividadUnidad::class, 'id_seguimiento', 'id_seguimiento');
    }
}
