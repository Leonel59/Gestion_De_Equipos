@extends('adminlte::page')

@section('title', 'Proveedor')

@section('content_header')
<h1 class="text-center font-weight-bold" style="color: rgba(0, 123, 255, 0.7);">Lista de Proveedores</h1>
@endsection

@section('content')
@can('asignacion.ver')

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
<div class="row">
    <div class="col-md-12">
        <div class="card">
        <div class="card shadow-lg rounded-3">
            <div class="card-header d-flex justify-content-between align-items-center bg-info text-white rounded-top">
            <h3 class="card-title mr-auto">Proveedores Registrados</h3>
                    @can('asignacion.insertar')
                    <a href="{{ route('proveedor.create') }}" class="btn btn-primary btn-lg">Agregar Proveedor</a>
                </div>
                @endcan
            </div>
            <div class="card-body">
                <table id="tablaObjetos" class="table table-bordered  text-center">
                    <thead>

                        <th>Nombre</th>
                        <th>RTN</th>
                        <th>Contacto</th>
                        <th>Correo Electronico</th>
                        <th>Numero de Teléfono</th>
                        <th>Dirección</th>
                        @canany(['asignacion.editar', 'asignacion.eliminar'])
                        <th>Opciones</th>
                        @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proveedores as $proveedor)
                        <tr>

                            <td>{{ $proveedor->nombre_proveedor }}</td>
                            <td>{{ $proveedor->rtn_proveedor }}</td>
                            <td>{{ $proveedor->contacto_proveedor }}</td>
                            <td class="text-wrap">
                                @forelse ($proveedor->correos as $correo)
                                <div>
                                    <span> {{ $correo->correo_personal }} </span>
                                </div>

                                @empty
                                No tiene correos registrados
                                @endforelse
                            </td>
                            <td class="text-wrap">
                                @forelse ($proveedor->telefonos as $telefono)
                                <div>

                                    <span>{{ $telefono->telefono_personal }}</span>
                                </div>

                                @empty
                                <div>No tiene teléfonos registrados</div>
                                @endforelse
                            </td>

                            <td class="text-wrap">
                                @forelse ($proveedor->direcciones as $direccion)
                                <div>
                                    <span>{{ $direccion->direccion }} - {{ $direccion->departamento }}</span>
                                </div>
                                @empty
                                <div>No tiene direcciones registradas</div>
                                @endforelse
                            </td>

                            <td>
                            @canany(['asignacion.editar', 'asignacion.eliminar'])

                            @can('asignacion.editar')
                                <a href="{{ route('proveedor.edit', $proveedor->id_proveedor) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                @endcan

                                @can('asignacion.eliminar')
                                <button type="button" class="btn btn-danger btn-sm delete-proveedor" data-id="{{ $proveedor->id_proveedor }}">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {

        $('#tablaObjetos').DataTable({
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


        $(document).on('click', '.delete-proveedor', function() {
            var proveedorId = $(this).data('id');
            var url = '{{ route("proveedor.destroy", ":id") }}';
            url = url.replace(':id', proveedorId);

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás recuperar este proveedor!",
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
                                'El proveedor ha sido eliminado.',
                                'success'
                            );
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'No se pudo eliminar el proveedor.',
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