<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServicioCollection;
use App\Http\Resources\ServicioResource;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return ServicioResource::collection(Servicio::all());
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Servicio $servicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servicio $servicio)
    {
        try {
            $servicio->nombre = $request->nombre;
            $servicio->descripcion = $request->descripcion;
            $servicio->precio = $request->precio;
            $servicio->estado = $request->estado === null ? $servicio->estado : ($request->estado == 0 || $request->estado == 1 ? $request->estado : $servicio->estado);
            $servicio->save();
            return response()->json([
                'data' => "Servicio actualizado"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicio $servicio)
    {
        $servicio->delete();

        return response()->json([
            'data' => "Servicio eliminado"
        ]);
    }
}
