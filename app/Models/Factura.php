<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'pagada'
    ];

    public function metodo()
    {
        return $this->belongsToMany(MetodosPago::class, 'factura_metodo_pagos', 'factura_id', 'metodos_pago_id');
    }
}
