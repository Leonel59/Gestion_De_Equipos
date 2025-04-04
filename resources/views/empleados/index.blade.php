@extends('adminlte::page')

@section('title', 'Empleados')

@section('css')

<style>
    .dataTables_filter {
        display: flex;
        align-items: center;
        gap: 10px;
        /* Espaciado entre "Buscar:" y la barra de búsqueda */
    }

    .dataTables_filter label {
        display: flex;
        align-items: center;
        font-weight: bold;
    }

    .dataTables_filter input {
        margin-left: 5px;
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .badge-permission {
        font-size: 0.85em;
        margin: 2px;
        padding: 5px 10px;
        color: #fff;
    }

    .badge-primary {
        background-color: #007bff;
    }

    .badge-secondary {
        background-color: #6c757d;
    }

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
<h1 class="text-center font-weight-bold" style="color: rgba(0, 123, 255, 0.7);">Gestión de Empleados</h1>
<hr class="bg-dark border-1 border-top border-dark">
<div class="card shadow-lg rounded-3">
    <div class="card-header d-flex justify-content-between align-items-center bg-info text-white rounded-top">
        <h3 class="card-title mr-auto">Lista de empleados</h3>
        @stop

        @section('content')
        @can('empleados.ver')

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
        <!-- Botón para crear nuevo empleado -->
        @can('empleados.insertar')
        <a href="{{ route('empleados.create') }}" class="btn btn-outline-info btn-block text-center btn-create-employee mb-4">
            <span>Agregar Nuevo Empleado</span> <i class="fas fa-plus-circle"></i>
        </a>
        @endcan

        <!-- Tabla de empleados -->
        <div class="table-responsive-sm mt-5">
            <table id="tablaEmpleados" class="table table-bordered text-center table-striped table-hover">
                <thead>
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
                        <th>Acciones</th>
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
                        <td>
                            @if($empleado->estado_empleado === 'Activo')
                            <span class="badge bg-success">Activo</span>
                            @elseif($empleado->estado_empleado === 'Inactivo')
                            <span class="badge bg-danger">Inactivo</span>
                            @elseif($empleado->estado_empleado === 'Asignado')
                            <span class="badge bg-warning text-dark">Asignado</span>
                            @else
                            <span class="badge bg-secondary">{{ $empleado->estado_empleado }}</span>
                            @endif
                        </td>


                        @canany(['empleados.editar', 'empleados.eliminar'])
                        <td>
                            @can('empleados.editar')
                            <a href="{{ route('empleados.edit', $empleado->cod_empleados) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @can('empleados.eliminar')
                            <form action="{{ route('empleados.destroy', $empleado->cod_empleados) }}" method="POST" class="delete-empleado-form" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm delete-empleado" data-id="{{ $empleado->cod_empleados }}">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <script>
        $(document).ready(function() {
            $('#tablaEmpleados').DataTable({
                searching: true, // Habilita el cuadro de búsqueda
                ordering: false, // Desactiva la ordenación automática
                paging: true, // Habilita la paginación
                info: true, // Muestra información sobre el número de registros
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    paginate: {
                        previous: "Anterior",
                        next: "Siguiente"
                    },
                    emptyTable: "No hay datos disponibles en la tabla",
                    zeroRecords: "No se encontraron coincidencias",
                    loadingRecords: "Cargando...",
                    processing: "Procesando..."
                }
            });


            $(document).on('click', '.delete-empleado', function(event) {
                event.preventDefault(); // Evita la acción predeterminada del botón
                var button = $(this);
                var form = button.closest('form'); // Encuentra el formulario más cercano
                var empleadoId = button.data('id');
                var url = '{{ route("empleados.destroy", ":id") }}'.replace(':id', empleadoId);

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás recuperar este empleado!",
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
                                    'El empleado ha sido eliminado.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'No se pudo eliminar el empleado.',
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
