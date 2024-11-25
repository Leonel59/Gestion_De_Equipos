<?php

namespace App\Http\Controllers;


use App\Models\Suministros;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuministrosController extends Controller
{
    public function index()
    {
        // Obtener todos los suministros con su relación de proveedor
        $suministros = Suministros::with('proveedor')->get();
        return view('suministros.index', compact('suministros'));
    }

    public function create()
    {
        // Obtener los datos necesarios para el formulario
        $proveedores = Proveedor::all();

        return view('suministros.create', compact('proveedores'));
    }


    public function store(Request $request)
    {
        // Validación de los datos
        $validatedData = $request->validate([
            'id_proveedor' => 'required|exists:proveedor,id_proveedor',
            'nombre_suministro' => 'required|string|max:100',
            'descripcion_suministro' => 'nullable|string|max:200',
            'fecha_adquisicion' => 'required|date',
            'cantidad_suministro' => 'required|integer|min:1',
            'costo_unitario' => 'required|numeric|min:0',
        ]);

        // Llamada al procedimiento almacenado para insertar un nuevo suministro
        DB::select('CALL sp_insert_suministro(?, ?, ?, ?, ?, ?)', [
            $request->id_proveedor,
            $request->nombre_suministro,
            $request->descripcion_suministro,
            $request->fecha_adquisicion,
            $request->cantidad_suministro,
            $request->costo_unitario,
        ]);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'create',
            'suministros',
            'Se creó un nuevo suministro: ' . $request->id_suministro,
            null, // No hay valores anteriores al crear
            json_encode($request->except(['_token', '_method'])) // Valores nuevos
        );

        return redirect()->route('suministros.index')->with('mensaje', 'Suministro agregado exitosamente!.');
    }

    public function edit($id)
    {
        $suministro = Suministros::findOrFail($id);
        $proveedores = Proveedor::all();

        return view('suministros.edit', compact('suministro', 'proveedores'));
    }

    public function update(Request $request, $id)
    {
        // Validación de los datos
        $validatedData = $request->validate([
            'id_proveedor' => 'required|exists:proveedor,id_proveedor',
            'nombre_suministro' => 'required|string|max:100',
            'descripcion_suministro' => 'nullable|string|max:200',
            'fecha_adquisicion' => 'required|date',
            'cantidad_suministro' => 'required|integer|min:1',
            'costo_unitario' => 'required|numeric|min:0',
        ]);

        // Obtener los datos del equipo antes de la actualización
        $suministros = Suministros::findOrFail($id);
        $valoresAnteriores = json_encode($suministros->toArray()); // Obtener valores anteriores


        // Llamada al procedimiento almacenado para actualizar el suministro
        DB::select('CALL sp_update_suministro(?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $request->id_proveedor,
            $request->nombre_suministro,
            $request->descripcion_suministro,
            $request->fecha_adquisicion,
            $request->cantidad_suministro,
            $request->costo_unitario,
        ]);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'update',
            'suministros',
            'Se actualizó un suministro: ' . $request->id_suministro,
            $valoresAnteriores, // Valores anteriores
            json_encode($request->except(['_token', '_method'])) // Nuevos valores
        );

        return redirect()->route('suministros.index')->with('mensaje', 'Suministro actualizado exitosamente!.');
    }

    public function destroy($id)
    {
        try {

            $suministros = Suministros::findOrFail($id);
            $valoresAnteriores = json_encode($suministros->toArray());

            // Llamada al procedimiento almacenado para eliminar el suministro
            DB::select('CALL sp_delete_suministro(?)', [$id]);

            // Registrar la acción en la bitácora
            app(BitacoraController::class)->register(
                'delete',
                'suministros',
                'Se eliminó un suministro: ' . $suministros->id_suministro,
                $valoresAnteriores,
                null // No hay nuevos valores al eliminar
            );


            return redirect()->route('suministros.index')->with('mensaje', 'Suministro eliminado exitosamente!.');
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->route('suministros.index')->with('error', 'Ocurrió un error al eliminar el suministro: ' . $e->getMessage());
        }
    }

    
    
}