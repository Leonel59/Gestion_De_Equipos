<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene todas las facturas con sus proveedores
        $facturas = Factura::with('proveedor')->get();
        return view('facturas.index', compact('facturas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedor::all();
        return view('facturas.create', compact('proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validación de los datos
    $request->validate([
        'id_proveedor' => 'required|exists:proveedor,id_proveedor',
        'tipo_factura' => 'required|string|max:100',
        'nombre_cliente' => 'required|string|max:100',
        'rtn_cliente' => 'required|string|max:20',
        'fecha_facturacion' => 'required|date',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'  // Validación de imagen
    ]);

    // Manejo de la carga de la imagen
    $imagenPath = null;
    if ($request->hasFile('imagen')) {
        $imagenPath = $request->file('imagen')->store('imagenes_facturas', 'public');
    }

    // Llamada al procedimiento almacenado con el nuevo parámetro de imagen
    DB::statement('CALL sp_insert_factura(?, ?, ?, ?, ?, ?)', [
        $request->id_proveedor,
        $request->tipo_factura,
        $request->nombre_cliente,
        $request->rtn_cliente,
        $request->fecha_facturacion,
        $imagenPath, // Ruta de la imagen almacenada
    ]);

    

    return redirect()->route('facturas.index')->with('success', 'Factura creada exitosamente.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cod_factura)
    {
        // Llamada al procedimiento almacenado para eliminar una factura
        DB::statement('CALL sp_delete_factura(?)', [$cod_factura]);

        
        return redirect()->route('facturas.index')->with('success', 'Factura eliminada exitosamente.');
    }

}
