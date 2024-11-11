<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sucursales;

class SucursalController extends Controller
{
    public function mostrarFormulario()
    {
        // Obtener todos los nombres de sucursales con sus IDs
        $sucursales = Sucursales::select('id_sucursal', 'nombre_sucursal')->get();
        
        // Retornar la vista con la lista de sucursales
        return view('formulario_sucursal', compact('sucursales'));
    }
}
