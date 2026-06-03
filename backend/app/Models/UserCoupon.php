<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    use HasFactory;

    protected $table = 'user_coupons';

    protected $fillable = [
        'usuario_id',
        'promocion_id',
        'usado',
        'fecha_uso',
        'orden_id',
    ];

    protected $casts = [
        'usado' => 'boolean',
        'fecha_uso' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promocion_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'orden_id');
    }
}
