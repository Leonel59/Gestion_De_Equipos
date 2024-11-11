<?php

namespace App\Http\Controllers;

use App\Models\Asignaciones;
use App\Models\Empleado; // Asegúrate de incluir el modelo de empleados
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsignacionesController extends Controller
{
    public function index()
    {
        $asignaciones = Asignaciones::with('empleado')->get();
        return view('asignaciones.index', compact('asignaciones'));
    }

    public function create()
    {
        $empleados = Empleado::all();
        return view('asignaciones.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cod_empleados' => 'required|exists:empleados,cod_empleado',
            'sucursal' => 'required|string|max:100',
            'detalle_asignacion' => 'required|string|max:100',
            'fecha_asignacion' => 'nullable|date',
            'fecha_devolucion' => 'nullable|date',
        ]);

        // Llamada al procedimiento almacenado para insertar la asignación
        DB::statement('CALL sp_insert_asignacion(?, ?, ?, ?, ?)', [
            $request->cod_empleados,
            $request->sucursal,
            $request->detalle_asignacion,
            $request->fecha_asignacion,
            $request->fecha_devolucion,
        ]);

        return redirect()->route('asignaciones.index')->with('success', 'Asignación creada exitosamente.');
    }

    public function edit($id_asignacion)
    {
        $asignacion = Asignaciones::findOrFail($id_asignacion);
        $empleados = Empleado::all();
        return view('asignaciones.edit', compact('asignacion', 'empleados'));
    }

    public function update(Request $request, $id_asignacion)
    {
        $request->validate([
            'cod_empleados' => 'required|exists:empleados,cod_empleados',
            'sucursal' => 'required|string|max:100',
            'detalle_asignacion' => 'required|string|max:100',
            'fecha_asignacion' => 'nullable|date',
            'fecha_devolucion' => 'nullable|date',
        ]);

        // Llamada al procedimiento almacenado para actualizar la asignación
        DB::statement('CALL sp_update_asignacion(?, ?, ?, ?, ?, ?)', [
            $id_asignacion,
            $request->cod_empleados,
            $request->sucursal,
            $request->detalle_asignacion,
            $request->fecha_asignacion,
            $request->fecha_devolucion,
        ]);

        return redirect()->route('asignaciones.index')->with('success', 'Asignación actualizada exitosamente.');
    }

    public function destroy($id_asignacion)
    {
        // Llamada al procedimiento almacenado para eliminar la asignación
        DB::statement('CALL sp_delete_asignacion(?)', [$id_asignacion]);

        return redirect()->route('asignaciones.index')->with('success', 'Asignación eliminada exitosamente.');
    }
}