<?php

namespace App\Http\Controllers;


use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Cargar roles con sus usuarios asignados
    $roles = Role::with('users')->get(); // Asegúrate de usar with para optimizar las consultas
    return view('seguridad.roles.index', compact('roles'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all(); // Obtener todos los roles
        $permisos = Permission::all(); // Obtener todos los permisos
        $usuarios = User::all(); // Obtener todos los usuarios

        return view('seguridad.roles.create', compact('roles', 'permisos', 'usuarios')); // Pasar roles, permisos y usuarios a la vista
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'rol' => 'required|in:admin,supervisor,usuario', // Validar el rol
            'permisos' => 'required|array',
            'usuario' => 'required|exists:users,id',
        ]);
    
        // Crear rol si no existe
        $role = Role::firstOrCreate(['name' => $request->rol]);
    
        // Asignar rol al usuario
        $user = User::findOrFail($request->usuario);
        
        if ($user->roles()->exists()) {
            return redirect()->back()->withErrors(['usuario' => 'Este usuario ya tiene un rol asignado.']);
        }
    
        $user->assignRole($role->name); // Asigna el rol
    
        // Asignar permisos si los hay
        if ($request->has('permisos')) {
            foreach ($request->permisos as $permiso) {
                // Crea el permiso si no existe
                $permission = Permission::firstOrCreate(['name' => $permiso]);
                $role->givePermissionTo($permission); // Asigna el permiso al rol
                $user->givePermissionTo($permission); // Asigna el permiso al usuario
            }
        }
    
        return redirect()->route('roles.index')->with('info', 'Rol asignado con éxito.');
    }
    


    /**
     * Display the specified resource.
     */
   // En tu controlador de roles
   public function show($id)
   {
       $rol = Role::with('permissions')->findOrFail($id);
       return view('seguridad.roles.show', compact('rol'));
   }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    // Busca el rol por su ID
    $rol = Role::findOrFail($id);
    $permisos = Permission::all(); // Obtener todos los permisos
    $usuarios = User::all(); // Obtener todos los usuarios

    // Retorna la vista de edición con el rol encontrado, permisos y usuarios
    return view('seguridad.roles.edit', compact('rol', 'permisos', 'usuarios'));
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    // Valida la entrada del formulario
    $request->validate([
        'rol' => 'required|in:admin,supervisor,usuario', // Validar el rol
        'permisos' => 'nullable|array', // Permisos pueden ser nulos
        'usuario' => 'nullable|exists:users,id', // Usuario puede ser nulo
    ]);

    // Busca el rol por su ID
    $rol = Role::findOrFail($id);

    // Verifica si el nombre del rol está cambiando
    if ($rol->name !== $request->rol) {
        // Verifica si ya existe un rol con el nuevo nombre
        $existingRole = Role::where('name', $request->rol)->first();
        if ($existingRole) {
            return redirect()->back()->withErrors(['rol' => 'El rol ya existe.'])->withInput();
        }

        // Actualiza el nombre del rol
        $rol->name = $request->rol;
    }

    $rol->save();

    // Si hay un usuario seleccionado, asigna el rol al usuario
    if ($request->usuario) {
        $user = User::findOrFail($request->usuario);
        if (!$user->hasRole($rol->name)) {
            $user->assignRole($rol->name); // Asigna el rol al usuario
        }
    }

    // Actualiza los permisos del rol
    if ($request->has('permisos')) {
        // Sincroniza los permisos solo para el usuario seleccionado
        if ($request->usuario) {
            $user = User::findOrFail($request->usuario);
            
            // Elimina permisos existentes del usuario
            $user->syncPermissions([]);
            
            foreach ($request->permisos as $permiso) {
                // Crea el permiso si no existe
                $permission = Permission::firstOrCreate(['name' => $permiso]);
                $user->givePermissionTo($permission); // Asigna el permiso al usuario
            }
        }
    }

    return redirect()->route('roles.index')->with('info', 'Rol actualizado con éxito.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Encuentra el rol por ID
        $rol = Role::find($id);
        
        if ($rol) {
            // Elimina el rol
            $rol->delete();
            
            // Redirige con mensaje de éxito
            return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
        }
        
        // Redirige con mensaje de error si no se encontró el rol
        return redirect()->route('roles.index')->with('error', 'Rol no encontrado.');
    }
    
    
}
