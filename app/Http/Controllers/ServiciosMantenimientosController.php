<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipos;

class ServiciosMantenimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtén todos los servicios de mantenimiento
        $servicios = DB::table('servicios_mantenimientos')->get();
        return view('mantenimiento.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $equipos = Equipos::all(); // Obtén todos los equipos
        return view('mantenimiento.create', compact('equipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_equipo_mant' => 'required|exists:equipos,cod_equipo|max:10',
            'tipo_mantenimiento' => 'required|in:Preventivo,Correctivo,Predictivo',
            'descripcion_mantenimiento' => 'required|max:200',
            'cantidad_equipo_usado' => 'nullable|integer',
            'fecha_reparacion_equipo' => 'nullable|date',
            'fecha_entrega_equipo' => 'nullable|date',
            'costo_mantenimiento' => 'nullable|numeric',
            'duracion_mantenimiento' => 'nullable|integer',
            'fecha_creacion' => 'required|date',
            'modificado_por' => 'nullable|max:100',
            'fecha_modificacion' => 'nullable|date',
        ]);

        $modificado_por = Auth::user()->name;

        DB::statement('CALL sp_insert_servicio_mantenimiento(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->id_equipo_mant,
            $request->tipo_mantenimiento,
            $request->descripcion_mantenimiento,
            $request->cantidad_equipo_usado,
            $request->fecha_reparacion_equipo,
            $request->fecha_entrega_equipo,
            $request->costo_mantenimiento,
            $request->duracion_mantenimiento,
            $request->fecha_creacion,
            $modificado_por,
            $request->fecha_modificacion,
        ]);

        return redirect()->route('servicios.index')->with('info', 'Servicio de mantenimiento creado con éxito.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id_mant)
    {
        $servicio = DB::table('servicios_mantenimientos')->where('id_mant', $id_mant)->first();
        $equipos = Equipos::all();
        return view('mantenimiento.edit', compact('servicio', 'equipos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id_mant)
    {
        $request->validate([
            'id_equipo_mant' => 'required|exists:equipos,cod_equipo|max:10',
            'tipo_mantenimiento' => 'required|in:Preventivo,Correctivo,Predictivo',
            'descripcion_mantenimiento' => 'required|max:200',
            'cantidad_equipo_usado' => 'nullable|integer',
            'fecha_reparacion_equipo' => 'nullable|date',
            'fecha_entrega_equipo' => 'nullable|date',
            'costo_mantenimiento' => 'nullable|numeric',
            'duracion_mantenimiento' => 'nullable|integer',
            'fecha_creacion' => 'required|date',
            'modificado_por' => 'nullable|max:100',
            'fecha_modificacion' => 'nullable|date',
        ]);

        $modificado_por = Auth::user()->name;

        DB::statement('CALL sp_update_servicio_mantenimiento(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id_mant,
            $request->id_equipo_mant,
            $request->tipo_mantenimiento,
            $request->descripcion_mantenimiento,
            $request->cantidad_equipo_usado,
            $request->fecha_reparacion_equipo,
            $request->fecha_entrega_equipo,
            $request->costo_mantenimiento,
            $request->duracion_mantenimiento,
            $request->fecha_creacion,
            $modificado_por,
            $request->fecha_modificacion,
        ]);

        return redirect()->route('servicios.index')->with('info', 'Servicio de mantenimiento actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id_mant)
    {
        DB::statement('CALL sp_delete_servicio_mantenimiento(?)', [$id_mant]);

        return redirect()->route('servicios.index')->with('info', 'Servicio de mantenimiento eliminado con éxito.');
    }
}
