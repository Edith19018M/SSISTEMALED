<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    protected $table = 'regiones';
    protected $primaryKey = 'id_region';
    protected $fillable = ['nombre_region'];

    /**
     * Relación: Una región tiene muchos municipios
     */
    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class, 'id_region', 'id_region');
    }

    /**
     * Relación: Una región tiene muchos usuarios
     */
    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'region_id', 'id_region');
    }
}
