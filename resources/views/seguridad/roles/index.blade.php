@extends('adminlte::page') 

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Estilos para mejorar la apariencia de los permisos */
    .badge-permission {
        font-size: 0.9em;
        margin: 2px;
        padding: 5px 10px;
        color: #fff;
    }
    .badge-primary { background-color: #007bff; }
    .badge-secondary { background-color: #6c757d; }

    /* Estilo del botón Crear Nuevo Rol */
    .btn-create-role {
        border-radius: 50px;
        padding: 10px 30px;
        font-size: 1.1em;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    .btn-create-role:hover {
        background-color: #17a2b8;
        color: #fff;
    }

    /* Estilo del título */
    .header-title {
        font-family: 'Roboto', sans-serif;
        font-size: 2em;
        font-weight: bold;
        color: #343a40;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }
</style>
@stop

@section('title', 'Roles')

@section('content_header')
    <h1 class="text-center header-title">Roles</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

@can('insertar')
    <a href="{{ route('roles.create') }}" class="btn btn-outline-info btn-block text-center btn-create-role">
        <span>Crear Nuevo Rol</span> <i class="fas fa-plus-circle"></i>
    </a>
@endcan

<div class="table-responsive-sm mt-5">
    <table id="tablaRoles" class="table table-striped table-bordered table-condensed table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nombre del Rol</th>
                <th>Permisos</th>
                @canany(['editar', 'eliminar'])
                    <th>Opciones</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @php $i = 0; @endphp
            @foreach($roles as $rol)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $rol->name }}</td>
                    <td>
                        @if($rol->permissions->isNotEmpty())
                            @foreach($rol->permissions as $permiso)
                                <span class="badge badge-permission badge-primary">{{ $permiso->name }}</span>
                            @endforeach
                        @else
                            <span class="badge badge-secondary">Sin permisos asignados</span>
                        @endif
                    </td>
                    @canany(['editar', 'eliminar'])
                        <td class="text-center">
                            @can('editar')
                                <a href="{{ route('roles.edit', $rol->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                            @endcan
                            @can('ver')
                                <a href="{{ route('roles.show', $rol->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> Ver
                                </a>
                            @endcan
                            @can('eliminar')
                                <form action="{{ route('roles.destroy', $rol->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar este rol?')">
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
        $('#tablaRoles').DataTable({
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

