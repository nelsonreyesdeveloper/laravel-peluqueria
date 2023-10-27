<?php

namespace App\Http\Controllers;

use App\Http\Resources\CitaCollection;
use App\Models\Cita;
use App\Models\CitasServicios;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public $horas = [
        '7:00 AM', '7:20 AM', '7:40 AM', '8:00 AM', '8:20 AM', '8:40 AM',
        '9:00 AM', '9:20 AM', '9:40 AM', '10:00 AM', '10:20 AM', '10:40 AM',
        '11:00 AM', '11:20 AM', '11:40 AM', '1:00 PM', '1:20 PM', '1:40 PM',
        '2:00 PM', '2:20 PM', '2:40 PM', '3:00 PM', '3:20 PM', '3:40 PM',
        '4:00 PM', '4:20 PM', '4:40 PM', '5:00 PM', '5:20 PM', '5:40 PM',
        '6:00 PM', '6:20 PM', '6:40 PM'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orderByExpression = '';
        foreach ($this->horas as $index => $hora) {
            $orderByExpression .= "WHEN hora_cita = '$hora' THEN $index ";
        }

        $fechaActual = Carbon::today()->format('Y-m-d');
        // Crea una instancia de Carbon con la fecha y hora actual en El Salvador
        return new CitaCollection(Cita::with('user')->with('servicios')->where('estado', 0)
            ->when($request->fecha, function ($query) use ($request) {
                $query->where('fecha_cita', $request->fecha);
            }, function ($query) use ($fechaActual) {
                $query->where('fecha_cita', $fechaActual);
            })
            ->orderByRaw("CASE $orderByExpression ELSE " . count($this->horas) . " END")->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $citaRepetida = Cita::where('hora_cita', $request->citaPost['hora_cita'])->where('fecha_cita', $request->citaPost['fecha_cita'])->get();

        if ($citaRepetida->count() > 0) {
            return response()->json(['data' => 'La hora acaba de ser registrada por otro cliente'], 400);
        }
        /* Validando que el usuario tenga solo una cita activa  */
        
        $citaActiva = auth()->user()->citas()->where('estado', 0)->get();
        
        if ($citaActiva->count() >= 2) {
            return response()->json(['data' => 'Solo puedes tener 2 citas activas'], 400);
        }

        try {
            $cita = Cita::create([
                'user_id' => auth()->user()->id,
                'fecha_cita' => $request->citaPost['fecha_cita'],
                'hora_cita' => $request->citaPost['hora_cita'],
                'total' => $request->citaPost['total']
            ]);

            foreach ($request->servicios as $servicio) {
                CitasServicios::create([
                    'cita_id' => $cita->id,
                    'servicio_id' => $servicio['id'],
                    'cantidad' => $servicio['cantidad'],
                    'subtotal' => $servicio['subtotal']
                ]);
            }

            return response()->json($cita, 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cita $cita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $cita)
    {
        $cita = Cita::find($cita);
        $cita->estado = 1;
        $cita->save();
        return response()->json(['data' => 'Cita actualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cita)
    {
        $cita = Cita::find($cita);
        $cita->delete();
        return response()->json(['data' => 'Cita eliminada'], 200);
    }
}
