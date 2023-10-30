<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaMetodoPago extends Model
{
    use HasFactory;

    protected $fillable = [
        'factura_id',
        'metodos_pago_id'
    ];
}
