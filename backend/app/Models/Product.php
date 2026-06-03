<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion',
        'precio',
        'peso',
        'dimensiones',
        'stock',
        'seo_slug',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'peso' => 'decimal:2',
        'stock' => 'integer',
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productSpecifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
