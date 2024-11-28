<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\Empleado;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all(); 
        return view('seguridad.usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all(); // Obtiene todos los roles disponibles
        return view('seguridad.usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id', // Validar que el rol sea válido
        ]);

        // Crear el nuevo usuario
        $usuario = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Asignar el rol al usuario
        $role = Role::find($request->role);
        $usuario->assignRole($role);

        // Registrar en la bitácora
        $datosUsuario = [
            'name' => $usuario->name,
            'username' => $usuario->username,
            'email' => $usuario->email,
            'role' => $role->name,
        ];
        app(BitacoraController::class)->register(
            'create',
            'usuario',
            'Se creó un nuevo usuario',
            null,
            json_encode($datosUsuario)
        );

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $usuario = User::findOrFail($id);
    $roles = Role::all(); // Obtener todos los roles disponibles para la edición
    return view('seguridad.usuarios.edit', compact('usuario', 'roles'));
}

public function update(Request $request, string $id)
{
    $usuario = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $usuario->id,
        'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
        'password' => 'nullable|string|min:8|confirmed',
        // No se necesita validar el rol si no va a cambiar
    ]);

    $valoresAnteriores = [
        'name' => $usuario->name,
        'username' => $usuario->username,
        'email' => $usuario->email,
        'role' => $usuario->roles->pluck('name')->first(),
    ];

    // Actualizar solo los campos editables
    $usuario->name = $request->name;
    $usuario->username = $request->username;
    $usuario->email = $request->email;

    if ($request->password) {
        $usuario->password = bcrypt($request->password);
    }

    $usuario->save();

    // Registrar en la bitácora
    app(BitacoraController::class)->register(
        'update',
        'usuario',
        'Se actualizó un usuario',
        json_encode($valoresAnteriores),
        json_encode([
            'name' => $usuario->name,
            'username' => $usuario->username,
            'email' => $usuario->email,
            'role' => $usuario->roles->pluck('name')->first(),
        ])
    );

    return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);

        $valoresAnteriores = [
            'name' => $usuario->name,
            'username' => $usuario->username,
            'email' => $usuario->email,
            'role' => $usuario->roles->pluck('name')->first(),
        ];

        $usuario->delete();

        // Registrar en la bitácora
        app(BitacoraController::class)->register(
            'delete',
            'usuario',
            'Se eliminó un usuario',
            json_encode($valoresAnteriores),
            null
        );

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
