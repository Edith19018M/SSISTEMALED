<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    protected $fillable = [
        'id_emprendimiento',
        'nombre',
        'descripcion',
        'precio_referencial',
        'atributos'
    ];
    protected $casts = [
        'atributos' => 'json'
    ];

    /**
     * Relación: Un producto pertenece a un emprendimiento
     */
    public function emprendimiento(): BelongsTo
    {
        return $this->belongsTo(Emprendimiento::class, 'id_emprendimiento', 'id_emprendimiento');
    }
}
