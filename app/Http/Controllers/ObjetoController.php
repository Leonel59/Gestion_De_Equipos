<?php

namespace App\Http\Controllers;

use App\Models\Objeto;
use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class ObjetoController extends Controller
{
    /**
     * Mostrar una lista de objetos.
     */
    public function index()
    {
        $objetos = Objeto::with('roles')->get(); // Cargar objetos con los roles asociados
        return view('seguridad.objetos.index', compact('objetos'));
    }

    /**
     * Mostrar el formulario para crear un nuevo objeto.
     */
    public function create()
    {
        $roles = Role::all(); // Obtener todos los roles disponibles

        // Rutas gestionables
        $rutas = [
            'empleados' => 'Gestión de Empleados',
            'equipos' => 'Gestión de Equipos',
            'asignacion' => 'Gestion de Asignacion', 
            'mantenimiento' => 'Gestion de Mantenimiento',
            'factura' => 'Gestion de Factura', 
            'reporte' => 'Gestion de Reporte',
            'seguridad' => 'Gestión de Seguridad',
        ];

        return view('seguridad.objetos.create', compact('roles', 'rutas'));
    }

    /**
     * Guardar un nuevo objeto con permisos.
     */
    public function store(Request $request)
    {
        // Validar la entrada del formulario
        $request->validate([
            'name' => 'nullable|string|max:255|unique:objetos,name', // Ya no es obligatorio
            'roles' => 'nullable|array',
            'roles.*.id' => 'exists:roles,id',
            'roles.*.permisos' => 'array', // Validar que los permisos sean un array
        ]);

        // Si no se proporciona un nombre, generar uno automáticamente
        $name = $request->name ?? 'Objeto_' . now()->format('Ymd_His');

        // Crear el objeto
        $objeto = Objeto::create(['name' => $name]);

        // Sincronizar roles y permisos
        if ($request->has('roles')) {
            foreach ($request->roles as $roleData) {
                $role = Role::findOrFail($roleData['id']);

                // Crear o verificar los permisos seleccionados
                $permissions = [];
                if (isset($roleData['permisos'])) {
                    foreach ($roleData['permisos'] as $route => $actions) {
                        foreach ($actions as $action => $value) {
                            if ($value) { // Solo agregar permisos seleccionados
                                $permissionName = "{$route}.{$action}";
                                $permission = Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
                                $permissions[] = $permission->id;
                            }
                        }
                    }
                }

                // Asignar permisos al rol
                $role->syncPermissions($permissions);

                // Asociar rol y permisos al objeto
                $objeto->roles()->attach($role->id, [
                    'ver' => $roleData['permisos']['ver'] ?? false,
                    'insertar' => $roleData['permisos']['insertar'] ?? false,
                    'editar' => $roleData['permisos']['editar'] ?? false,
                    'eliminar' => $roleData['permisos']['eliminar'] ?? false,
                ]);
            }
        }

        return redirect()->route('objetos.index')->with('success', 'Objeto creado con éxito.');
    }

    /**
     * Mostrar un objeto específico.
     */
    public function show($id)
    {
        // Código para mostrar un objeto específico si se necesita
    }

    /**
     * Mostrar el formulario para editar un objeto.
     */
    public function edit($id)
    {
        $objeto = Objeto::with('roles.permissions')->findOrFail($id);  // Cargar roles con permisos asociados
        $roles = Role::all();

        // Rutas gestionables
        $rutas = [
            'empleados' => 'Gestión de Empleados',
            'equipos' => 'Gestión de Equipos',
            'asignacion' => 'Gestion de Asignacion', 
            'mantenimiento' => 'Gestion de Mantenimiento',
            'factura' => 'Gestion de Factura', 
            'reporte' => 'Gestion de Reporte',
            'seguridad' => 'Gestión de Seguridad',
        ];

        // Preparar los permisos existentes para cada rol
        $rolePermissions = [];
        foreach ($objeto->roles as $role) {
            foreach ($role->permissions as $permission) {
                $routeAction = explode('.', $permission->name);
                $rolePermissions[$role->id][$routeAction[0]][$routeAction[1]] = true;
            }
        }

        return view('seguridad.objetos.edit', compact('objeto', 'roles', 'rutas', 'rolePermissions'));
    }

    /**
     * Actualizar un objeto y sus permisos.
     */
    public function update(Request $request, $id)
    {
        // Validar la entrada del formulario
        $request->validate([
            'name' => 'nullable|string|max:255|unique:objetos,name',
            'roles' => 'nullable|array',
            'roles.*.id' => 'exists:roles,id',
            'roles.*.permisos' => 'array',
        ]);

        $objeto = Objeto::findOrFail($id);

        $name = $request->name ?? $objeto->name; // Conservar el nombre existente si no se proporciona uno nuevo

        // Actualizar el nombre del objeto
        $objeto->update(['name' => $name]);

        // Sincronizar roles y permisos
        if ($request->has('roles')) {
            foreach ($request->roles as $roleData) {
                $role = Role::findOrFail($roleData['id']);

                // Crear o verificar los permisos seleccionados
                $permissions = [];
                if (isset($roleData['permisos'])) {
                    foreach ($roleData['permisos'] as $route => $actions) {
                        foreach ($actions as $action => $value) {
                            if ($value) { // Solo agregar permisos seleccionados
                                $permissionName = "{$route}.{$action}";
                                $permission = Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
                                $permissions[] = $permission->id;
                            }
                        }
                    }
                }

                // Asignar permisos al rol
                $role->syncPermissions($permissions);

                // Sincronizar permisos en la tabla pivot del objeto
                $objeto->roles()->syncWithoutDetaching([$role->id => [
                    'ver' => $roleData['permisos']['ver'] ?? false,
                    'insertar' => $roleData['permisos']['insertar'] ?? false,
                    'editar' => $roleData['permisos']['editar'] ?? false,
                    'eliminar' => $roleData['permisos']['eliminar'] ?? false,
                ]]);
            }
        }

        return redirect()->route('objetos.index')->with('success', 'Objeto actualizado con éxito.');
    }

    /**
     * Eliminar un objeto.
     */
    public function destroy($id)
    {
        $objeto = Objeto::findOrFail($id);
        $objeto->delete();

        return redirect()->route('objetos.index')->with('success', 'Objeto eliminado con éxito.');
    }
}
