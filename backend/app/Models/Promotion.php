<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type',
        'discount_value',
        'starts_at',
        'ends_at',
        'max_uses',
        'uses_count',
        'minimum_purchase',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'max_uses' => 'integer',
        'uses_count' => 'integer',
        'minimum_purchase' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function promotionItems()
    {
        return $this->hasMany(PromotionItem::class, 'promotion_id');
    }

    public function userCoupons()
    {
        return $this->hasMany(UserCoupon::class, 'promotion_id');
    }
}
