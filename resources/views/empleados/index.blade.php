@extends('adminlte::page')

@section('title', 'Empleados')

@section('content_header')
<h1 class="text-center text-primary font-weight-bold">Lista de Empleados</h1>
@endsection

@section('content')
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

<div class="card shadow-lg rounded-3">
    <div class="card-header d-flex justify-content-start align-items-center bg-gradient-primary text-white rounded-top">
        <h3 class="card-title mr-auto">Empleados Registrados</h3>
        @can('insertar')
            <a href="{{ route('empleados.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus"></i> Agregar Empleado
            </a>
        @endcan
    </div>
    <div class="card-body">
        <table id="tablaObjetos" class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Sucursal</th>
                    <th>Área</th>
                    <th>Correo Electrónico</th>
                    <th>Teléfono</th>
                    <th>Cargo</th>
                    <th>Fecha de Contratación</th>
                    <th>Estado</th>
                    @canany(['editar', 'eliminar'])
                        <th>Acciones</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach($empleados as $empleado)
                <tr>
                    <td>{{ $empleado->cod_empleados }}</td>
                    <td>{{ $empleado->nombre_empleado }}</td>
                    <td>{{ $empleado->apellido_empleado }}</td>

                    <td>
                        @if ($empleado->sucursales)
                            {{ $empleado->sucursales->nombre_sucursal }}
                        @else
                            No tiene sucursal asignada
                        @endif
                    </td>

                    <td>
                        @if ($empleado->areas)
                            {{ $empleado->areas->nombre_area }}
                        @else
                            No tiene área asignada
                        @endif
                    </td>

                    <td>
                        @forelse ($empleado->correos as $correo)
                        <div>
                            <strong>Personal:</strong> <br> {{ $correo->correo_personal }} <br>
                        </div>

                        @if($correo->correo_profesional)
                        <div>
                            <strong>Laboral:</strong> <br> {{ $correo->correo_profesional }} <br>
                        </div>
                        @endif
                        @empty
                        No tiene correos registrados
                        @endforelse
                    </td>

                    <td>
                        @forelse ($empleado->telefonos as $telefono)
                        <div>
                            <strong>Personal:</strong> <br> {{ $telefono->telefono_personal }}
                        </div>
                        @if($telefono->telefono_trabajo)
                        <div>
                            <strong>Laboral:</strong> <br> {{ $telefono->telefono_trabajo }}
                        </div>
                        @endif
                        @empty
                        No tiene teléfonos registrados
                        @endforelse
                    </td>

                    <td>{{ $empleado->cargo_empleado }}</td>
                    <td>{{ \Carbon\Carbon::parse($empleado->fecha_contratacion)->format('d/m/Y') }}</td>
                    <td>{{ $empleado->estado_empleado }}</td>

                    @canany(['editar', 'eliminar'])
                    <td>
                        @can('editar')
                        <a href="{{ route('empleados.edit', $empleado->cod_empleados) }}" class="btn btn-warning btn-sm rounded-pill">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        @endcan
                        @can('eliminar')
                        <form action="{{ route('empleados.destroy', $empleado->cod_empleados) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('¿Estás seguro de eliminar este empleado?')">
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

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        $('#tablaObjetos').DataTable({
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

        $(document).on('click', '.delete-empleado', function() {
            var empleadoId = $(this).data('id');
            var url = '{{ route("empleados.destroy", ":id") }}';
            url = url.replace(':id', empleadoId);

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
                            Swal.fire('Eliminado!', 'El empleado ha sido eliminado.', 'success');
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'No se pudo eliminar el empleado.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
