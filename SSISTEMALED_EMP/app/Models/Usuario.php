<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Model
{
    use HasApiTokens;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $fillable = ['nombre', 'correo', 'contraseña', 'rol_id', 'region_id', 'municipio_id', 'emprendedor_id'];
    protected $hidden = ['contraseña'];

    /**
     * Relación: Un usuario pertenece a un rol
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id', 'id_rol');
    }

    /**
     * Relación: Un usuario pertenece a una región
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id', 'id_region');
    }

    /**
     * Relación: Un usuario pertenece a un municipio
     */
    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id_municipio');
    }

    /**
     * Relación: Un usuario con rol Emprendedor está vinculado a un emprendedor
     */
    public function emprendedor(): BelongsTo
    {
        return $this->belongsTo(Emprendedor::class, 'emprendedor_id', 'id_emprendedor');
    }
}
