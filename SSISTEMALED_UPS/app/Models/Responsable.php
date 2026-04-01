<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Responsable extends Model
{
    protected $table = 'responsables';
    protected $primaryKey = 'id_responsable';
    protected $fillable = [
        'nombre',
        'contacto',
        'ci',
        'correo'
    ];

    /**
     * Relación: Un responsable puede ser responsable de muchas unidades (N:M)
     */
    public function unidadesProductivas(): BelongsToMany
    {
        return $this->belongsToMany(
            UnidadProductiva::class,
            'unidad_responsable',
            'id_responsable',
            'id_unidad'
        )->withPivot('fecha_inicio', 'fecha_fin')->withTimestamps();
    }
}
