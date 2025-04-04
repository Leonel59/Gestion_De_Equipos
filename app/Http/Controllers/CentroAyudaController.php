<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CentroAyudaController extends Controller
{
    // Método que se llama cuando acceden a /centroayuda
    public function index()
    {
        return view('centroayuda.index'); // Mostramos la vista ubicada en resources/views/centroayuda/index.blade.php
    }
}
