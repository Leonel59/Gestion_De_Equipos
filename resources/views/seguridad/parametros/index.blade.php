@extends('adminlte::page')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@stop

@section('title', 'Parametro')
@section('content_header')
    <h1 class="text-center">Parametro</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

<a href="{{ route('parametros.create') }}" class="btn btn-outline-info text-center btn-block">
    <span>Crear Nuevo Parametro</span> <i class="fas fa-plus-square"></i>
</a>

@if (session('info'))
<div class="alert alert-success alert-dismissible mt-2 tex-dark" role="alert">
    <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
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
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>

        @foreach($parametros as $i => $parametro)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $parametro->parametro }}</td>
                <td>{{ $parametro->valor }}</td>
                <td class="text-center">
                    <a href="{{ route('parametros.edit', $parametro->id) }}" class="btn btn-warning btn-sm fa fa-edit"></a>

                    <form action="{{ route('parametros.destroy', $parametro->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este parámetro?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
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
                    className: 'btn btn-danger glyphicon glyphicon-duplicate',
                }, 
                {
                    extend: 'print',
                    text: 'Imprimir',
                    className: 'btn btn-secondary glyphicon glyphicon-duplicate'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-success glyphicon glyphicon-duplicate'
                }
            ]
        });
    });
</script>
@stop


