<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Emprendimiento extends Model
{
    protected $table = 'emprendimientos';
    protected $primaryKey = 'id_emprendimiento';
    protected $fillable = [
        'nombre',
        'categoria_id',
        'municipio_id',
        'estado_proceso',
        'direccion',
        'sector_rubro',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaEmprendimiento::class, 'categoria_id', 'id_categoria');
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id_municipio');
    }

    /**
     * Relación: Un emprendimiento tiene muchos emprendedores (1:N)
     */
    public function emprendedores(): HasMany
    {
        return $this->hasMany(Emprendedor::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    public function formularios(): HasMany
    {
        return $this->hasMany(FormularioInscripcion::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    public function entrevistas(): HasMany
    {
        return $this->hasMany(Entrevista::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    public function planesNegocio(): HasMany
    {
        return $this->hasMany(PlanNegocio::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    public function seguimientos(): HasMany
    {
        return $this->hasMany(SeguimientoEmprendimiento::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    public function asesorias(): HasMany
    {
        return $this->hasMany(Asesoria::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    public function historial(): HasMany
    {
        return $this->hasMany(HistorialEmprendimiento::class, 'id_emprendimiento', 'id_emprendimiento');
    }
}
