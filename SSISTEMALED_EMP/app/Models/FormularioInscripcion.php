<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormularioInscripcion extends Model
{
    protected $table = 'formularios_inscripcion';
    protected $primaryKey = 'id_formulario';
    protected $fillable = [
        'id_emprendimiento',
        'fecha_envio',
        'datos_json'
    ];
    protected $casts = [
        'datos_json' => 'json',
        'fecha_envio' => 'datetime'
    ];

    /**
     * Relación: Un formulario pertenece a un emprendimiento
     */
    public function emprendimiento(): BelongsTo
    {
        return $this->belongsTo(Emprendimiento::class, 'id_emprendimiento', 'id_emprendimiento');
    }
}
