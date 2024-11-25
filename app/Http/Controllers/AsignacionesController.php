<?php

namespace App\Http\Controllers;

use App\Models\Areas;
use App\Models\Asignaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Empleado;
use App\Models\Equipos;
use App\Models\Sucursales;
use App\Models\Suministros;

class AsignacionesController extends Controller
{
    public function index()
    {
        $asignaciones = Asignaciones::with(['equipos', 'empleado', 'sucursales', 'areas', 'empleado.areas', 'suministros'])->get();
        return view('asignaciones.index', compact('asignaciones'));
    }

    public function create()
    {
        $equipos = Equipos::where('estado_equipo', 'Disponible')->get();
        $sucursales = Sucursales::all();
        $empleados = Empleado::where('estado_empleado', 'Activo')->get();
        $suministros = Suministros::where('cantidad_suministro', '>', 0)->get();

        return view('asignaciones.create', compact('equipos', 'sucursales', 'empleados', 'suministros'));
    }

    public function store(Request $request)
    {
        $equipo = Equipos::find($request->id_equipo);

        $validatedData = $request->validate([
            'id_equipo' => 'required|exists:equipos,id_equipo',
            'id_sucursal' => 'required|exists:sucursales,id_sucursal',
            'id_area' => 'nullable|exists:areas,id_area',
            'cod_empleados' => 'nullable|exists:empleados,cod_empleados',
            'suministros' => 'nullable|array',
            'suministros.*' => 'exists:suministros,id_suministro',
            'detalle_asignacion' => 'required|string|max:100',
            'fecha_asignacion' => 'required|date',
            'fecha_devolucion' => 'required|date',
        ]);

        try {
            $cod_empleados = $request->cod_empleados;
            $id_area = $request->id_area;

            if ($equipo->tipo_equipo === 'Impresora') {
                $cod_empleados = null;
            } elseif ($equipo->tipo_equipo === 'Computadora') {
                if (!$cod_empleados || !$id_area) {
                    return redirect()->back()->withErrors(['error' => 'Debe asignar un empleado y un área para computadoras.'])->withInput();
                }
            }

            if ($equipo->estado_equipo !== 'Disponible') {
                return redirect()->back()->withErrors(['error' => 'El equipo no está disponible para asignación.'])->withInput();
            }

            if ($request->has('suministros')) {
                foreach ($request->suministros as $suministroId) {
                    $suministro = Suministros::find($suministroId);
                    if ($suministro && $suministro->cantidad_suministro > 0) {
                        $suministro->reducirCantidad(1);
                    } else {
                        return redirect()->back()->withErrors([
                            'error' => 'Cantidad insuficiente para el suministro: ' . ($suministro->nombre_suministro ?? 'Desconocido'),
                        ])->withInput();
                    }
                }
            }

            DB::statement('CALL sp_insert_asignacion(?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->id_equipo,
                $request->id_sucursal,
                $id_area,
                $cod_empleados,
                $request->id_suministro,
                $request->detalle_asignacion,
                $request->fecha_asignacion,
                $request->fecha_devolucion,
            ]);

            $equipo->estado_equipo = 'Asignado';
            $equipo->save();

            if ($empleado = Empleado::find($request->cod_empleados)) {
                $empleado->estado_empleado = 'Asignado';
                $empleado->save();
            }

            if ($request->has('suministros')) {
                $asignacion = Asignaciones::where('id_equipo', $request->id_equipo)
                    ->where('detalle_asignacion', $request->detalle_asignacion)
                    ->where('fecha_asignacion', $request->fecha_asignacion)
                    ->first();

                if ($asignacion) {
                    $asignacion->suministros()->sync($request->input('suministros'));
                } else {
                    return redirect()->back()->withErrors(['error' => 'No se pudo encontrar la asignación recién creada.'])->withInput();
                }
            }

            return redirect()->route('asignaciones.index')->with('success', 'Asignación agregada exitosamente!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al realizar la asignación.'])->withInput();
        }
    }

    public function edit($id)
{
    $asignacion = Asignaciones::findOrFail($id);

    $equipos = Equipos::where('estado_equipo', 'Disponible')
        ->where('tipo_equipo', $asignacion->equipos->tipo_equipo)
        ->orWhere('id_equipo', $asignacion->id_equipo)
        ->get();

    $empleados = Empleado::where('id_sucursal', $asignacion->id_sucursal)
        ->where(function ($query) use ($asignacion) {
            $query->where('estado_empleado', 'Activo')
                ->orWhere('cod_empleados', $asignacion->cod_empleados);
        })->get();

    $sucursales = Sucursales::all();
    $areas = Areas::where('id_area', $asignacion->id_area)->first();

    // Incluye suministros con cantidad > 0 o que ya están asignados
    $suministrosDisponibles = Suministros::where('cantidad_suministro', '>', 0)->get();
    $suministrosAsignados = Suministros::whereIn('id_suministro', $asignacion->suministros->pluck('id_suministro'))->get();
    $suministros = $suministrosDisponibles->merge($suministrosAsignados)->unique('id_suministro');

    return view('asignaciones.edit', compact('asignacion', 'equipos', 'sucursales', 'areas', 'empleados', 'suministros'));
}

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'id_equipo' => 'required|exists:equipos,id_equipo',
        'id_sucursal' => 'required|exists:sucursales,id_sucursal',
        'cod_empleados' => 'nullable|exists:empleados,cod_empleados',
        'id_area' => 'nullable|exists:areas,id_area',
        'detalle_asignacion' => 'required|string|max:100',
        'fecha_asignacion' => 'required|date',
        'fecha_devolucion' => 'nullable|date',
        'suministros' => 'array',
        'suministros.*' => 'exists:suministros,id_suministro',
    ]);

    $asignacion = Asignaciones::findOrFail($id);

    try {
        DB::beginTransaction();

        // Verificar y actualizar el equipo asignado
        if ($asignacion->id_equipo !== $request->id_equipo) {
            $equipoAnterior = Equipos::find($asignacion->id_equipo);
            if ($equipoAnterior) {
                $equipoAnterior->estado_equipo = 'Disponible';
                $equipoAnterior->save();
            }
        }

        $equipo = Equipos::findOrFail($request->id_equipo);
        $equipo->estado_equipo = 'Asignado';
        $equipo->save();

        // Actualizar el estado del empleado si cambió
        if ($asignacion->cod_empleados !== $request->cod_empleados) {
            $empleadoAnterior = Empleado::find($asignacion->cod_empleados);
            if ($empleadoAnterior) {
                $empleadoAnterior->estado_empleado = 'Activo';
                $empleadoAnterior->save();
            }
        }

        if ($request->cod_empleados) {
            $empleado = Empleado::findOrFail($request->cod_empleados);
            $empleado->estado_empleado = 'Asignado';
            $empleado->save();
        }

        // Manejo de suministros
        $suministrosActuales = $asignacion->suministros->pluck('id_suministro')->toArray();
        $suministrosNuevos = $request->input('suministros', []);

        // Incrementar cantidades para suministros eliminados
        $suministrosEliminados = array_diff($suministrosActuales, $suministrosNuevos);
        foreach ($suministrosEliminados as $idSuministro) {
            $suministro = Suministros::find($idSuministro);
            if ($suministro) {
                $suministro->aumentarCantidad(1);
            }
        }

        // Reducir cantidades para nuevos suministros
        $suministrosAñadidos = array_diff($suministrosNuevos, $suministrosActuales);
        foreach ($suministrosAñadidos as $idSuministro) {
            $suministro = Suministros::find($idSuministro);
            if ($suministro && $suministro->cantidad_suministro >= 1) {
                $suministro->reducirCantidad(1);
            } else {
                return redirect()->back()->withErrors([
                    'error' => 'Cantidad insuficiente para el suministro: ' . ($suministro->nombre_suministro ?? 'Desconocido'),
                ])->withInput();
            }
        }

        // Actualizar la asignación
        $asignacion->update([
            'id_equipo' => $request->id_equipo,
            'id_sucursal' => $request->id_sucursal,
            'cod_empleados' => $request->cod_empleados,
            'id_area' => $request->id_area,
            'detalle_asignacion' => $request->detalle_asignacion,
            'fecha_asignacion' => $request->fecha_asignacion,
            'fecha_devolucion' => $request->fecha_devolucion,
        ]);

        // Sincronizar suministros
        $asignacion->suministros()->sync($suministrosNuevos);

        DB::commit();

        return redirect()->route('asignaciones.index')->with('success', 'Asignación actualizada correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => 'Ocurrió un error al actualizar la asignación: ' . $e->getMessage()])->withInput();
    }
}

    public function destroy(string $id)
    {
        try {
            $asignacion = Asignaciones::findOrFail($id);

            $equipo = Equipos::find($asignacion->id_equipo);
            if ($equipo) {
                $equipo->estado_equipo = 'Disponible';
                $equipo->save();
            }

            $empleado = Empleado::find($asignacion->cod_empleados);
            if ($empleado) {
                $empleado->estado_empleado = 'Activo';
                $empleado->save();
            }

            foreach ($asignacion->suministros as $suministro) {
                $suministro->aumentarCantidad(1);
            }

            DB::select('CALL sp_delete_asignacion(?)', [$id]);

            return redirect()->route('asignaciones.index')->with('mensaje', 'Asignación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('asignaciones.index')->with('error', 'Ocurrió un error al eliminar la asignación: ' . $e->getMessage());
        }
    }

    public function mostrarDetalles($id_asignacion)
    {
        $asignacion = Asignaciones::with(['equipos', 'sucursales', 'empleado'])
            ->where('id_asignacion', $id_asignacion)
            ->firstOrFail();

        return view('asignaciones.detalles', compact('asignacion'));
    }

    public function getEmpleadosBySucursal($id_sucursal)
    {
        $empleados = Empleado::where('id_sucursal', $id_sucursal)
            ->where('estado_empleado', 'Activo')
            ->get();

        return response()->json($empleados);
    }

    public function getEmpleadoArea($id)
    {
        $empleado = Empleado::with('areas')->find($id);

        if (!$empleado) {
            return response()->json([
                'success' => false,
                'message' => 'Empleado no encontrado',
            ]);
        }

        if (!$empleado->areas) {
            return response()->json([
                'success' => false,
                'message' => 'Área no asignada para este empleado.',
            ]);
        }

        return response()->json([
            'success' => true,
            'areas' => $empleado->areas,
        ]);
    }
    public function getAreasBySucursal(Request $request, $idSucursal)
{
    if ($request->has('empleado_id') && $request->empleado_id) {
        $empleado = Empleado::with('areas')->find($request->empleado_id);

        if ($empleado && $empleado->areas) {
            return response()->json([
                'success' => true,
                'areas' => [$empleado->areas],
                'selected_area' => $empleado->areas->id_area,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'El empleado no tiene un área asignada.',
        ]);
    }

    $areas = Areas::where('id_sucursal', $idSucursal)->get();

    return response()->json([
        'success' => true,
        'areas' => $areas,
        'selected_area' => null,
    ]);
}

    
}
