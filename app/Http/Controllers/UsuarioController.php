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
        return view('seguridad.usuarios.create');
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
        ]);

        // Crear el nuevo usuario
        $usuario = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Registrar en la bitácora
        $datosUsuario = [
            'name' => $usuario->name,
            'username' => $usuario->username,
            'email' => $usuario->email,
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
        return view('seguridad.usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $usuario->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $valoresAnteriores = [
            'name' => $usuario->name,
            'username' => $usuario->username,
            'email' => $usuario->email,
        ];

        $usuario->name = $request->name;
        $usuario->username = $request->username;
        $usuario->email = $request->email;

        if ($request->password) {
            $usuario->password = bcrypt($request->password);
        }

        $usuario->save();

        $valoresNuevos = [
            'name' => $usuario->name,
            'username' => $usuario->username,
            'email' => $usuario->email,
        ];

        // Registrar en la bitácora
        app(BitacoraController::class)->register(
            'update',
            'usuario',
            'Se actualizó un usuario',
            json_encode($valoresAnteriores),
            json_encode($valoresNuevos)
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
