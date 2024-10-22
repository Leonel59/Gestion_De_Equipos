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
            'parametro' => 'required|unique:parametros,parametro|min:3|max:100',
            'valor' => 'required|numeric|min:1', // Sin límite máximo
        ], [
            'parametro.required' => 'El nombre del parámetro es obligatorio.',
            'parametro.unique' => 'Este parámetro ya está registrado.',
            'parametro.min' => 'El nombre del parámetro debe tener al menos 3 caracteres.',
            'parametro.max' => 'El nombre del parámetro no puede superar los 100 caracteres.',
            'valor.required' => 'El valor es obligatorio.',
            'valor.numeric' => 'El valor debe ser un número.',
            'valor.min' => 'El valor debe ser al menos 1.',
        ]);

        // Llamar al procedimiento almacenado para insertar el nuevo parámetro
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
        // Validar los datos de entrada
        $request->validate([
            'parametro' => "required|unique:parametros,parametro,{$id}|min:3|max:100",
            'valor' => 'required|numeric|min:1', // Sin límite máximo
        ], [
            'parametro.required' => 'El nombre del parámetro es obligatorio.',
            'parametro.unique' => 'Este parámetro ya está registrado.',
            'parametro.min' => 'El nombre del parámetro debe tener al menos 3 caracteres.',
            'parametro.max' => 'El nombre del parámetro no puede superar los 100 caracteres.',
            'valor.required' => 'El valor es obligatorio.',
            'valor.numeric' => 'El valor debe ser un número.',
            'valor.min' => 'El valor debe ser al menos 1.',
        ]);
    
        // Buscar el parámetro por su ID
        $parametro = Parametro::findOrFail($id);
    
        // Verificar si los valores han cambiado
        if ($request->parametro == $parametro->parametro && $request->valor == $parametro->valor) {
            return redirect()->route('parametros.edit', $id)
                ->withErrors(['no_changes' => 'No se han realizado cambios en los campos.'])
                ->withInput();
        }
    
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
        /// Obtener el parámetro antes de eliminarlo
    $parametro = DB::table('parametros')->find($id);

    // Verificar si el parámetro existe
    if (!$parametro) {
        return redirect()->route('parametros.index')->with('error', 'Parámetro no encontrado.');
    }

    // Llamar al procedimiento almacenado para eliminar el parámetro
    DB::select('CALL sp_delete_parametro(?)', [$id]);

    // Registrar la acción en la bitácora
    app(BitacoraController::class)->register(
        'delete', 
        'parametros', 
        'Se eliminó un parámetro con ID: ' . $id,
        json_encode($parametro), // Valores anteriores al eliminar
        json_encode(['id' => $id]) // Valores eliminados
    );

        return redirect()->route('parametros.index')->with('info', 'Parámetro eliminado con éxito.');
    }
}



