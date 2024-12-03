@extends('adminlte::page')

@section('title', 'Empleados')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
<style>
    .badge-permission {
        font-size: 0.85em;
        margin: 2px;
        padding: 5px 10px;
        color: #fff;
    }
    .badge-primary { background-color: #007bff; }
    .badge-secondary { background-color: #6c757d; }

    .btn-create-employee {
        border-radius: 50px;
        padding: 10px 30px;
        font-size: 1.1em;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    .btn-create-employee:hover {
        background-color: #17a2b8;
        color: #fff;
    }

    .header-title {
        font-family: 'Roboto', sans-serif;
        font-size: 2em;
        font-weight: bold;
        color: #343a40;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }
</style>
@stop

@section('content_header')
<h1 class="text-center header-title">Gestión de Empleados</h1>
<hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
@can('empleados.ver')

    <!-- Botón para crear nuevo empleado -->
    @can('empleados.insertar')
        <a href="{{ route('empleados.create') }}" class="btn btn-outline-info btn-block text-center btn-create-employee mb-4">
            <span>Agregar Nuevo Empleado</span> <i class="fas fa-plus-circle"></i>
        </a>
    @endcan

    <!-- Tabla de empleados -->
    <div class="table-responsive-sm mt-5">
        <table id="tablaEmpleados" class="table table-striped table-bordered table-condensed table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Sucursal</th>
                    <th>Área</th>
                    <th>Correo Electrónico</th>
                    <th>Teléfono</th>
                    <th>Cargo</th>
                    <th>Fecha de Contratación</th>
                    <th>Estado</th>
                    @canany(['empleados.editar', 'empleados.eliminar'])
                        <th>Opciones</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->nombre_empleado }}</td>
                        <td>{{ $empleado->apellido_empleado }}</td>
                        <td>{{ $empleado->sucursales->nombre_sucursal ?? 'No asignada' }}</td>
                        <td>{{ $empleado->areas->nombre_area ?? 'No asignada' }}</td>
                        <td>
                            @foreach($empleado->correos as $correo)
                                <span class="d-block"><strong>Personal:</strong> {{ $correo->correo_personal }}</span>
                                @if($correo->correo_profesional)
                                    <span class="d-block"><strong>Laboral:</strong> {{ $correo->correo_profesional }}</span>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($empleado->telefonos as $telefono)
                                <span class="d-block"><strong>Personal:</strong> {{ $telefono->telefono_personal }}</span>
                                @if($telefono->telefono_trabajo)
                                    <span class="d-block"><strong>Laboral:</strong> {{ $telefono->telefono_trabajo }}</span>
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $empleado->cargo_empleado }}</td>
                        <td>{{ \Carbon\Carbon::parse($empleado->fecha_contratacion)->format('d/m/Y') }}</td>
                        <td>{{ $empleado->estado_empleado }}</td>
                        @canany(['empleados.editar', 'empleados.eliminar'])
                            <td>
                                @can('empleados.editar')
                                    <a href="{{ route('empleados.edit', $empleado->cod_empleados) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> 
                                    </a>
                                @endcan
                                @can('empleados.eliminar')
                                    <form action="{{ route('empleados.destroy', $empleado->cod_empleados) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este empleado?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <!-- Mensaje de permiso denegado -->
    <div class="card border-light shadow-sm mt-3 text-center">
        <div class="card-body">
            <i class="fas fa-lock text-danger mb-2" style="font-size: 2rem;"></i>
            <p class="mb-0" style="font-size: 1.1rem; color: #9e9e9e;">No tienes permiso para ver esta información.</p>
        </div>
    </div>
@endcan
@stop

@section('js')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tablaEmpleados').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            }
        });
    });
</script>
@stop

