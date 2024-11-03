@extends('adminlte::page')

@section('css')
<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
@stop

@section('title', 'Parametros')

@section('content_header')
    <h1 class="text-center">Parametros</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

@can('insertar') <!-- Verifica si el usuario puede insertar -->
    <a href="{{ route('parametros.create') }}" class="btn btn-outline-info text-center btn-block">
        <span>Crear Nuevo Parametro</span> <i class="fas fa-plus-square"></i>
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
    <table id="tablaParametros" class="table table-striped table-bordered table-condensed table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Parametro</th>
                <th>Valor</th>
                @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                    <th>Opciones</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @foreach($parametros as $i => $parametro)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $parametro->parametro }}</td>
                    <td>{{ $parametro->valor }}</td>
                    @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                        <td class="text-center">
                            @can('editar') <!-- Verifica si el usuario puede editar -->
                                <a href="{{ route('parametros.edit', $parametro->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                            @endcan
                            @can('eliminar') <!-- Verifica si el usuario puede eliminar -->
                                <form action="{{ route('parametros.destroy', $parametro->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este parámetro?')">
                                        <i class="fa fa-trash"></i>
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
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tablaParametros').DataTable({
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
