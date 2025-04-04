@extends('adminlte::page')

@section('title', 'Facturas')

@section('content_header')
<h1 class="text-center font-weight-bold" style="color: rgba(0, 123, 255, 0.7);">Lista de Facturas de Proveedores</h1>
@stop

@section('content')

@can('factura.ver')
<div class="card shadow-lg rounded-3">
    <div class="card-header d-flex justify-content-between align-items-center bg-info text-white rounded-top">
        <h3 class="card-title mr-auto">Facturas Registradas</h3>
        @can('factura.insertar') <!-- Verifica si el usuario tiene permiso para insertar suministros -->
        <a href="{{ route('facturas.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus"></i> Agregar Factura
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
                    width: '300px',
                    customClass: {
                        popup: 'my-popup'
                    }
                });
            });
        </script>
        @endif

        <table id="facturasTable" class="table table-striped table-bordered table-condensed table-hover rounded-4 shadow-sm text-center">
            <thead class="thead-white">
                <tr>
                    <th>Proveedor</th>
                    <th>Tipo de Factura</th>
                    <th>Cliente</th>
                    <th>RTN Cliente</th>
                    <th>Fecha de Facturación</th>
                    <th>Imagen</th> <!-- Nueva columna de Imagen -->
                    @canany(['factura.eliminar'])
                    <th>Acciones</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach($facturas as $factura)
                <tr>
                    <td>{{ $factura->proveedor->nombre_proveedor }}</td>
                    <td>{{ $factura->tipo_factura }}</td>
                    <td>{{ $factura->nombre_cliente }}</td>
                    <td>{{ $factura->rtn_cliente }}</td>
                    <td>{{ $factura->fecha_facturacion }}</td>
                    <td>
                        @if($factura->imagen)
                        <a href="{{ asset('storage/' . $factura->imagen) }}" download class="btn btn-primary btn-sm rounded-pill">
                            Descargar Imagen
                        </a>
                        @else
                        No disponible
                        @endif
                    </td>

                    @canany(['factura.eliminar'])
                    <td class="text-center">
                        @can('factura.eliminar')
                        <button type="button" class="btn btn-danger btn-sm delete-factura" data-id="{{ $factura->cod_factura }}">
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
<!-- Mensaje de permiso denegado -->
<div class="card border-light shadow-sm mt-3 text-center">
    <div class="card-body">
        <i class="fas fa-lock text-danger mb-2" style="font-size: 2rem;"></i>
        <p class="mb-0" style="font-size: 1.1rem; color: #9e9e9e;">No tienes permiso para ver esta información.</p>
    </div>
</div>
@endcan

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#facturasTable').DataTable({
            searching: true, // Habilita el cuadro de búsqueda
            ordering: false, // Desactiva la ordenación automática
            paging: true, // Habilita la paginación
            info: true, // Muestra información sobre el número de registros
            language: {

                search: "Buscar:",
                
                paginate: {
                    previous: "Anterior",
                    next: "Siguiente"
                },
                emptyTable: "No hay datos disponibles en la tabla",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totales)"
            }
        });
    });
</script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">


<script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $('#facturasTable').DataTable();
    });


    $(document).on('click', '.delete-factura', function() {
        var facturaId = $(this).data('id');
        var url = '{{ route("facturas.destroy", ":id") }}';
        url = url.replace(':id', facturaId);

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás recuperar este registro!",
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
                        Swal.fire({
                            title: 'Eliminado!',
                            text: 'La factura ha sido eliminada.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '{{ route("facturas.index") }}'; // Redirige a facturas.index
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'No se pudo eliminar la factura.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
@stop