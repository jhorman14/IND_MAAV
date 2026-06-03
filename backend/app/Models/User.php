<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nombre',
        'email',
        'password_hash',
        'rol',
        'estado',
        'telefono',
        'movil',
        'ubicacion_fisica',
        'email_verificado',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'email_verificado' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relaciones
    public function userAddresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function returns()
    {
        return $this->hasMany(ProductReturn::class);
    }

    public function userCoupons()
    {
        return $this->hasMany(UserCoupon::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orderStateHistories()
    {
        return $this->hasMany(OrderStateHistory::class);
    }

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'usuario_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'usuario_id');
    }
}
