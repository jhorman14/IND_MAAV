<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use HasFactory;

    protected $table = 'shipping_zones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'cobertura_geografica',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function shippingRates()
    {
        return $this->hasMany(ShippingRate::class, 'zona_id');
    }
}
