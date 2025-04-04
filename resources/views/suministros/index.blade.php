@extends('adminlte::page')

@section('title', 'Suministros')

@section('content_header')
    <h1 class="text-center font-weight-bold" style="color: rgba(0, 123, 255, 0.7);">Lista de Suministros</h1>
@stop

@section('content')
    @can('asignacion.ver') <!-- Verifica si el usuario tiene permiso para ver los suministros -->
        <div class="card shadow-lg rounded-3">
            <div class="card-header d-flex justify-content-between align-items-center bg-info text-white rounded-top">
                <h3 class="card-title mr-auto">Suministros Registrados</h3>
                @can('asignacion.insertar') <!-- Verifica si el usuario tiene permiso para insertar suministros -->
                <a href="{{ route('suministros.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Agregar Suministro
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
                                customClass: { popup: 'my-popup' }
                            });
                        });
                    </script>
                @endif

                <table id="suministrosTable" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>Proveedor</th>
                            <th>Nombre del Suministro</th>
                            <th>Descripción</th>
                            <th>Fecha de Adquisición</th>
                            <th>Cantidad</th>
                            <th>Costo Unitario</th>
                            <th>Costo Total</th>
                            @canany(['asignacion.editar', 'asignacion.eliminar']) <!-- Verifica permisos para editar y eliminar -->
                                <th>Acciones</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suministros as $suministro)
                            <tr>
                                <td>{{ $suministro->proveedor->nombre_proveedor ?? 'Sin Proveedor' }}</td>
                                <td>{{ $suministro->nombre_suministro }}</td>
                                <td>{{ $suministro->descripcion_suministro }}</td>
                                <td>{{ $suministro->fecha_adquisicion ? \Carbon\Carbon::parse($suministro->fecha_adquisicion)->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $suministro->cantidad_suministro }}</td>
                                <td>L.{{ number_format($suministro->costo_unitario, 2) }}</td>
                                <td>L.{{ number_format($suministro->costo_total, 2) }}</td>
                                <td>
                                @canany(['asignacion.editar', 'asignacion.eliminar'])
                                    @can('asignacion.editar')
                                        <a href="{{ route('suministros.edit', $suministro->id_suministro) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('asignacion.eliminar')
                                        <button type="button" class="btn btn-danger btn-sm delete-suministro" data-id="{{ $suministro->id_suministro }}">
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

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@endsection

@section('js')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#suministrosTable').DataTable({
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
        $('#suministrosTable').DataTable();
    });


    $(document).on('click', '.delete-suministro', function() {
        var suministroId = $(this).data('id');
        var url = '{{ route("suministros.destroy", ":id") }}';
        url = url.replace(':id', suministroId);

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás recuperar este suministro!",
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
                            'El suminstro ha sido eliminado.',
                            'success'
                        );
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'No se pudo eliminar el suministro.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
@endsection


