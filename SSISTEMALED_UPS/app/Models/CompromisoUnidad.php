<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompromisoUnidad extends Model
{
    protected $table = 'compromisos_unidad';
    protected $primaryKey = 'id_compromiso';
    protected $fillable = [
        'id_seguimiento',
        'descripcion',
        'estado'
    ];

    /**
     * Relación: Un compromiso pertenece a un seguimiento
     */
    public function seguimiento(): BelongsTo
    {
        return $this->belongsTo(SeguimientoUnidad::class, 'id_seguimiento', 'id_seguimiento');
    }

    /**
     * Relación: Un compromiso puede tener muchas actividades relacionadas
     */
    public function actividades(): HasMany
    {
        return $this->hasMany(ActividadUnidad::class, 'id_compromiso_origen', 'id_compromiso');
    }
}
