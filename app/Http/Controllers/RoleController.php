<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Mostrar la lista de roles.
     */
    public function index()
{
    $roles = Role::with(['permissions', 'objetos'])->get(); // Cargar tanto permisos globales como permisos por objeto
    return view('seguridad.roles.index', compact('roles'));
}


    /**
     * Mostrar el formulario para crear un nuevo rol.
     */
    public function create()
    {
        return view('seguridad.roles.create');
    }

    /**
     * Guardar un nuevo rol en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar el nombre del rol
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        // Crear el rol
        Role::create(['name' => $request->name]);

        return redirect()->route('roles.index')->with('mensaje', 'Rol creado con éxito.');
    }

    /**
     * Mostrar los detalles de un rol específico.
     */
    public function show($id)
    {
        $rol = Role::findOrFail($id);
        return view('seguridad.roles.show', compact('rol'));
    }

    /**
     * Mostrar el formulario para editar un rol.
     */
    public function edit($id)
    {
        $rol = Role::findOrFail($id);
        return view('seguridad.roles.edit', compact('rol'));
    }

    /**
     * Actualizar un rol existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Validar el nuevo nombre del rol
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
        ]);

        // Actualizar el nombre del rol
        $rol = Role::findOrFail($id);
        $rol->update(['name' => $request->name]);

        return redirect()->route('roles.index')->with('mensaje', 'Rol actualizado con éxito.');
    }

    /**
     * Eliminar un rol de la base de datos.
     */
    public function destroy($id)
    {
        $rol = Role::findOrFail($id);

        // Eliminar el rol
        $rol->delete();

        return redirect()->route('roles.index')->with('mensaje', 'Rol eliminado con éxito.');
    }
}

