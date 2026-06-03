<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'usuario_id',
        'orden_id',
        'calificacion',
        'titulo',
        'comentario',
        'compra_verificada',
    ];

    protected $casts = [
        'calificacion' => 'integer',
        'compra_verificada' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'orden_id');
    }
}
