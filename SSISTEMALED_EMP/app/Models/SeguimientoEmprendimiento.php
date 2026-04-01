<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeguimientoEmprendimiento extends Model
{
    protected $table = 'seguimientos_emprendimiento';
    protected $primaryKey = 'id_seguimiento';
    protected $fillable = [
        'id_emprendimiento',
        'numero_seguimiento',
        'fecha'
    ];
    protected $casts = [
        'fecha' => 'datetime'
    ];

    /**
     * Relación: Un seguimiento pertenece a un emprendimiento
     */
    public function emprendimiento(): BelongsTo
    {
        return $this->belongsTo(Emprendimiento::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    /**
     * Relación: Un seguimiento tiene muchos compromisos
     */
    public function compromisos(): HasMany
    {
        return $this->hasMany(CompromisoEmprendimiento::class, 'id_seguimiento', 'id_seguimiento');
    }

    /**
     * Relación: Un seguimiento tiene muchas actividades
     */
    public function actividades(): HasMany
    {
        return $this->hasMany(ActividadEmprendimiento::class, 'id_seguimiento', 'id_seguimiento');
    }
}
