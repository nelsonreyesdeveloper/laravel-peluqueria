<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HoraController extends Controller
{
    public function store(Request $request)
    {
        /* Convertir la fecha año|mes|dia */
        $fecha = Carbon::parse($request->fecha_cita)->format('Y-m-d');
        $horas = Cita::where('fecha_cita', $fecha)->get();
        return response()->json([
            'data' => $horas
        ]);
    }
}
