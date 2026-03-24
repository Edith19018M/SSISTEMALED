<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asesoria extends Model
{
    protected $table = 'asesorias';
    protected $primaryKey = 'id_asesoria';
    protected $fillable = [
        'id_emprendimiento',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'tipo',
        'tematica',
        'descripcion',
        'observaciones'
    ];
    protected $casts = [
        'fecha' => 'datetime',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i'
    ];

    /**
     * Relación: Una asesoría pertenece a un emprendimiento
     */
    public function emprendimiento(): BelongsTo
    {
        return $this->belongsTo(Emprendimiento::class, 'id_emprendimiento', 'id_emprendimiento');
    }

    /**
     * Relación: Una asesoría tiene muchos compromisos
     */
    public function compromisos(): HasMany
    {
        return $this->hasMany(CompromisoAsesoria::class, 'id_asesoria', 'id_asesoria');
    }
}
