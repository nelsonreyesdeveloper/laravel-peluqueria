<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CitasUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return auth()->user()->citas()->where('estado', 0)->orderBy('fecha_cita',"asc")->with('servicios')->get();
    }
}
