<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'tipo',
        'nombre_completo',
        'direccion',
        'ciudad',
        'departamento',
        'codigo_postal',
        'telefonoContacto',
        'es_predeterminada',
    ];

    protected $casts = [
        'es_predeterminada' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
