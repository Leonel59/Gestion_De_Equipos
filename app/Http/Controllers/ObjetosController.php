<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objeto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ObjetosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $objetos = Objeto::all();
        return view('seguridad.objetos.index', compact('objetos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seguridad.objetos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'objeto' => "required|unique:objetos,objeto|min:5|max:255", 
            'descripcion' => "required|min:5|max:255"
        ]);

        // Llamar al procedimiento almacenado para crear un nuevo objeto
        DB::select('CALL sp_insert_objeto(?, ?, ?)', [
            $request->objeto,
            $request->descripcion,
            Auth::user()->id
        ]);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'create', 
            'objetos', 
            'Se creó un nuevo objeto: ' . $request->objeto,
            null, // No hay valores anteriores al crear
            json_encode($request->except(['_token', '_method'])) // Excluir el token y método
        );

        return redirect()->route('objetos.index')->with('info', 'Objeto creado con éxito.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $objeto = Objeto::findOrFail($id);
        return view('seguridad.objetos.edit', compact('objeto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'objeto' => "required|unique:objetos,objeto,{$id}|min:5|max:255", 
            'descripcion' => 'required|min:5|max:255'
        ]);

        // Buscar el objeto por su ID
        $objeto = Objeto::findOrFail($id);
        $valoresAnteriores = json_encode($objeto->toArray()); // Obtener valores anteriores

        // Llamar al procedimiento almacenado para actualizar el objeto
        DB::select('CALL sp_update_objeto(?, ?, ?, ?)', [
            $id,
            $request->objeto,
            $request->descripcion,
            Auth::user()->id
        ]);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'update', 
            'objetos', 
            'Se actualizó un objeto: ' . $request->objeto,
            $valoresAnteriores, // Valores anteriores
            json_encode($request->except(['_token', '_method'])) // Excluir token y método
        );

        return redirect()->route('objetos.index')->with('info', 'Objeto actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $objeto = Objeto::findOrFail($id);
        $valoresAnteriores = json_encode($objeto->toArray()); // Obtener valores anteriores

        // Llamar al procedimiento almacenado para eliminar el objeto
        DB::select('CALL sp_delete_objeto(?)', [$id]);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'delete', 
            'objetos', 
            'Se eliminó un objeto: ' . $objeto->objeto,
            $valoresAnteriores, // Valores anteriores
            null // No hay valores nuevos al eliminar
        );

        return redirect()->route('objetos.index')->with('info', 'Objeto eliminado con éxito.');
    }
}
