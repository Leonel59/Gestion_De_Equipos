<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametro; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParametroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parametros = Parametro::all();
        return view('seguridad.parametros.index', compact('parametros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seguridad.parametros.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'parametro' => 'required|unique:parametros', 
            'valor' => 'required'
        ]);

        // Llamar al procedimiento almacenado para crear un nuevo parámetro
        DB::select('CALL sp_insert_parametro(?, ?, ?)', [
            $request->parametro,
            $request->valor,
            Auth::user()->id
        ]);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'create', 
            'parametros', 
            'Se creó un nuevo parámetro: ' . $request->parametro,
            null, // No hay valores anteriores al crear
            json_encode($request->except(['_token', '_method'])) // Valores nuevos
        );

        return redirect()->route('parametros.index')->with('info', 'Parámetro creado con éxito.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $parametro = Parametro::findOrFail($id);
        return view('seguridad.parametros.edit')->with('parametro', $parametro);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'parametro' => "required|unique:parametros,parametro,{$id}", 
            'valor' => 'required'
        ]);

        // Buscar el parámetro por su ID
        $parametro = Parametro::findOrFail($id);
        $valoresAnteriores = json_encode($parametro->toArray()); // Obtener valores anteriores

        // Llamar al procedimiento almacenado para actualizar el parámetro
        DB::select('CALL sp_update_parametro(?, ?, ?, ?)', [
            $id,
            $request->parametro,
            $request->valor,
            Auth::user()->id
        ]);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'update', 
            'parametros', 
            'Se actualizó un parámetro: ' . $request->parametro,
            $valoresAnteriores, // Valores anteriores
            json_encode($request->except(['_token', '_method'])) // Valores nuevos
        );

        return redirect()->route('parametros.index')->with('info', 'Parámetro actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Este método está vacío ya que no se utilizará
    }
}

