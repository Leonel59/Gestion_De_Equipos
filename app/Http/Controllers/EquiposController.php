<?php

namespace App\Http\Controllers;

use App\Models\Equipos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class EquiposController extends Controller
{
    public function index()
    {
        // Obtener todos los equipos junto con sus propiedades correspondientes
        $equipos = Equipos::all();
        return view('equipos.index', compact('equipos'));
    }


    public function create()
    {
        // Obtener los datos necesarios para el formulario
        $equipos = Equipos::all();

        return view('equipos.create', compact('equipos'));
    }

    public function store(Request $request)
    {
        // Validaciones de datos
        $validatedData = $request->validate([
            'estado_equipo' => 'required|string',
            'tipo_equipo' => 'required|string',
            'cod_equipo' => 'required|unique:equipos,cod_equipo',
            'marca_equipo' => 'required|string|max:50',
            'modelo_equipo' => 'required|string|max:50',
            'numero_serie' => 'required|string|max:50',
            'precio_equipo' => 'required|numeric',
            'fecha_adquisicion' => 'required|date',
            // Validaciones para propiedades específicas dependiendo del tipo
            'serie_cargador_comp' => 'required_if:tipo_equipo,Computadora',
            'procesador_comp' => 'required_if:tipo_equipo,Computadora',
            'memoria_comp' => 'required_if:tipo_equipo,Computadora',
            'tarjeta_grafica_comp' => 'nullable|string|max:255',
            'tipodisco_comp' => 'required_if:tipo_equipo,Computadora',
            'sistema_operativo_comp' => 'required_if:tipo_equipo,Computadora',
            'tipo_impresora' => 'required_if:tipo_equipo,Impresora',
            'resolucion_impresora' => 'required_if:tipo_equipo,Impresora',
            'conectividad_impresora' => 'required_if:tipo_equipo,Impresora',
            // Campos para otro tipo de equipo
            'capacidad' => 'nullable|string',
            'tamano' => 'nullable|string',
            'color' => 'nullable|string',


        ]);


        // Aquí llamas al procedimiento almacenado
        DB::select('CALL sp_insert_equipos(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->estado_equipo,
            $request->tipo_equipo,
            $request->cod_equipo,
            $request->marca_equipo,
            $request->modelo_equipo,
            $request->numero_serie,
            $request->precio_equipo,
            $request->fecha_adquisicion,
            $request->serie_cargador_comp,
            $request->procesador_comp,
            $request->memoria_comp,
            $request->input('tarjeta_grafica_comp', null),
            $request->tipodisco_comp,
            $request->sistema_operativo_comp,
            $request->tipo_impresora,
            $request->resolucion_impresora,
            $request->conectividad_impresora,
            $request->capacidad,
            $request->tamano,
            $request->color
        ]);


        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'create',
            'equipos',
            'Se creó un nuevo equipo: ' . $request->cod_equipo,
            null, // No hay valores anteriores al crear
            json_encode($request->except(['_token', '_method'])) // Valores nuevos
        );
        // Redirigir de vuelta con un mensaje
        return redirect()->route('equipos.index')->with('mensaje', 'Equipo agregado correctamente.');
    }


    public function edit(string $id)
    {
        // Cargar el equipo junto con sus propiedades
        $equipo = Equipos::with(['propiedades_computadoras', 'propiedades_impresoras', 'propiedades_otroequipo'])->findOrFail($id);
        return view('equipos.edit', compact('equipo'));
    }

    // Método para actualizar un equipo
    public function update(Request $request, $id)
    {
        // Validar los datos del equipo
        $request->validate([
            'estado_equipo' => 'required|in:Disponible,En Mantenimiento,No Disponible',
            'tipo_equipo' => 'required|in:Computadora,Impresora,Otro',
            'cod_equipo' => 'required|string|unique:equipos,cod_equipo,' . $id . ',id_equipo',
            'marca_equipo' => 'required|string',
            'modelo_equipo' => 'required|string',
            'numero_serie' => 'required|string|unique:equipos,numero_serie,' . $id . ',id_equipo',
            'precio_equipo' => 'required|numeric|min:0',
            'fecha_adquisicion' => 'required|date',
            'serie_cargador_comp' => 'nullable|string|required_if:tipo_equipo,Computadora',
            'procesador_comp' => 'nullable|string|required_if:tipo_equipo,Computadora',
            'memoria_comp' => 'nullable|string|required_if:tipo_equipo,Computadora',
            'tarjeta_grafica_comp' => 'nullable|string|max:255',
            'tipodisco_comp' => 'nullable|string|required_if:tipo_equipo,Computadora',
            'sistema_operativo_comp' => 'nullable|string|required_if:tipo_equipo,Computadora',
            'tipo_impresora' => 'nullable|string|required_if:tipo_equipo,Impresora',
            'resolucion_impresora' => 'nullable|string|required_if:tipo_equipo,Impresora',
            'conectividad_impresora' => 'nullable|string|required_if:tipo_equipo,Impresora',
            'capacidad' => 'nullable|string|required_if:tipo_equipo,Otro',
            'tamano' => 'nullable|string|required_if:tipo_equipo,Otro',
            'color' => 'nullable|string|required_if:tipo_equipo,Otro',
        ]);

        // Obtener los datos del equipo antes de la actualización
        $equipos = Equipos::findOrFail($id);
        $valoresAnteriores = json_encode($equipos->toArray());

        // Llamar al procedimiento almacenado para actualizar el equipo
        DB::statement('CALL sp_update_equipos(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $request->estado_equipo,
            $request->tipo_equipo,
            $request->cod_equipo,
            $request->marca_equipo,
            $request->modelo_equipo,
            $request->numero_serie,
            $request->precio_equipo,
            $request->fecha_adquisicion,
            $request->serie_cargador_comp ?? null,
            $request->procesador_comp ?? null,
            $request->memoria_comp ?? null,
            $request->tarjeta_grafica_comp ?? null,
            $request->tipodisco_comp ?? null,
            $request->sistema_operativo_comp ?? null,
            $request->tipo_impresora ?? null,
            $request->resolucion_impresora ?? null,
            $request->conectividad_impresora ?? null,
            $request->capacidad ?? null,
            $request->tamano ?? null,
            $request->color ?? null,
        ]);


        if ($request->has('tipo_equipo') && $request->tipo_equipo !== $equipos->tipo_equipo) {
            // Si el tipo de equipo cambia, asigna valores vacíos o predeterminados a los campos comunes
            $request->merge([
                'estado_equipo' => null,
                'marca_equipo' => null,
                'modelo_equipo' => null,
                'numero_serie' => null,
                'precio_equipo' => null,
                'fecha_adquisicion' => null,
            ]);
        }
        
        // Eliminar propiedades antiguas solo si cambia el tipo de equipo
        if ($request->tipo_equipo !== 'Computadora') {
            $equipos->propiedades_computadoras()->delete();
        }
        if ($request->tipo_equipo !== 'Impresora') {
            $equipos->propiedades_impresoras()->delete();
        }
        if ($request->tipo_equipo !== 'Otro') {
            $equipos->propiedades_otroequipo()->delete();
        }

        // Crear o actualizar propiedades según el tipo de equipo actual
        if ($request->tipo_equipo === 'Computadora') {
            $equipos->propiedades_computadoras()->updateOrCreate(
                ['id_equipo' => $equipos->id_equipo],
                [
                    'serie_cargador_comp' => $request->input('serie_cargador_comp', 'N/A'),
                    'procesador_comp' => $request->input('procesador_comp'),
                    'memoria_comp' => $request->input('memoria_comp'),
                    'tarjeta_grafica_comp' => $request->input('tarjeta_grafica_comp'),
                    'tipodisco_comp' => $request->input('tipodisco_comp'),
                    'sistema_operativo_comp' => $request->input('sistema_operativo_comp'),
                ]
            );
        } elseif ($request->tipo_equipo === 'Impresora') {
            $equipos->propiedades_impresoras()->updateOrCreate(
                ['id_equipo' => $equipos->id_equipo],
                [
                    'tipo_impresora' => $request->input('tipo_impresora'),
                    'resolucion_impresora' => $request->input('resolucion_impresora'),
                    'conectividad_impresora' => $request->input('conectividad_impresora'),
                ]
            );
        } elseif ($request->tipo_equipo === 'Otro') {
            $equipos->propiedades_otroequipo()->updateOrCreate(
                ['id_equipo' => $equipos->id_equipo],
                [
                    'capacidad' => $request->input('capacidad'),
                    'tamano' => $request->input('tamano'),
                    'color' => $request->input('color'),
                ]
            );
        }

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->register(
            'update',
            'equipos',
            'Se actualizó un equipo: ' . $request->cod_equipo,
            $valoresAnteriores,
            json_encode($request->except(['_token', '_method']))
        );

        // Redirigir con un mensaje de éxito
        return redirect()->route('equipos.index')->with('mensaje', 'Se actualizó el equipo correctamente!');
    }


    // Método para eliminar un equipo
    public function destroy(string $id)
    {
        try {
            // Obtener los datos del equipo antes de eliminarlo
            $equipos = Equipos::findOrFail($id);
            if (!$equipos) {
                return redirect()->route('equipos.index')->with('error', 'El equipo no existe.');
            }

            $valoresAnteriores = json_encode($equipos->toArray());

            // Llamar al procedimiento almacenado para eliminar el equipo
            DB::select('CALL sp_delete_equipos(?)', [$id]);

            // Registrar la acción en la bitácora
            app(BitacoraController::class)->register(
                'delete',
                'equipos',
                'Se eliminó un equipo: ' . $equipos->cod_equipo,
                $valoresAnteriores,
                null // No hay nuevos valores al eliminar
            );

            // Redirigir con un mensaje de éxito
            return redirect()->route('equipos.index')->with('mensaje', 'Se eliminó el equipo correctamente!');
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->route('equipos.index')->with('error', 'Ocurrió un error al eliminar el equipo: ' . $e->getMessage());
        }
    }

    public function mostrarPropiedades($id_equipo)
    {
        // Obtener el equipo con sus propiedades específicas
        $equipo = Equipos::with(['propiedades_computadoras', 'propiedades_impresoras', 'propiedades_otroequipo'])
            ->where('id_equipo', $id_equipo) // Buscar por id_equipo
            ->firstOrFail(); // Obtiene el primer resultado o falla

        // Retornar una vista con los datos del equipo y sus propiedades
        return view('equipos.propiedades', compact('equipo'));
    }

    public function verificarCodigoEquipo(Request $request)
    {
        // Verifica si el código existe, excluyendo el equipo actual en caso de edición
        $codigoExistente = Equipos::where('cod_equipo', $request->cod_equipo)
            ->when($request->id_equipo, function ($query) use ($request) {
                $query->where('id_equipo', '!=', $request->id_equipo);
            })
            ->exists();

        return response()->json(['exists' => $codigoExistente]);
    }
}
