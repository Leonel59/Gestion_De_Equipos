<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedor.index', compact('proveedores'));
    }

    public function create()
    {
        // Obtener los datos necesarios para el formulario
        $provedor = Proveedor::with(['correos', 'telefonos', 'direcciones'])->get();
        return view('proveedor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string|max:100',
            'rtn_proveedor' => 'required|string|unique:proveedor,rtn_proveedor|max:100',
            'contacto_proveedor' => 'nullable|string|max:50',
            'correo_personal' => 'required|email|max:100',
            'correo_profesional' => 'nullable|email|max:100',
            'telefono_personal' => 'required|string|max:25',
            'telefono_trabajo' => 'nullable|string|max:25',
            'direccion' => 'required|string|max:255',
            'departamento' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
        ]);

        // Llamar al procedimiento almacenado para insertar proveedor
        DB::select('CALL sp_insert_proveedor(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->nombre_proveedor,
            $request->rtn_proveedor,
            $request->contacto_proveedor,
            $request->correo_personal,
            $request->correo_profesional,
            $request->telefono_personal,
            $request->telefono_trabajo,
            $request->direccion,
            $request->departamento,
            $request->ciudad
        ]);


         // Registrar la acción en la bitácora
         app(BitacoraController::class)->register(
            'create',
            'proveedor',
            'Se creó un nuevo proveedor: ' . $request->id_proveedor,
            null, // No hay valores anteriores al crear
            json_encode($request->except(['_token', '_method'])) // Valores nuevos
        );
        return redirect()->route('proveedor.index')->with('mensaje', 'Proveedor creado exitosamente.');
    }

    public function edit(string $id)
    {
        // Obtener el empleado junto con su correo
        $proveedor = Proveedor::with('correos', 'direcciones', 'telefonos')->findOrFail($id);
       
        return view('proveedor.edit', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string|max:100',
           'rtn_proveedor' => 'required|string|max:100|unique:proveedor,rtn_proveedor,' . $id . ',id_proveedor',
            'contacto_proveedor' => 'required|string|max:50',
            'correo_personal' => 'required|email|max:100',
            'correo_profesional' => 'nullable|email|max:100',
            'telefono_personal' => 'required|string|max:25',
            'telefono_trabajo' => 'nullable|string|max:25',
            'direccion' => 'required|string|max:255',
            'departamento' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
        ]);

        try {
            // Obtener el proveedor por su ID
            $proveedor = Proveedor::findOrFail($id);  // Asegúrate de que esto no devuelva una colección
            $valoresAnteriores = json_encode($proveedor->toArray());

            // Convertir campos vacíos a null para correos y teléfonos opcionales
            $correo_profesional = $request->correo_profesional ?: null;
            $telefono_trabajo = $request->telefono_trabajo ?: null;


            DB::statement('CALL sp_update_proveedor(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->nombre_proveedor,
                $request->rtn_proveedor,
                $request->contacto_proveedor,
                $request->correo_personal,
                $request->correo_profesional,
                $request->telefono_personal,
                $request->telefono_trabajo,
                $request->direccion,
                $request->departamento,
                $request->ciudad
            ]);



            // Registrar la acción en la bitácora
            app(BitacoraController::class)->register(
                'update',
                'proveedor',
                'Se actualizó un proveedor: ' . $request->id_proveedor,
                $valoresAnteriores,
                json_encode($request->except(['_token', '_method']))
            );

            // Redirigir al índice de proveedor con un mensaje de éxito
            return redirect()->route('proveedor.index')->with('mensaje', 'Proveedor actualizado exitosamente.');
        } catch (\Exception $e) {
            // Capturar cualquier error y devolverlo
            return back()->withErrors('Error al actualizar: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Obtener los datos del equipo antes de eliminarlo
            $proveedor = Proveedor::findOrFail($id);

            $valoresAnteriores = json_encode($proveedor->toArray());

            DB::statement('CALL sp_delete_proveedor(?)', [$id]);


            // Registrar la acción en la bitácora
            app(BitacoraController::class)->register(
                'delete',
                'proveedor',
                'Se eliminó un proveedor: ' . $proveedor->id_proveedor,
                $valoresAnteriores,
                null // No hay nuevos valores al eliminar
            );
            return redirect()->route('proveedor.index')->with('mensaje', 'Proveedor eliminado exitosamente.!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el proveedor: ' . $e->getMessage());
        }
    }
}

