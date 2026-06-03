<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'tipo_descuento',
        'valor_descuento',
        'fecha_inicio',
        'fecha_fin',
        'cantidad_usos_maximos',
        'cantidad_usos_actuales',
        'uso_minimo_compra',
        'es_activa',
    ];

    protected $casts = [
        'valor_descuento' => 'decimal:2',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'cantidad_usos_maximos' => 'integer',
        'cantidad_usos_actuales' => 'integer',
        'uso_minimo_compra' => 'decimal:2',
        'es_activa' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function promotionItems()
    {
        return $this->hasMany(PromotionItem::class, 'promocion_id');
    }

    public function userCoupons()
    {
        return $this->hasMany(UserCoupon::class, 'promocion_id');
    }
}
