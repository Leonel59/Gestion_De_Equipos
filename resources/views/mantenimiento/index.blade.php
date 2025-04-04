@extends('adminlte::page')

@section('css')
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet"> 
@stop

@section('title', 'Servicios de Mantenimiento')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Servicios de Mantenimiento</h1>
   
@stop

@section('content')
@can('mantenimiento.ver')


<div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white rounded-top">
    <h3 class="card-title">Lista de Servicios</h3>
    @can('mantenimiento.insertar') 
        <div class="ml-auto"> <!-- Empuja el botón hacia la derecha -->
            <a href="{{ route('servicios.create') }}" class="btn btn-primary text-white font-weight-bold">
                <i class="fas fa-plus"></i> Agregar Nuevo Servicio
            </a>
        </div>
    @endcan
</div>
    <div class="card-body">
        @if(session('info'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: "Éxito!",
                        text: "{{ session('info') }}",
                        icon: "success",
                        confirmButtonText: 'Aceptar',
                        timer: 3000
                    });
                });
            </script>
        @endif

        <div class="table-responsive-sm mt-3">
            <table id="tablaServicios" class="table table-striped table-bordered table-hover rounded shadow-sm">
                <thead class="thead-light">
                    <tr>
                        
                        <th>Equipo</th>
                        <th>Tipo de Mantenimiento</th>
                        <th>Descripción</th>
                        <th>Costo</th>
                        @canany(['mantenimiento.editar', 'mantenimiento.eliminar'])
                            <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicios as $servicio)
                        <tr>
                            
                            <td>{{ $servicio->id_equipo_mant }}</td>
                            <td>{{ $servicio->tipo_mantenimiento }}</td>
                            <td>{{ $servicio->descripcion_mantenimiento }}</td>
                            <td>L{{ number_format($servicio->costo_mantenimiento, 2) }}</td>
                            @canany(['mantenimiento.editar', 'mantenimiento.eliminar'])
                                <td class="text-center">
                                    @can('mantenimiento.editar')
                                        <a href="{{ route('servicios.edit', $servicio->id_mant) }}" class="btn btn-warning btn-sm rounded-pill" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('mantenimiento.eliminar')
                                        <button class="btn btn-danger btn-sm rounded-pill delete-servicio" data-id="{{ $servicio->id_mant }}" title="Eliminar">
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
        $('#tablaServicios').DataTable({
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

        $(document).on('click', '.delete-servicio', function() {
            var servicioId = $(this).data('id');
            var url = '{{ route("servicios.destroy", ":id") }}'.replace(':id', servicioId);

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás recuperar este servicio!",
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
                                'El servicio ha sido eliminado.',
                                'success'
                            );
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'No se pudo eliminar el servicio.',
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
