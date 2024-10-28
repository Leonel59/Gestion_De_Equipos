<?php

namespace App\Http\Controllers;

use App\Models\Equipos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EquiposController extends Controller
{
    public function index()
    {
        $equipos = Equipos::with('usuario')->get();
        return view('equipos.index', compact('equipos'));
    }

    public function create()
    {
        return view('equipos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cod_equipo' => 'required|unique:equipos,cod_equipo|max:10',
            'estado_equipo' => 'required|string|max:20',
            'tipo_equipo' => 'required|string|max:20',
            'numero_serie' => 'nullable|string|max:255',
            'marca_equipo' => 'nullable|string|max:255',
            'modelo_equipo' => 'nullable|string|max:255',
            'precio_equipo' => 'nullable|numeric',
            'fecha_adquisicion' => 'nullable|date',
            'depreciacion_equipo' => 'nullable|numeric',
        ]);
    
        DB::statement('CALL sp_create_equipo(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->cod_equipo,
            $request->estado_equipo,
            $request->tipo_equipo,
            $request->numero_serie,
            $request->marca_equipo,
            $request->modelo_equipo,
            $request->precio_equipo,
            $request->fecha_adquisicion,
            $request->depreciacion_equipo,
            Auth::id(),
        ]);
    
        // Registrar en la bitácora sin el token
        $data = $request->except('_token'); // Excluyendo el token
        $this->register('Crear', 'equipos', 'Se creó un nuevo equipo.', null, json_encode($data));
    
        return redirect()->route('equipos.index')->with('info', 'Equipo creado con éxito.');
    }
    public function edit(string $cod_equipo)
    {
        $equipo = Equipos::where('cod_equipo', $cod_equipo)->firstOrFail();
        return view('equipos.edit', compact('equipo'));
    }

    public function update(Request $request, string $cod_equipo)
{
    $request->validate([
        'cod_equipo' => 'required|max:10|unique:equipos,cod_equipo,' . $cod_equipo . ',cod_equipo',
        'estado_equipo' => 'required|string|max:20',
        'tipo_equipo' => 'required|string|max:20',
        'numero_serie' => 'nullable|string|max:255',
        'marca_equipo' => 'nullable|string|max:255',
        'modelo_equipo' => 'nullable|string|max:255',
        'precio_equipo' => 'nullable|numeric',
        'fecha_adquisicion' => 'nullable|date',
        'depreciacion_equipo' => 'nullable|numeric',
    ]);

    $equipo = Equipos::where('cod_equipo', $cod_equipo)->firstOrFail();

    // Guardar valores anteriores para la bitácora
    $valores_anteriores = json_encode($equipo);
    
    $equipo->cod_equipo = $request->cod_equipo;
    $equipo->estado_equipo = $request->estado_equipo;
    $equipo->tipo_equipo = $request->tipo_equipo;
    $equipo->numero_serie = $request->numero_serie;
    $equipo->marca_equipo = $request->marca_equipo;
    $equipo->modelo_equipo = $request->modelo_equipo;
    $equipo->precio_equipo = $request->precio_equipo;
    $equipo->fecha_adquisicion = $request->fecha_adquisicion;
    $equipo->depreciacion_equipo = $request->depreciacion_equipo;

    $equipo->save();

    // Registrar en la bitácora sin el token
    $data = $request->except('_token'); // Excluyendo el token
    $this->register('Actualizar', 'equipos', 'Se actualizó un equipo.', $valores_anteriores, json_encode($data));

    return redirect()->route('equipos.index')->with('info', 'Equipo actualizado con éxito.');
}

    public function destroy(string $cod_equipo)
    {
        $equipo = Equipos::where('cod_equipo', $cod_equipo)->firstOrFail();

        // Guardar valores para la bitácora
        $valores_nuevos = json_encode($equipo);
        $equipo->delete();

        // Registrar en la bitácora
        $this->register('Eliminar', 'equipos', 'Se eliminó un equipo.', $valores_nuevos, null);

        return redirect()->route('equipos.index')->with('info', 'Equipo eliminado con éxito.');
    }

    protected function register($accion, $tabla, $descripcion, $valores_anteriores = null, $valores_nuevos = null)
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
}
