<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class BitacoraController extends Controller
{
    public function index()
    {
        // Llamar al procedimiento almacenado para obtener todas las bitácoras
        $bitacorasArray = DB::select('CALL sp_get_all_bitacora()');

        // Convertir el array en una colección
        $bitacoras = collect($bitacorasArray);

        // Obtener los IDs de usuarios únicos
        $userIds = $bitacoras->pluck('id_usuario')->unique();

        // Obtener los usuarios correspondientes
        $usuarios = \App\Models\User::whereIn('id', $userIds)->get()->keyBy('id');

        // Asignar la información del usuario a cada bitácora
        foreach ($bitacoras as $bitacora) {
            $bitacora->usuario = $usuarios->get($bitacora->id_usuario);
        }

        // Paginación manual
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10; // Número de elementos por página
        $currentItems = $bitacoras->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Crear una instancia de LengthAwarePaginator
        $bitacoras = new LengthAwarePaginator($currentItems, $bitacoras->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('seguridad.bitacora.index', compact('bitacoras'));
    }

    public function register($accion, $tabla, $descripcion, $valores_anteriores = null, $valores_nuevos = null)
    {
        // Llamar al procedimiento almacenado para insertar una nueva bitácora
        DB::statement('CALL sp_insert_bitacora(?, ?, ?, ?, ?, ?, ?)', [
            now(),
            Auth::id(),
            $tabla,
            $accion,
            $descripcion,
            $valores_anteriores,
            $valores_nuevos,
        ]);
    }

    public function download($id)
{
    // Obtener la bitácora específica por ID
    $bitacora = Bitacora::findOrFail($id);
    
    // Decodificar los valores anteriores y nuevos de JSON
    $valoresAnteriores = json_decode($bitacora->valores_anteriores, true) ?? [];
    $valoresNuevos = json_decode($bitacora->valores_nuevos, true) ?? [];
    
    // Construir el contenido del archivo
    $content = "Descripción: " . $bitacora->descripcion . "\n\n";
    
    $content .= "Valores Anteriores:\n";
    if (count($valoresAnteriores) > 0) {
        foreach ($valoresAnteriores as $key => $valor) {
            $content .= "{$key}: {$valor}\n";
        }
    } else {
        $content .= "No hay valores anteriores disponibles.\n";
    }

    $content .= "\nValores Nuevos:\n";
    if (count($valoresNuevos) > 0) {
        foreach ($valoresNuevos as $key => $valor) {
            $content .= "{$key}: {$valor}\n";
        }
    } else {
        $content .= "No hay valores nuevos disponibles.\n";
    }

    // Devolver la respuesta del archivo
    return response()->stream(function() use ($content) {
        echo $content;
    }, 200, [
        'Content-Type' => 'text/plain',
        'Content-Disposition' => 'attachment; filename="bitacora_' . $bitacora->id . '_' . date('Y-m-d_H-i', time()) . '.txt"',
    ]);
}
    public function destroy($id)
    {
        // Llamar al procedimiento almacenado para eliminar una bitácora
        DB::statement('CALL sp_delete_bitacora(?)', [$id]);
        return redirect()->route('bitacoras.index')->with('success', 'Bitácora eliminada con éxito.');
    }
}


