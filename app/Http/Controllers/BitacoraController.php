<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

class BitacoraController extends Controller
{
    public function index()
    {
        $bitacoras = Bitacora::with('usuario')->paginate(10);
        return view('seguridad.bitacora.index', compact('bitacoras'));
    }

    public function register($accion, $tabla, $descripcion)
    {
        Bitacora::create([
            'fecha' => now(),
            'id_usuario' => Auth::id(),
            'tabla' => $tabla,
            'accion' => $accion,
            'descripcion' => $descripcion,
        ]);
    }
}
