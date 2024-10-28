<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = DB::table('proveedor')->get();
        return view('proveedor.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string|max:100',
            'rtn_proveedor' => 'required|string|unique:proveedor,rtn_proveedor|max:100',
            'contacto_proveedor' => 'nullable|string|max:50',
            'direccion_proveedor' => 'nullable|string|max:150',
            'telefono_proveedor' => 'nullable|string|max:15',
            'email_proveedor' => 'nullable|email|max:100',
        ]);

        // Llamar al procedimiento almacenado para insertar proveedor
        DB::select('CALL sp_insert_proveedor(?, ?, ?, ?, ?, ?)', [
            $request->nombre_proveedor,
            $request->rtn_proveedor,
            $request->contacto_proveedor,
            $request->direccion_proveedor,
            $request->telefono_proveedor,
            $request->email_proveedor,
        ]);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }

    public function edit($id_proveedor)
    {
        $proveedor = DB::table('proveedor')->where('id_proveedor', $id_proveedor)->first();
        return view('proveedor.edit', compact('proveedor'));
    }

    public function update(Request $request, $id_proveedor)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string|max:100',
            'rtn_proveedor' => 'required|string|unique:proveedor,rtn_proveedor,' . $id_proveedor . ',id_proveedor|max:100',
            'contacto_proveedor' => 'nullable|string|max:50',
            'direccion_proveedor' => 'nullable|string|max:150',
            'telefono_proveedor' => 'nullable|string|max:15',
            'email_proveedor' => 'nullable|email|max:100',
        ]);

        // Llamar al procedimiento almacenado para actualizar proveedor
        DB::select('CALL sp_update_proveedor(?, ?, ?, ?, ?, ?, ?)', [
            $id_proveedor,
            $request->nombre_proveedor,
            $request->rtn_proveedor,
            $request->contacto_proveedor,
            $request->direccion_proveedor,
            $request->telefono_proveedor,
            $request->email_proveedor,
        ]);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy($id_proveedor)
    {
        // Llamar al procedimiento almacenado para eliminar proveedor
        DB::select('CALL sp_delete_proveedor(?)', [$id_proveedor]);
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
    }
}
