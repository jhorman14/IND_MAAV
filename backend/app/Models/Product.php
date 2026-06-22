<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'long_description',
        'category_id',
        'brand',
        'sku',
        'price',
        'original_price',
        'available_quantity',
        'min_purchase_quantity',
        'average_rating',
        'reviews_count',
        'status',
        'visible_public',
        'weight_kg',
        'dimensions_width_mm',
        'dimensions_depth_mm',
        'dimensions_height_mm',
        'material',
        'finish',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'weight_kg' => 'decimal:3',
        'available_quantity' => 'integer',
        'min_purchase_quantity' => 'integer',
        'average_rating' => 'decimal:2',
        'reviews_count' => 'integer',
        'visible_public' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
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
