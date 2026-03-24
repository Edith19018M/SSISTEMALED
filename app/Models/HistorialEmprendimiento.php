<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialEmprendimiento extends Model
{
    protected $table = 'historial_emprendimiento';
    protected $primaryKey = 'id_historial';
    protected $fillable = [
        'id_emprendimiento',
        'fecha',
        'descripcion_cambio'
    ];
    protected $casts = [
        'fecha' => 'datetime'
    ];

    /**
     * Relación: Un historial pertenece a un emprendimiento
     */
    public function emprendimiento(): BelongsTo
    {
        return $this->belongsTo(Emprendimiento::class, 'id_emprendimiento', 'id_emprendimiento');
    }
}
