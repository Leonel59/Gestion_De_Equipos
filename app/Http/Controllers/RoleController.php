<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Models\Objeto;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('seguridad.roles.index')->with('roles', $roles); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $objetos = Objeto::all();
        return view('seguridad.roles.create')->with('objetos', $objetos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'rol' => 'required|unique:roles,name|min:4|max:255',
            'permisos' => 'required'
        ]);

        // Eliminar caracteres especiales del nombre del rol
        $rolLimpio = preg_replace('/[^A-Za-z0-9_\- ]/', '', $request->rol);

        $data = [ 
            'name' => $rolLimpio // Usar el nombre limpio
        ];
    
        $rolCreado = Role::create($data);
        $permisos = Permission::whereIn('name', $request->permisos)->pluck('id');
        $rolCreado->permissions()->sync($permisos);
    
        return redirect()->route('roles.index')->with('info', 'Rol creado con éxito.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $role = Role::findOrFail($id); // Buscar el rol por ID
    $objetos = Objeto::all(); // Obtener todos los objetos
    return view('seguridad.roles.edit', compact('role', 'objetos'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validaciones
        $request->validate([
            'rol' => 'required|min:4|max:255',
            'permisos' => 'required'
        ]);
    
        // Eliminar caracteres especiales del nombre del rol
        $rolLimpio = preg_replace('/[^A-Za-z0-9_\- ]/', '', $request->rol);
    
        $role = Role::findOrFail($id); // Buscar el rol por ID
        $role->name = $rolLimpio; // Actualizar el nombre limpio
        $role->save(); // Guardar cambios
    
        $permisos = Permission::whereIn('name', $request->permisos)->pluck('id');
        $role->permissions()->sync($permisos); // Sincronizar permisos
    
        return redirect()->route('roles.index')->with('info', 'Rol actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
  
    public function destroy(string $id)
    {
        //
    }
}

