<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionItem extends Model
{
    use HasFactory;

    protected $table = 'promotion_items';

    protected $fillable = [
        'promocion_id',
        'orden_id',
        'monto_descuento',
    ];

    protected $casts = [
        'monto_descuento' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promocion_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'orden_id');
    }
}
