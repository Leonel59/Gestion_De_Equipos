<?php

namespace App\Http\Controllers;
use App\Models\Empleado;
use Illuminate\Http\Request;

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

         // Crear nuevo empleado
         $empleado= Empleado::create($request->all());
         app(BitacoraController::class)->register('create', 'empleado', 'Se creó un nuevo empleado: ' . $empleado->empleado);
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
    
        // Actualizar empleado con los datos validados
        $empleado->update($request->all());
        app(BitacoraController::class)->register('update', 'empleados', 'Se actualizo un nuevo empleado: ' . $empleado->empleado);
        // Redirigir de vuelta con un mensaje
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    public function destroy(string $id)
{
    // Buscar el empleado por su ID
    $empleado = Empleado::findOrFail($id);
    
    // Eliminar el empleado
    $empleado->delete();
    app(BitacoraController::class)->register('delete', 'empleados', 'Se elimino un empleado: ' . $empleado->empleado);
    // Redirigir de vuelta con un mensaje
    return redirect()->route('empleados.index')->with('success', 'Empleado eliminado exitosamente.');
}
}
