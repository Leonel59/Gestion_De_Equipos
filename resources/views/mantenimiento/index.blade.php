@extends('adminlte::page')

@section('css')
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet"> 
@stop

@section('title', 'Servicios de Mantenimiento')

@section('content_header')
    <h1 class="text-center">Servicios de Mantenimiento</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

@can('insertar') <!-- Verifica si el usuario puede insertar -->
    <a href="{{ route('servicios.create') }}" class="btn btn-outline-info text-center btn-block">
        <span>Agregar Nuevo Servicio</span> <i class="fas fa-plus-square"></i>
    </a>
@endcan

@if (session('info'))
<div class="alert alert-success alert-dismissible mt-2 text-dark" role="alert">
    <span type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </span>
    <strong>{{ session('info') }}</strong>
</div>
@endif

<div class="table-responsive-sm mt-5">
    <table id="tablaServicios" class="table table-striped table-bordered table-condensed table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Equipo</th>
                <th>Tipo de Mantenimiento</th>
                <th>Descripción</th>
                <th>Costo</th>
                @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                    <th>Opciones</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @foreach ($servicios as $servicio)
                <tr>
                    <td>{{ $servicio->id_mant }}</td>
                    <td>{{ $servicio->id_equipo_mant }}</td> <!-- Muestra el nombre del equipo si es necesario -->
                    <td>{{ $servicio->tipo_mantenimiento }}</td>
                    <td>{{ $servicio->descripcion_mantenimiento }}</td>
                    <td>${{ number_format($servicio->costo_mantenimiento, 2) }}</td>
                    @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                        <td class="text-center">
                            @can('editar') <!-- Verifica si el usuario puede editar -->
                                <a href="{{ route('servicios.edit', $servicio->id_mant) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('eliminar') <!-- Verifica si el usuario puede eliminar -->
                                <form action="{{ route('servicios.destroy', $servicio->id_mant) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este servicio?')">
                                        <i class="fas fa-trash-alt"></i>
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

@stop

@section('js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
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
    });
</script>
@stop
