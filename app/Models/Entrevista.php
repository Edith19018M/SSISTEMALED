<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entrevista extends Model
{
    protected $table = 'entrevistas';
    protected $primaryKey = 'id_entrevista';
    protected $fillable = [
        'id_emprendimiento',
        'fecha',
        'evaluador',
        'resultado',
        'observaciones'
    ];
    protected $casts = [
        'fecha' => 'datetime'
    ];

    /**
     * Relación: Una entrevista pertenece a un emprendimiento
     */
    public function emprendimiento(): BelongsTo
    {
        return $this->belongsTo(Emprendimiento::class, 'id_emprendimiento', 'id_emprendimiento');
    }
}
