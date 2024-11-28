@extends('adminlte::page')

@section('title', 'Equipos')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Lista de Equipos</h1>
@stop

@section('content')
@can('equipos.ver')
    <div class="card shadow-lg rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white rounded-top">
            <h3 class="card-title mr-auto">Equipos Registrados</h3>
            @can('equipos.insertar')
                <a href="{{ route('equipos.create') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-plus"></i> Agregar Equipo
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

            <table id="tablaObjetos1" class="table table-striped table-hover rounded shadow-sm text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Estado</th>
                        <th>Tipo Equipo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Número Serie</th>
                        <th>Precio</th>
                        <th>Fecha Adquisición</th>
                        <th>Depreciación</th>
                        <th>Propiedades</th>
                        @canany(['equipos.editar', 'equipos.eliminar'])
                            <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipos as $equipo)
                        <tr>
                            <td>{{ $equipo->cod_equipo }}</td>
                            <td>{{ $equipo->estado_equipo }}</td>
                            <td>{{ $equipo->tipo_equipo }}</td>
                            <td>{{ $equipo->marca_equipo }}</td>
                            <td>{{ $equipo->modelo_equipo }}</td>
                            <td>{{ $equipo->numero_serie }}</td>
                            <td>L.{{ number_format($equipo->precio_equipo, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($equipo->fecha_adquisicion)->format('d/m/Y') }}</td>
                            <td>L.{{ number_format($equipo->depreciacion_equipo, 2) }}</td>
                            <td>
                                <a href="{{ route('equipos.propiedades', $equipo->id_equipo) }}" class="btn btn-info btn-xs rounded-pill">
                                    <i class="fas fa-eye"></i> Ver Propiedades
                                </a>
                            </td>
                            @canany(['equipos.editar', 'equipos.eliminar'])
                                <td>
                                    @can('equipos.editar')
                                        <a href="{{ route('equipos.edit', $equipo->id_equipo) }}" class="btn btn-warning btn-xs rounded-pill">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('equipos.eliminar')
                                        <button type="button" class="btn btn-danger btn-xs rounded-pill delete-equipo" data-id="{{ $equipo->id_equipo }}">
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

@push('css')
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
        .btn-xs {
            padding: 4px 8px;
            font-size: 0.8rem;
            border-radius: 15px;
        }
        .alert {
            border-radius: 10px;
        }
    </style>
@endpush

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        $('#tablaObjetos1').DataTable({
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

        $(document).on('click', '.delete-equipo', function() {
            var equipoId = $(this).data('id');
            var url = '{{ route("equipos.destroy", ":id") }}'.replace(':id', equipoId);

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás recuperar este equipo!",
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
                            Swal.fire('Eliminado!', 'El equipo ha sido eliminado.', 'success');
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'No se pudo eliminar el equipo.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
