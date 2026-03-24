<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaEmprendimiento extends Model
{
    protected $table = 'categorias_emprendimiento';
    protected $primaryKey = 'id_categoria';
    protected $fillable = ['nombre_categoria'];

    /**
     * Relación: Una categoría tiene muchos emprendimientos
     */
    public function emprendimientos(): HasMany
    {
        return $this->hasMany(Emprendimiento::class, 'categoria_id', 'id_categoria');
    }
}
