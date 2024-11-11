@extends('adminlte::page')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Estilo para el botón de crear nuevo usuario */
    .btn-create {
        border-radius: 5px; /* Redondeado leve */
        font-size: 1.2rem;
        padding: 8px 16px; /* Ajustado para que no sea tan grande */
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-create:hover {
        background-color: #1e7e34; /* Color más oscuro al pasar el mouse */
        transform: scale(1.02); /* Menos escalado al pasar el mouse */
    }

    /* Estilo para los botones de editar y eliminar */
    .btn-edit, .btn-delete {
        border-radius: 5px; /* Redondeado leve */
        padding: 5px 10px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-edit:hover {
        background-color: #ffc107; /* Color más oscuro para editar */
        transform: scale(1.05);
    }

    .btn-delete:hover {
        background-color: #dc3545; /* Color más oscuro para eliminar */
        transform: scale(1.05);
    }

    /* Estilo para el encabezado de usuarios */
    h1 {
        font-family: 'Arial', sans-serif; /* Cambiar fuente */
        color: #343a40; /* Color oscuro */
        font-weight: bold;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        font-size: 2rem; /* Tamaño de fuente ajustado */
        margin-top: 20px; /* Espacio superior */
    }

    /* Estilo para los campos de texto */
    .table td, .table th {
        border-radius: 0; /* Sin bordes redondeados */
    }

    .badge {
        border-radius: 10px; /* Bordes redondeados para badges */
    }
</style>
@stop

@section('title', 'Usuarios')

@section('content_header')
@canany(['insertar','editar'])
    <h1 class="text-center">Usuarios</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

@can('insertar') <!-- Verifica si el usuario puede insertar -->
    <a href="{{ route('usuarios.create') }}" class="btn btn-outline-info btn-create text-center btn-block">
        <span>Crear Nuevo Usuario</span> <i class="fas fa-plus-square"></i>
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
    <table id="tablaUsuarios" class="table table-striped table-bordered table-condensed table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Rol</th> <!-- Nueva columna para mostrar el rol -->
                <th>Permisos</th> <!-- Nueva columna para mostrar los permisos -->
                <th>Fecha de Creación</th>
                <th>Fecha de Actualización</th>
                @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                    <th>Opciones</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $key => $usuario)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->username }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        @if($usuario->roles->isNotEmpty())
                            @foreach($usuario->roles as $rol)
                                <span class="badge bg-primary text-white rounded-pill">{{ $rol->name }}</span>
                            @endforeach
                        @else
                            <span class="badge bg-secondary text-white">Sin rol asignado</span>
                        @endif
                    </td>
                    <td>
                        @if($usuario->getAllPermissions()->isNotEmpty())
                            @foreach($usuario->getAllPermissions() as $permiso)
                                <span class="badge bg-info text-white rounded-pill">{{ $permiso->name }}</span>
                            @endforeach
                        @else
                            <span class="badge bg-secondary text-white">Sin permisos asignados</span>
                        @endif
                    </td>
                    <td>{{ $usuario->created_at->format('d/m/Y H:i') }}</td> <!-- Formato de fecha -->
                    <td>{{ $usuario->updated_at->format('d/m/Y H:i') }}</td> <!-- Formato de fecha -->
                    @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                        <td class="text-center">
                            @can('editar') <!-- Verifica si el usuario puede editar -->
                                <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning btn-edit btn-sm fa fa-edit"></a>
                            @endcan
                            @can('eliminar') <!-- Verifica si el usuario puede eliminar -->
                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-delete btn-sm fa fa-times-circle" onclick="return confirm('¿Estás seguro de eliminar este usuario?');"></button>
                                </form>
                            @endcan
                        </td>
                    @endcanany
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


@else
    <div class="card border-light shadow-sm mt-3 text-center">
        <div class="card-body">
            <i class="fas fa-lock text-danger mb-2" style="font-size: 2rem;"></i>
            <p class="mb-0" style="font-size: 1.1rem; color: #9e9e9e;">No tienes permiso para ver esta información.</p>
        </div>
    </div>
@endcanany



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


