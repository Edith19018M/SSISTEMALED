<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UnidadProductiva extends Model
{
    protected $table = 'unidades_productivas';
    protected $primaryKey = 'id_unidad';
    protected $fillable = [
        'nombre',
        'categoria_id',
        'municipio_id',
        'direccion'
    ];

    /**
     * Relación: Una unidad pertenece a una categoría
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaUnidad::class, 'categoria_id', 'id_categoria');
    }

    /**
     * Relación: Una unidad pertenece a un municipio
     */
    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id_municipio');
    }

    /**
     * Relación: Una unidad tiene muchos responsables (N:M)
     */
    public function responsables(): BelongsToMany
    {
        return $this->belongsToMany(
            Responsable::class,
            'unidad_responsable',
            'id_unidad',
            'id_responsable'
        )->withPivot('fecha_inicio', 'fecha_fin')->withTimestamps();
    }

    /**
     * Relación: Una unidad tiene muchos seguimientos
     */
    public function seguimientos(): HasMany
    {
        return $this->hasMany(SeguimientoUnidad::class, 'id_unidad', 'id_unidad');
    }

    /**
     * Relación: Una unidad tiene muchas compras
     */
    public function compras(): HasMany
    {
        return $this->hasMany(Compra::class, 'id_unidad', 'id_unidad');
    }

    /**
     * Relación: Una unidad tiene muchas ventas
     */
    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class, 'id_unidad', 'id_unidad');
    }

    /**
     * Relación: Una unidad tiene muchos registros en su historial
     */
    public function historial(): HasMany
    {
        return $this->hasMany(HistorialUnidad::class, 'id_unidad', 'id_unidad');
    }
}
