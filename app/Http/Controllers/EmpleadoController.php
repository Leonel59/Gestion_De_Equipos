<?php 

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return view('empleados.index', compact('empleados'));
    }

    // Método para almacenar un nuevo empleado
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'cod_empleado' => 'required|string|unique:empleados,cod_empleado',
            'correo' => 'required|email|unique:empleados,correo',
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
            'sucursal' => 'nullable|string',
            'area' => 'nullable|string',
            'dni_empleado' => 'required|string|unique:empleados,dni_empleado',
            'nombre_empleado' => 'required|string',
            'apellido_empleado' => 'required|string',
            'cargo_empleado' => 'required|string',
            'fecha_contratacion' => 'required|date',
            'sexo_empleado' => 'required|in:masculino,femenino,otro',
        ]);

        // Llamar al procedimiento almacenado para crear un nuevo empleado
        DB::select('CALL sp_insert_empleado(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->cod_empleado,
            $request->correo,
            $request->telefono,
            $request->direccion,
            $request->sucursal,
            $request->area,
            $request->dni_empleado,
            $request->nombre_empleado,
            $request->apellido_empleado,
            $request->cargo_empleado,
            $request->fecha_contratacion,
            $request->sexo_empleado
        ]);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'create', 
            'empleados', 
            'Se creó un nuevo empleado: ' . $request->nombre_empleado,
            null, // No hay valores anteriores al crear
            json_encode($request->except(['_token', '_method'])) // Valores nuevos
        );

        // Redirigir de vuelta con un mensaje
        return redirect()->route('empleados.index')->with('success', 'Empleado agregado exitosamente.');
    }

    public function edit(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, string $id)
    {
        // Validar los datos
        $request->validate([
            'cod_empleado' => 'required|string|unique:empleados,cod_empleado,' . $id,
            'correo' => 'required|email|unique:empleados,correo,' . $id,
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
            'sucursal' => 'nullable|string',
            'area' => 'nullable|string',
            'dni_empleado' => 'required|string|unique:empleados,dni_empleado,' . $id,
            'nombre_empleado' => 'required|string',
            'apellido_empleado' => 'required|string',
            'cargo_empleado' => 'required|string',
            'fecha_contratacion' => 'required|date',
            'sexo_empleado' => 'required|in:masculino,femenino,otro',
        ]);

        // Buscar el empleado por su ID
        $empleado = Empleado::findOrFail($id);
        $valoresAnteriores = json_encode($empleado->toArray()); // Obtener valores anteriores

        // Llamar al procedimiento almacenado para actualizar el empleado
        DB::select('CALL sp_update_empleado(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $request->cod_empleado,
            $request->correo,
            $request->telefono,
            $request->direccion,
            $request->sucursal,
            $request->area,
            $request->dni_empleado,
            $request->nombre_empleado,
            $request->apellido_empleado,
            $request->cargo_empleado,
            $request->fecha_contratacion,
            $request->sexo_empleado
        ]);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'update', 
            'empleados', 
            'Se actualizó un empleado: ' . $request->nombre_empleado,
            $valoresAnteriores, // Valores anteriores
            json_encode($request->except(['_token', '_method'])) // Excluir token y método
        );

        // Redirigir de vuelta con un mensaje
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        // Buscar el empleado por su ID
        $empleado = Empleado::findOrFail($id);
        $valoresAnteriores = json_encode($empleado->toArray()); // Obtener valores anteriores

        // Llamar al procedimiento almacenado para eliminar el empleado
        DB::select('CALL sp_delete_empleado(?)', [$id]);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'delete', 
            'empleados', 
            'Se eliminó un empleado: ' . $empleado->nombre_empleado,
            $valoresAnteriores, // Valores anteriores
            null // No hay valores nuevos al eliminar
        );

        // Redirigir de vuelta con un mensaje
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }
}


