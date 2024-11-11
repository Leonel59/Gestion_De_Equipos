@extends('adminlte::page')

@section('title', 'Asignaciones')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Lista de Asignaciones</h1>
@stop

@section('content')
    <div class="card shadow-lg rounded-3">
        <div class="card-header d-flex justify-content-start align-items-center bg-gradient-primary text-white rounded-top">
            <h3 class="card-title mr-auto">Asignaciones Registradas</h3>
            @can('insertar') <!-- Verifica si el usuario puede agregar asignaciones -->
                <a href="{{ route('asignaciones.create') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-plus"></i> Agregar Asignación
                </a>
            @endcan
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>¡Éxito!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table id="asignacionesTable" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID Asignación</th>
                        <th>Empleado</th>
                        <th>Sucursal</th>
                        <th>Detalle de Asignación</th>
                        <th>Fecha de Asignación</th>
                        <th>Fecha de Devolución</th>
                        @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                            <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach($asignaciones as $asignacion)
                        <tr class="text-center">
                            <td>{{ $asignacion->id_asignacion }}</td>
                            <td>{{ $asignacion->empleado->cod_empleados }}</td>
                            <td>{{ $asignacion->sucursal }}</td>
                            <td>{{ $asignacion->detalle_asignacion }}</td>
                            <td>{{ $asignacion->fecha_asignacion ? \Carbon\Carbon::parse($asignacion->fecha_asignacion)->format('d-m-Y') : 'N/A' }}</td>
                            <td>{{ $asignacion->fecha_devolucion ? \Carbon\Carbon::parse($asignacion->fecha_devolucion)->format('d-m-Y') : 'N/A' }}</td>

                            @canany(['editar', 'eliminar'])
                                <td>
                                    @can('editar')
                                        <a href="{{ route('asignaciones.edit', $asignacion->id_asignacion) }}" class="btn btn-warning btn-sm rounded-pill">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                    @endcan
                                    @can('eliminar')
                                        <form action="{{ route('asignaciones.destroy', $asignacion->id_asignacion) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('¿Estás seguro de eliminar esta asignación?')">
                                                <i class="fas fa-trash"></i> Eliminar
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
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .card {
            border-radius: 15px;
        }
        .table th, .table td {
            padding: 10px;
        }
        .btn-lg {
            border-radius: 30px;
            font-size: 1.1rem;
        }
        .btn-sm {
            border-radius: 20px;
        }
        .alert {
            border-radius: 10px;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function () {
            $('#asignacionesTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop
