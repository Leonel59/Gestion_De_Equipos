@extends('adminlte::page')

@section('title', 'Asignaciones')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Lista de Asignaciones</h1>
@stop

@section('content')
@can('asignacion.ver')
    <div class="card shadow-lg rounded-3">
        <div class="card-header d-flex justify-content-start align-items-center bg-gradient-primary text-white rounded-top">
            <h3 class="card-title mr-auto">Asignaciones Registradas</h3>
            @can('asignacion.insertar')
                <a href="{{ route('asignaciones.create') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-plus"></i> Agregar Asignación
                </a>
            @endcan
        </div>
        <div class="card-body">
            @if ($message = Session::get('mensaje'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>¡Éxito!</strong> {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table id="asignacionesTable" class="table table-striped table-hover rounded shadow-sm">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Equipo</th>
                        <th>Suministros</th>
                        <th>Empleado</th>
                        <th>Sucursal</th>
                        <th>Área</th>
                        <th>Detalle de Asignación</th>
                        <th>Fecha de Asignación</th>
                        <th>Fecha de Devolución</th>
                        @canany(['asignacion.editar', 'asignacion.eliminar'])
                            <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asignaciones as $asignacion)
                        <tr class="text-center">
                            <td>{{ $asignacion->equipos->cod_equipo }} - {{ $asignacion->equipos->tipo_equipo }}</td>
                            <td>
                                @if ($asignacion->suministros->isNotEmpty())
                                    <ul>
                                        @foreach ($asignacion->suministros as $suministro)
                                            <li>{{ $suministro->nombre_suministro }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    No se asignaron suministros
                                @endif
                            </td>
                            <td>
                                @if ($asignacion->equipos->tipo_equipo === 'Impresora')
                                    N/A
                                @else
                                    {{ $asignacion->empleado ? $asignacion->empleado->nombre_empleado . ' ' . $asignacion->empleado->apellido_empleado : 'Empleado no asignado' }}
                                @endif
                            </td>
                            <td>{{ $asignacion->sucursales ? $asignacion->sucursales->nombre_sucursal : 'Sucursal no asignada' }}</td>
                            <td>{{ $asignacion->areas ? $asignacion->areas->nombre_area : 'Área no asignada' }}</td>
                            <td>{{ $asignacion->detalle_asignacion }}</td>
                            <td>{{ $asignacion->fecha_asignacion ? \Carbon\Carbon::parse($asignacion->fecha_asignacion)->format('d-m-Y') : 'N/A' }}</td>
                            <td>{{ $asignacion->fecha_devolucion ? \Carbon\Carbon::parse($asignacion->fecha_devolucion)->format('d-m-Y') : 'N/A' }}</td>
                            @canany(['asignacion.editar', 'asignacion.eliminar'])
                                <td>
                                    @can('asignacion.editar')
                                        <a href="{{ route('asignaciones.edit', $asignacion->id_asignacion) }}" class="btn btn-warning btn-sm rounded-pill">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                    @endcan
                                    @can('asignacion.eliminar')
                                        <button type="button" class="btn btn-danger btn-sm rounded-pill delete-asignacion" data-id="{{ $asignacion->id_asignacion }}">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    @endcan
                                </td>
                            @endcanany
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
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
        .dataTables_paginate {
            float: none;
            text-align: center;
        }
    </style>
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#asignacionesTable').DataTable({
                searching: true,
                ordering: false,
                paging: true,
                info: true,
                language: {
                    paginate: {
                        previous: "Anterior",
                        next: "Siguiente"
                    },
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)"
                }
            });

            $(document).on('click', '.delete-asignacion', function() {
                var asignacionId = $(this).data('id');
                var url = '{{ route("asignaciones.destroy", ":id") }}'.replace(':id', asignacionId);

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás recuperar esta asignación!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminarlo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire('Eliminado!', 'La asignación ha sido eliminada.', 'success');
                                location.reload();
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', 'No se pudo eliminar la asignación.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
