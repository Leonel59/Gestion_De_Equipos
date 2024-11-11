<?php

namespace App\Http\Controllers;
use App\Models\Areas;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    public function mostrarFormulario()
    {
        // Obtener todos los nombres de áreas con sus IDs
        $areas = Areas::select('id_area', 'nombre_area')->get();
        
        // Retornar la vista con la lista de áreas
        return view('formulario_area', compact('areas'));
    }
}
