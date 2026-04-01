<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaUnidad extends Model
{
    protected $table = 'categorias_unidad';
    protected $primaryKey = 'id_categoria';
    protected $fillable = ['nombre_categoria', 'carrera_asociada'];

    /**
     * Relación: Una categoría tiene muchas unidades productivas
     */
    public function unidadesProductivas(): HasMany
    {
        return $this->hasMany(UnidadProductiva::class, 'categoria_id', 'id_categoria');
    }
}
