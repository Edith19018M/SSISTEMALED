<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompromisoAsesoria extends Model
{
    protected $table = 'compromisos_asesoria';
    protected $primaryKey = 'id_compromiso';
    protected $fillable = [
        'id_asesoria',
        'actividad',
        'responsable',
        'fecha',
        'estado'
    ];
    protected $casts = [
        'fecha' => 'date'
    ];

    /**
     * Relación: Un compromiso pertenece a una asesoría
     */
    public function asesoria(): BelongsTo
    {
        return $this->belongsTo(Asesoria::class, 'id_asesoria', 'id_asesoria');
    }
}
