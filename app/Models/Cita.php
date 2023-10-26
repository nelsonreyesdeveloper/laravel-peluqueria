<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fecha_cita',
        'hora_cita',
        'total',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function servicios(){
        return $this->belongsToMany(Servicio::class , 'citas_servicios')->withPivot('subtotal', 'cantidad');
    }
}
