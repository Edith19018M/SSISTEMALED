<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanNegocio extends Model
{
    protected $table = 'planes_negocio';
    protected $primaryKey = 'id_plan';
    protected $fillable = [
        'id_emprendimiento',
        'fecha',
        'documento_url',
        'certificado_nacimiento'
    ];
    protected $casts = [
        'fecha' => 'datetime',
        'certificado_nacimiento' => 'boolean'
    ];

    /**
     * Relación: Un plan pertenece a un emprendimiento
     */
    public function emprendimiento(): BelongsTo
    {
        return $this->belongsTo(Emprendimiento::class, 'id_emprendimiento', 'id_emprendimiento');
    }
}
