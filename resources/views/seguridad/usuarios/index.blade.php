@extends('adminlte::page')

@section('title', 'Usuarios')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    .badge-permission {
        font-size: 0.85em;
        margin: 2px;
        padding: 5px 10px;
        color: #fff;
        background-color: #17a2b8; /* Color celeste */
        border-radius: 15px; /* Bordes redondeados */
    }
    .badge-primary { background-color: #007bff; }
    .badge-secondary { background-color: #6c757d; }

    .btn-create-user {
        border-radius: 50px;
        padding: 10px 30px;
        font-size: 1.1em;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    .btn-create-user:hover {
        background-color: #28a745;
        color: #fff;
    }

    .header-title {
        font-family: 'Roboto', sans-serif;
        font-size: 2em;
        font-weight: bold;
        color: #343a40;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    /* Estilo para mensaje de candado */
    .no-access {
        margin-top: 30px;
    }

    .no-access .locked-icon {
        font-size: 3rem;
        color: #dc3545;
    }

    .no-access p {
        font-size: 1.1rem;
        color: #9e9e9e;
    }
</style>
@stop

@section('content_header')
<h1 class="text-center header-title">Usuarios</h1>
<hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

@can('seguridad.ver')
    <!-- Verificación de permisos para insertar, editar y eliminar -->
    
        <!-- Botón para crear nuevo usuario -->
        @can('seguridad.insertar')
            <a href="{{ route('usuarios.create') }}" class="btn btn-outline-info btn-block text-center btn-create-user mb-4">
                <span>Crear Nuevo Usuario</span> <i class="fas fa-plus-circle"></i>
            </a>
        @endcan

        <!-- Tabla de usuarios -->
        <div class="table-responsive-sm mt-5">
            <table id="tablaUsuarios" class="table table-striped table-bordered table-condensed table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Permisos</th>
                        @canany(['seguridad.editar', 'seguridad.eliminar'])
                            <th>Opciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->username }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @if($usuario->roles->isNotEmpty())
                                    @foreach($usuario->roles as $rol)
                                        <span class="badge badge-primary">{{ $rol->name }}</span>
                                    @endforeach
                                @else
                                    <span class="badge badge-secondary">Sin rol</span>
                                @endif
                            </td>
                            <td>
                                @if($usuario->getAllPermissions()->isNotEmpty())
                                    @php
                                        $groupedPermissions = [];
                                        foreach ($usuario->getAllPermissions() as $permiso) {
                                            $parts = explode('.', $permiso->name); // Cambiado a separador punto
                                            $module = $parts[0];
                                            $action = $parts[1] ?? 'otro';
                                            $groupedPermissions[$module][] = $action;
                                        }
                                    @endphp
                                    @foreach($groupedPermissions as $module => $actions)
                                        <span class="badge badge-permission">
                                            {{ $module }}: {{ implode(', ', $actions) }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="badge badge-secondary">Sin permisos</span>
                                @endif
                            </td>
                            @canany(['seguridad.editar', 'seguridad.eliminar'])
                            <td class="text-center">
                                @can('seguridad.editar')
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @can('seguridad.eliminar')
                                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
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

@section('js')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tablaUsuarios').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            }
        });
    });
</script>
@stop


