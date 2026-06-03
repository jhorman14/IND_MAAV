<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $table = 'inventory_movements';

    protected $fillable = [
        'producto_id',
        'cantidad_anterior',
        'cantidad_nueva',
        'cantidad_movida',
        'motivo',
        'referencia_id',
        'referencia_tipo',
        'usuario_id',
        'notas',
    ];

    protected $casts = [
        'cantidad_anterior' => 'integer',
        'cantidad_nueva' => 'integer',
        'cantidad_movida' => 'integer',
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
}
