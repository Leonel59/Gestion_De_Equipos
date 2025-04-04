@extends('adminlte::page')

@section('css')
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
@stop

@section('title', 'Productos de Mantenimiento')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Productos de Mantenimiento</h1>
@stop

@section('content')
@can('mantenimiento.ver')

<div class="card shadow-lg rounded-3">
    <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white rounded-top">
        <h3 class="card-title">Lista de Productos</h3>
        @can('mantenimiento.insertar')
            <div class="ml-auto">
                <a href="{{ route('productos.create') }}" class="btn btn-primary text-white font-weight-bold">
                    <i class="fas fa-plus"></i> Agregar Producto
                </a>
            </div>
        @endcan
    </div>

    <div class="card-body">
        <!-- Mensaje de éxito con SweetAlert -->
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: "Éxito!",
                        text: "{{ session('success') }}",
                        icon: "success",
                        confirmButtonText: 'Aceptar',
                        timer: 3000
                    });
                });
            </script>
        @endif

        <div class="table-responsive-sm mt-3">
            <table id="tablaProductos" class="table table-striped table-bordered table-hover rounded shadow-sm">
                <thead class="thead-light">
                    <tr>
                        <th>Servicio de Mantenimiento</th>
                        <th>Equipo</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Costo</th>
                        <th>Fecha de Adquisición</th>
                        @canany(['mantenimiento.editar', 'mantenimiento.eliminar'])
                            <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto->servicioMantenimiento->tipo_mantenimiento ?? 'No asignado' }}</td>
                            <td>{{ $producto->servicioMantenimiento->id_equipo_mant ?? 'No asignado' }}</td>
                            <td>{{ $producto->nombre_producto }}</td>
                            <td>{{ $producto->descripcion_producto }}</td>
                            <td>{{ $producto->cantidad_producto }}</td>
                            <td>L {{ number_format($producto->costo_producto, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($producto->fecha_adquisicion_producto)->format('d/m/Y') }}</td>

                            @canany(['mantenimiento.editar', 'mantenimiento.eliminar'])
                                <td class="text-center">
                                    @can('mantenimiento.editar')
                                        <a href="{{ route('productos.edit', $producto->id_producto) }}" class="btn btn-warning btn-sm rounded-pill" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('mantenimiento.eliminar')
                                        <button class="btn btn-danger btn-sm rounded-pill delete-producto" data-id="{{ $producto->id_producto }}" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
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
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#tablaProductos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    className: 'btn btn-danger',
                }, 
                {
                    extend: 'print',
                    text: 'Imprimir',
                    className: 'btn btn-secondary'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-success'
                }
            ]
        });

        // Confirmación con SweetAlert para eliminar producto
        $(document).on('click', '.delete-producto', function() {
            var productoId = $(this).data('id');
            var url = '{{ route("productos.destroy", ":id") }}'.replace(':id', productoId);

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás recuperar este producto!",
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
                                'El producto ha sido eliminado.',
                                'success'
                            );
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'No se pudo eliminar el producto.',
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
