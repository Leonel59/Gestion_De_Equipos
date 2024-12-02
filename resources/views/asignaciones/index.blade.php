@extends('adminlte::page')

@section('title', 'Asignaciones')

@section('content_header')
<h1 class="text-center font-weight-bold" style="color: rgba(0, 123, 255, 0.7);">Lista de Asignaciones</h1>
@stop

@section('content')
@can('asignacion.ver') 
    <div class="card shadow-lg rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-info text-white rounded-top">
            <h3 class="card-title mr-auto">Asignaciones Registradas</h3>
            @can('asignacion.insertar')
                <a href="{{ route('asignaciones.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Agregar Asignación
                </a>
            @endcan
        </div>
        <div class="card-body">
            @if($message = Session::get('mensaje'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: "Éxito!",
                            text: "{{$message}}",
                            icon: "success",
                            confirmButtonText: 'Aceptar',
                            width: '300px', // Ajusta el tamaño de la ventana
                            customClass: {
                                popup: 'my-popup' // Clase personalizada para estilos
                            }
                        });
                    });
                </script>
            @endif

            <table id="asignacionesTable" class="table table-bordered text-center table-striped">
                <thead>
                    <tr>
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
                    @foreach($asignaciones as $asignacion)
                    <tr>
                        <td>{{ $asignacion->equipos->cod_equipo }} - {{ $asignacion->equipos->tipo_equipo }}</td>
                        <td>
                            @if($asignacion->suministros->isNotEmpty())
                                <ul>
                                    @foreach($asignacion->suministros as $suministro)
                                        <li>{{ $suministro->nombre_suministro }} </li>
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
                                {{ $asignacion->empleado->nombre_empleado }} {{ $asignacion->empleado->apellido_empleado }}
                            @endif
                        </td>
                        <td>{{ $asignacion->sucursales ? $asignacion->sucursales->nombre_sucursal : 'Sucursal no asignada' }}</td>
                        <td>{{ $asignacion->areas ? $asignacion->areas->nombre_area : 'Área no asignada' }}</td>

                        <td>{{ $asignacion->detalle_asignacion }}</td>
                        <td>{{ $asignacion->fecha_asignacion ? \Carbon\Carbon::parse($asignacion->fecha_asignacion)->format('d-m-Y') : 'N/A' }}</td>
                        <td>{{ $asignacion->fecha_devolucion ? \Carbon\Carbon::parse($asignacion->fecha_devolucion)->format('d-m-Y') : 'N/A' }}</td>

                        <td>
                        @canany(['asignacion.editar', 'asignacion.eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                        
                            @can('asignacion.editar')
                                <a href="{{ route('asignaciones.edit', $asignacion->id_asignacion) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            @endcan

                            @can('asignacion.eliminar')
                                <button type="button" class="btn btn-danger btn-sm delete-asignacion" data-id="{{ $asignacion->id_asignacion }}">
                                    <i class="fas fa-trash"></i>
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
    <div class="card border-light shadow-sm mt-3 text-center">
        <div class="card-body">
            <i class="fas fa-lock text-danger mb-2" style="font-size: 2rem;"></i>
            <p class="mb-0" style="font-size: 1.1rem; color: #9e9e9e;">No tienes permiso para ver esta información.</p>
        </div>
    </div>
@endcan
@stop


@section('js')
<script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">


<script>
    $(document).ready(function() {
        $('#btnAgregarAsignacion').click(function() {
            $('#modalAgregarAsignacion').modal('show');
        });
        $('#asignacionesTable').DataTable({
            searching: true, // Habilita el cuadro de búsqueda
            ordering: false, // Desactiva la ordenación automática
            paging: true, // Habilita la paginación
            info: true, // Muestra información sobre el número de registros
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
            var empleadoId = $(this).data('id');
            var url = '{{ route("asignaciones.destroy", ":id") }}';
            url = url.replace(':id', empleadoId);

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás recuperar esta asignacion!",
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
                            Swal.fire(
                                'Eliminado!',
                                'La asignacion ha sido eliminada.',
                                'success'
                            );
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'No se pudo eliminar la asignacion.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

    });
</script>
@stop


@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@stop
