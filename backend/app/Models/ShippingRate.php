<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    use HasFactory;

    protected $table = 'shipping_rates';

    protected $fillable = [
        'zone_id',
        'minimum_weight',
        'maximum_weight',
        'cost',
        'delivery_time_days',
    ];

    protected $casts = [
        'minimum_weight' => 'decimal:2',
        'maximum_weight' => 'decimal:2',
        'cost' => 'decimal:2',
        'delivery_time_days' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function zone()
    {
        return $this->belongsTo(ShippingZone::class, 'zone_id');
    }
}
