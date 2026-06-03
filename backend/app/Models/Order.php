<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'numero_orden',
        'usuario_id',
        'estado',
        'subtotal',
        'impuesto_iva',
        'descuento',
        'costo_envio',
        'total',
        'nombre_cliente',
        'email_cliente',
        'direccion_facturacion',
        'ciudad_facturacion',
        'departamento_facturacion',
        'tipo_envio',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'impuesto_iva' => 'decimal:2',
        'descuento' => 'decimal:2',
        'costo_envio' => 'decimal:2',
        'total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'orden_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'orden_id');
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class, 'orden_id');
    }

    public function returns()
    {
        return $this->hasMany(ProductReturn::class, 'orden_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'orden_id');
    }

    public function orderStateHistories()
    {
        return $this->hasMany(OrderStateHistory::class, 'orden_id');
    }

    public function promotionItems()
    {
        return $this->hasMany(PromotionItem::class, 'orden_id');
    }
}
