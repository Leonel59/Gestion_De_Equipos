<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objeto;
use Spatie\Permission\Models\Permission; 
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
        // Eliminar espacios adicionales
        $request->merge([
            'objeto' => trim($request->objeto), 
            'descripcion' => trim($request->descripcion)
        ]);
    
        $request->validate([
            'objeto' => [
                'required',
                'unique:objetos,objeto',
                'min:5',
                'max:255',
                'regex:/^[A-Z][a-zA-Z]*$/', // Inicia con mayúscula y solo permite letras sin espacios
                'not_regex:/[0-9]/', // No permite números
                'between:5,10' // La longitud debe estar entre 5 y 10 caracteres
            ],
            'descripcion' => [
                'required',
                'min:5',
                'max:255',
                'regex:/^[a-zA-Z\s]*$/', // Solo permite letras y espacios
                'not_regex:/(palabra1|palabra2|palabra3)/i', // No permite ciertas palabras
                'not_regex:/^[A-Z\s]*$/' // No permite que toda la descripción esté en mayúsculas
            ],
        ], [
            'objeto.required' => 'El nombre del objeto es obligatorio.',
            'objeto.unique' => 'Este objeto ya está registrado.',
            'objeto.min' => 'El nombre del objeto debe tener al menos 5 caracteres.',
            'objeto.max' => 'El nombre del objeto no puede superar los 255 caracteres.',
            'objeto.regex' => 'El nombre del objeto debe iniciar con una letra mayúscula y no puede contener espacios.',
            'objeto.not_regex' => 'El nombre del objeto no puede contener números.',
            'objeto.between' => 'El nombre del objeto debe tener entre 5 y 10 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 5 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
            'descripcion.regex' => 'La descripción solo puede contener letras y espacios.',
            'descripcion.not_regex' => 'La descripción no puede contener ciertas palabras o estar completamente en mayúsculas.',
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
            null,
            json_encode($request->except(['_token', '_method']))
        );

$permisos=[
'VER_'.$request->objeto,
'INSERTAR_'.$request->objeto,
'EDITAR_'.$request->objeto,
'ELIMINAR_'.$request->objeto,

];

foreach($permisos as $permiso){
    Permission::create(['name'=>$permiso,'guard_name'=>'web']);
}
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
            'objeto' => [
                'required',
                "unique:objetos,objeto,{$id}",
                'min:5',
                'max:255',
                'regex:/^[A-Z][a-zA-Z]*$/', // Inicia con mayúscula y solo permite letras sin espacios
            ],
            'descripcion' => [
                'required',
                'min:5',
                'max:255',
                'regex:/^[a-zA-Z\s]*$/', // Solo permite letras y espacios
            ],
        ], [
            'objeto.required' => 'El nombre del objeto es obligatorio.',
            'objeto.unique' => 'Este objeto ya está registrado.',
            'objeto.min' => 'El nombre del objeto debe tener al menos 5 caracteres.',
            'objeto.max' => 'El nombre del objeto no puede superar los 255 caracteres.',
            'objeto.regex' => 'El nombre del objeto debe iniciar con una letra mayúscula y no puede contener espacios ni caracteres especiales.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 5 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
            'descripcion.regex' => 'La descripción solo puede contener letras y espacios, sin caracteres especiales.',
        ]);

        // Buscar el objeto por su ID
        $objeto = Objeto::findOrFail($id);
        
        // Comprobar si los datos han cambiado
        if ($objeto->objeto == $request->objeto && $objeto->descripcion == $request->descripcion) {
            return redirect()->back()
                ->withErrors(['edit' => 'Edite los campos necesarios.'])
                ->withInput();
        }

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
            $valoresAnteriores,
            json_encode($request->except(['_token', '_method']))
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
            $valoresAnteriores,
            null
        );

        return redirect()->route('objetos.index')->with('info', 'Objeto eliminado con éxito.');
    }
}

