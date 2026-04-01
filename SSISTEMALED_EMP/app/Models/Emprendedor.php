<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Emprendedor extends Model
{
    protected $table = 'emprendedores';
    protected $primaryKey = 'id_emprendedor';
    protected $fillable = [
        'codigo',
        'id_emprendimiento',
        'nombre',
        'apellidos',
        'edad',
        'sexo',
        'ci',
        'celular',
        'correo',
        'direccion',
        'carrera',
        'año_estudio',
    ];

    /**
     * Relación: Un emprendedor pertenece a un emprendimiento (1:N)
     */
    public function emprendimiento(): BelongsTo
    {
        return $this->belongsTo(Emprendimiento::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    /**
     * Relación: Un emprendedor puede tener un usuario de acceso
     */
    public function usuario(): HasOne
    {
        return $this->hasOne(Usuario::class, 'emprendedor_id', 'id_emprendedor');
    }
}
