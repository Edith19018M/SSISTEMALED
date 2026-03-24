<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Emprendedor extends Model
{
    protected $table = 'emprendedores';
    protected $primaryKey = 'id_emprendedor';
    protected $fillable = [
        'nombre',
        'apellidos',
        'edad',
        'sexo',
        'ci',
        'celular',
        'correo',
        'direccion',
        'carrera',
        'año_estudio'
    ];

    /**
     * Relación: Un emprendedor tiene muchos emprendimientos (N:M)
     */
    public function emprendimientos(): BelongsToMany
    {
        return $this->belongsToMany(
            Emprendimiento::class,
            'emprendimiento_emprendedor',
            'id_emprendedor',
            'id_emprendimiento'
        )->withPivot('es_responsable_principal')->withTimestamps();
    }
}
