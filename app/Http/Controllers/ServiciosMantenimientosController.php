<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipos;
use App\Models\ServiciosMantenimientos;

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

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'create',
            'servicios_mantenimientos',
            'Se creó un nuevo Servicio: ' . $request->id_mant,
            null, // No hay valores anteriores al crear
            json_encode($request->except(['_token', '_method'])) // Valores nuevos
        );

        return redirect()->route('servicios.index')->with('info', 'Servicio de mantenimiento creado con éxito.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id_mant)
    {
        $servicio = ServiciosMantenimientos::with('equipo')->find($id_mant);
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

         // Obtener el eservicio
         $servicios_mantenimientos = ServiciosMantenimientos::findOrFail($id_mant);  // Asegúrate de que esto no devuelva una colección
         $valoresAnteriores = json_encode($servicios_mantenimientos->toArray());
        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'update',
            'servicios_mantenimientos',
            'Se actualizó un Servicio: ' . $request->id_mant,
            $valoresAnteriores,
            json_encode($request->except(['_token', '_method']))
        );

        return redirect()->route('servicios.index')->with('info', 'Servicio de mantenimiento actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id_mant)
    {
         // Obtener los datos del equipo antes de eliminarlo
         $servicios_mantenimientos = ServiciosMantenimientos::findOrFail($id_mant);

         $valoresAnteriores = json_encode($servicios_mantenimientos->toArray());

        DB::statement('CALL sp_delete_servicio_mantenimiento(?)', [$id_mant]);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'delete',
            'servicios_mantenimientos',
            'Se eliminó un Servicio: ' . $servicios_mantenimientos->id_mant,
            $valoresAnteriores,
            null // No hay nuevos valores al eliminar
        );

        return redirect()->route('servicios.index')->with('info', 'Servicio de mantenimiento eliminado con éxito.');
    }
}