<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'sector_rubro'
    ];

    /**
     * Relación: Un emprendimiento pertenece a una categoría
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaEmprendimiento::class, 'categoria_id', 'id_categoria');
    }

    /**
     * Relación: Un emprendimiento pertenece a un municipio
     */
    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id_municipio');
    }

    /**
     * Relación: Un emprendimiento tiene muchos productos
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    /**
     * Relación: Un emprendimiento tiene muchos emprendedores (N:M)
     */
    public function emprendedores(): BelongsToMany
    {
        return $this->belongsToMany(
            Emprendedor::class,
            'emprendimiento_emprendedor',
            'id_emprendimiento',
            'id_emprendedor'
        )->withPivot('es_responsable_principal')->withTimestamps();
    }

    /**
     * Relación: Un emprendimiento tiene muchos formularios de inscripción
     */
    public function formularios(): HasMany
    {
        return $this->hasMany(FormularioInscripcion::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    /**
     * Relación: Un emprendimiento tiene muchas entrevistas
     */
    public function entrevistas(): HasMany
    {
        return $this->hasMany(Entrevista::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    /**
     * Relación: Un emprendimiento tiene muchos planes de negocio
     */
    public function planesNegocio(): HasMany
    {
        return $this->hasMany(PlanNegocio::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    /**
     * Relación: Un emprendimiento tiene muchos seguimientos
     */
    public function seguimientos(): HasMany
    {
        return $this->hasMany(SeguimientoEmprendimiento::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    /**
     * Relación: Un emprendimiento tiene muchas asesorías
     */
    public function asesorias(): HasMany
    {
        return $this->hasMany(Asesoria::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    /**
     * Relación: Un emprendimiento tiene muchos registros en su historial
     */
    public function historial(): HasMany
    {
        return $this->hasMany(HistorialEmprendimiento::class, 'id_emprendimiento', 'id_emprendimiento');
    }
}
