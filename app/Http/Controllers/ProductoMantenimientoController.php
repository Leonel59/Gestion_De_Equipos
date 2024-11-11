<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductoMantenimiento;
use App\Models\ServiciosMantenimientos;

class ProductoMantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los productos de mantenimiento, incluyendo los servicios de mantenimiento y sus equipos
        $productos = ProductoMantenimiento::with('servicioMantenimiento')->get();
        return view('productos.index', compact('productos'));
    }
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todos los servicios de mantenimiento para seleccionarlos
        $servicios = ServiciosMantenimientos::all();
        return view('productos.create', compact('servicios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos del producto
        $request->validate([
            'nombre_producto' => 'required|string|max:100',
            'descripcion_producto' => 'required|string|max:200',
            'cantidad_producto' => 'nullable|integer',
            'costo_producto' => 'nullable|numeric',
            'fecha_adquisicion_producto' => 'nullable|date',
            'servicio_mantenimiento_id' => 'required|exists:servicios_mantenimientos,id_mant', // Asegura que el servicio exista
        ]);

        // Crear el producto de mantenimiento
        ProductoMantenimiento::create([
            'nombre_producto' => $request->nombre_producto,
            'descripcion_producto' => $request->descripcion_producto,
            'cantidad_producto' => $request->cantidad_producto ?? 0,
            'costo_producto' => $request->costo_producto ?? 0,
            'fecha_adquisicion_producto' => $request->fecha_adquisicion_producto,
            'servicio_mantenimiento_id' => $request->servicio_mantenimiento_id,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto de mantenimiento creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Obtener el producto y los servicios de mantenimiento
        $producto = ProductoMantenimiento::findOrFail($id);
        $servicios = ServiciosMantenimientos::all();
        return view('productos.edit', compact('producto', 'servicios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos del producto
        $request->validate([
            'nombre_producto' => 'required|string|max:100',
            'descripcion_producto' => 'required|string|max:200',
            'cantidad_producto' => 'nullable|integer',
            'costo_producto' => 'nullable|numeric',
            'fecha_adquisicion_producto' => 'nullable|date',
            'servicio_mantenimiento_id' => 'required|exists:servicios_mantenimientos,id_mant',
        ]);

        // Buscar el producto
        $producto = ProductoMantenimiento::findOrFail($id);

        // Actualizar el producto de mantenimiento
        $producto->update([
            'nombre_producto' => $request->nombre_producto,
            'descripcion_producto' => $request->descripcion_producto,
            'cantidad_producto' => $request->cantidad_producto ?? 0,
            'costo_producto' => $request->costo_producto ?? 0,
            'fecha_adquisicion_producto' => $request->fecha_adquisicion_producto,
            'servicio_mantenimiento_id' => $request->servicio_mantenimiento_id,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto de mantenimiento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Eliminar el producto de mantenimiento
        $producto = ProductoMantenimiento::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto de mantenimiento eliminado exitosamente.');
    }
}
