<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';
    protected $fillable = [
        'id_unidad',
        'fecha',
        'producto',
        'cantidad',
        'precio'
    ];
    protected $casts = [
        'fecha' => 'datetime',
        'cantidad' => 'integer',
        'precio' => 'decimal:2'
    ];

    /**
     * Relación: Una venta pertenece a una unidad
     */
    public function unidad(): BelongsTo
    {
        return $this->belongsTo(UnidadProductiva::class, 'id_unidad', 'id_unidad');
    }
}
