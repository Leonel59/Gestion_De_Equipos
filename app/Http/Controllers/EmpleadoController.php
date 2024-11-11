<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Sucursales;
use App\Models\Areas;
use App\Models\Correos;
use App\Models\Direcciones;
use App\Models\Telefonos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    // Método para mostrar la vista y los empleados
    public function index()
    {
        $empleados = Empleado::all();
        return view('empleados.index', compact('empleados')); // Pasar datos a la vista
    }

    public function create()
    {
        // Obtener los datos necesarios para el formulario
        $empleados = Empleado::with(['correos', 'telefonos', 'direcciones', 'sucursales', 'areas'])->get();
        $sucursales = Sucursales::select('id_sucursal', 'nombre_sucursal')->get(); // Obtener sucursales
        $areas = Areas::select('id_area', 'nombre_area')->get(); // Obtener áreas
        return view('empleados.create', compact('empleados', 'sucursales', 'areas'));
    }


    public function store(Request $request)
    {
        // Validación de los datos recibidos, incluyendo múltiples direcciones
        $validatedData = $request->validate([
            'id_sucursal' => 'required|integer',
            'id_area' => 'required|integer',
            'nombre_empleado' => 'required|string|max:100',
            'apellido_empleado' => 'required|string|max:100',
            'cargo_empleado' => 'required|string|max:30',
            'estado_empleado' => 'required|string|max:60',
            'fecha_contratacion' => 'required|date',
            'correo_personal' => 'required|email|max:100',
            'correo_profesional' => 'nullable|email|max:100',
            'telefono_personal' => 'required|string|max:25',
            'telefono_trabajo' => 'nullable|string|max:25',
            'direccion' => 'required|string|max:255',
            'departamento' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
        ]);


        try {
            // Llamada al procedimiento almacenado para insertar el empleado
            DB::statement(
                'CALL sp_insert_empleados(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    $request->id_sucursal,
                    $request->id_area,
                    $request->nombre_empleado,
                    $request->apellido_empleado,
                    $request->cargo_empleado,
                    $request->estado_empleado,
                    $request->fecha_contratacion,
                    $request->correo_personal,
                    $request->correo_profesional,
                    $request->telefono_personal,
                    $request->telefono_trabajo,
                    $request->direccion,
                    $request->departamento,
                    $request->ciudad
                ]
            );


            // Registrar la acción en la bitácora
            app(BitacoraController::class)->register(
                'create',
                'empleados',
                'Se creó un nuevo empleado: ' . $request->cod_empleados,
                null, // No hay valores anteriores al crear
                json_encode($request->except(['_token', '_method'])) // Valores nuevos
            );
            // Redirigir a la vista de empleados con un mensaje de éxito
            return redirect()->route('empleados.index')->with('mensaje', 'Empleado registrado exitosamente!');
        } catch (\Exception $e) {
            DB::rollback(); // Revertir cambios en caso de error
            return redirect()->back()->with('error', 'Error al registrar el empleado: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        // Obtener el empleado junto con su correo
        $empleado = Empleado::with('correos', 'direcciones', 'telefonos')->findOrFail($id);

        // Cargar las sucursales y áreas
        $sucursales = Sucursales::all();
        $areas = Areas::where('id_sucursal', $empleado->id_sucursal)->get();

        return view('empleados.edit', compact('empleado', 'sucursales', 'areas'));
    }


    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'id_sucursal' => 'required|integer',
            'id_area' => 'required|integer',
            'nombre_empleado' => 'required|string|max:100',
            'apellido_empleado' => 'required|string|max:100',
            'cargo_empleado' => 'required|string|max:30',
            'estado_empleado' => 'required|in:Activo,Inactivo',
            'fecha_contratacion' => 'required|date',
            'correo_personal' => 'required|email|max:100',
            'correo_profesional' => 'nullable|email|max:100',
            'telefono_personal' => 'required|string|max:25',
            'telefono_trabajo' => 'nullable|string|max:25',
            'direccion' => 'required|string|max:255',
            'departamento' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
        ]);

        try {
            // Obtener el empleado por su ID
            $empleado = Empleado::findOrFail($id);  // Asegúrate de que esto no devuelva una colección
            $valoresAnteriores = json_encode($empleado->toArray());

            // Convertir campos vacíos a null para correos y teléfonos opcionales
            $correo_profesional = $request->correo_profesional ?: null;
            $telefono_trabajo = $request->telefono_trabajo ?: null;


            DB::statement('CALL sp_update_empleados(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->id_sucursal,
                $request->id_area,
                $request->nombre_empleado,
                $request->apellido_empleado,
                $request->cargo_empleado,
                $request->estado_empleado,
                $request->fecha_contratacion,
                $request->correo_personal,
                $correo_profesional,
                $request->telefono_personal,
                $telefono_trabajo,
                $request->direccion,
                $request->departamento,
                $request->ciudad
            ]);



            // Registrar la acción en la bitácora
            app(BitacoraController::class)->register(
                'update',
                'empleados',
                'Se actualizó un empleado: ' . $request->cod_empleados,
                $valoresAnteriores,
                json_encode($request->except(['_token', '_method']))
            );

            // Redirigir al índice de empleados con un mensaje de éxito
            return redirect()->route('empleados.index')->with('mensaje', 'Empleado actualizado exitosamente.');
        } catch (\Exception $e) {
            // Capturar cualquier error y devolverlo
            return back()->withErrors('Error al actualizar: ' . $e->getMessage());
        }
    }



    // Método para eliminar un empleado
    public function destroy($id)
    {
        try {
            // Obtener los datos del equipo antes de eliminarlo
            $empleados = Empleado::findOrFail($id);

            $valoresAnteriores = json_encode($empleados->toArray());

            DB::statement('CALL sp_delete_empleados(?)', [$id]);


            // Registrar la acción en la bitácora
            app(BitacoraController::class)->register(
                'delete',
                'empleados',
                'Se eliminó un empleado: ' . $empleados->cod_empleados,
                $valoresAnteriores,
                null // No hay nuevos valores al eliminar
            );
            return redirect()->route('empleados.index')->with('mensaje', 'Empleado eliminado exitosamente.!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el empleado: ' . $e->getMessage());
        }
    }

    // Método para obtener áreas según la sucursal seleccionada
    public function getAreasBySucursal(Request $request)
    {
        $areas = DB::table('areas')
            ->where('ID_SUCURSAL', $request->id_sucursal)
            ->pluck('NOMBRE_AREA', 'ID_AREA');

        return response()->json($areas);
    }
}



