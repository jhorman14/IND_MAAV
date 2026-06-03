<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'orden_id',
        'numero_rastreo',
        'transportista',
        'estado_envio',
        'direccion_entrega',
        'ciudad_entrega',
        'departamento_entrega',
        'fecha_envio',
        'fecha_entrega_estimada',
        'fecha_entrega_real',
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
        'fecha_entrega_estimada' => 'datetime',
        'fecha_entrega_real' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orden_id');
    }
}
