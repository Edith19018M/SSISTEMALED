<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Compra extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'id_compra';
    protected $fillable = [
        'id_unidad',
        'fecha',
        'producto',
        'cantidad',
        'costo'
    ];
    protected $casts = [
        'fecha' => 'datetime',
        'cantidad' => 'integer',
        'costo' => 'decimal:2'
    ];

    /**
     * Relación: Una compra pertenece a una unidad
     */
    public function unidad(): BelongsTo
    {
        return $this->belongsTo(UnidadProductiva::class, 'id_unidad', 'id_unidad');
    }
}
