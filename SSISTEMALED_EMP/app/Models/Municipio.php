<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    protected $table = 'municipios';
    protected $primaryKey = 'id_municipio';
    protected $fillable = ['nombre_municipio', 'id_region'];

    /**
     * Relación: Un municipio pertenece a una región
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'id_region', 'id_region');
    }

    /**
     * Relación: Un municipio tiene muchos usuarios
     */
    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'municipio_id', 'id_municipio');
    }

    /**
     * Relación: Un municipio tiene muchos emprendimientos
     */
    public function emprendimientos(): HasMany
    {
        return $this->hasMany(Emprendimiento::class, 'municipio_id', 'id_municipio');
    }

    /**
     * Relación: Un municipio tiene muchas unidades productivas
     */
    public function unidadesProductivas(): HasMany
    {
        return $this->hasMany(UnidadProductiva::class, 'municipio_id', 'id_municipio');
    }
}
