@extends('adminlte::page')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@stop

@section('title', 'Usuarios')

@section('content_header')
    <h1 class="text-center">Usuarios</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

<a href="{{ route('usuarios.create') }}" class="btn btn-outline-info text-center btn-block">
    <span>Crear Nuevo Usuario</span> <i class="fas fa-plus-square"></i>
</a>

<div class="table-responsive-sm mt-5">
    <table id="tablaUsuarios" class="table table-striped table-bordered table-condensed table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Fecha de Creación</th>
                <th>Fecha de Actualización</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $key => $usuario)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->username }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->created_at }}</td>
                    <td>{{ $usuario->updated_at }}</td>
                    <td class="text-center">
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST">
                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning btn-sm fa fa-edit"></a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm fa fa-times-circle"></button>
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
        $('#tablaUsuarios').DataTable({
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

