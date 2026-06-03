<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    use HasFactory;

    protected $table = 'returns';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'orden_id',
        'usuario_id',
        'motivo',
        'descripcion',
        'estado',
        'fecha_solicitud',
        'fecha_recepcion',
        'fecha_procesamiento',
        'monto_reembolso',
        'notas_admin',
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_recepcion' => 'datetime',
        'fecha_procesamiento' => 'datetime',
        'monto_reembolso' => 'decimal:2',
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
