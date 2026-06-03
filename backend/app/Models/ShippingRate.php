<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    use HasFactory;

    protected $table = 'shipping_rates';

    protected $fillable = [
        'zona_id',
        'peso_minimo',
        'peso_maximo',
        'costo',
        'tiempo_entrega_dias',
    ];

    protected $casts = [
        'peso_minimo' => 'decimal:2',
        'peso_maximo' => 'decimal:2',
        'costo' => 'decimal:2',
        'tiempo_entrega_dias' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function zone()
    {
        return $this->belongsTo(ShippingZone::class, 'zona_id');
    }
}
