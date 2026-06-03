<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStateHistory extends Model
{
    use HasFactory;

    protected $table = 'order_state_history';

    protected $fillable = [
        'orden_id',
        'estado_anterior',
        'estado_nuevo',
        'usuario_id',
        'comentario',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orden_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
