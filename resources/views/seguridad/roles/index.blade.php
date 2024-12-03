@extends('adminlte::page')

@section('title', 'Roles')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    .badge-permission {
        font-size: 0.85em;
        margin: 2px;
        padding: 5px 10px;
        color: #fff;
    }
    .badge-primary { background-color: #007bff; }
    .badge-secondary { background-color: #6c757d; }

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

    .header-title {
        font-family: 'Roboto', sans-serif;
        font-size: 2em;
        font-weight: bold;
        color: #343a40;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }
</style>
@stop

@section('content_header')
<h1 class="text-center header-title">Gestión de Roles</h1>
<hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

@can('seguridad.ver')
   
        <!-- Botón para crear nuevo rol -->
        @can('seguridad.insertar')
            <a href="{{ route('roles.create') }}" class="btn btn-outline-info btn-block text-center btn-create-role mb-4">
                <span>Crear Nuevo Rol</span> <i class="fas fa-plus-circle"></i>
            </a>
        @endcan

        <!-- Tabla de roles -->
        <div class="table-responsive-sm mt-5">
            <table id="tablaRoles" class="table table-striped table-bordered table-condensed table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre del Rol</th>
                        <th>Permisos Globales</th>
                        @canany(['seguridad.editar', 'seguridad.eliminar'])
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
                                    @php
                                        $groupedPermissions = $rol->permissions->groupBy(function($permission) {
                                            return explode('.', $permission->name)[0]; // Agrupa por módulo
                                        });
                                    @endphp
                                    @foreach($groupedPermissions as $module => $permissions)
                                        <span class="badge badge-permission badge-primary">
                                            {{ $module }}: {{ $permissions->pluck('name')->map(fn($p) => explode('.', $p)[1] ?? $p)->join(', ') }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="badge badge-secondary">Sin permisos globales asignados</span>
                                @endif
                            </td>
                            @canany(['seguridad.editar', 'seguridad.eliminar'])
                            <td class="text-center">
                                @can('seguridad.editar')
                                <a href="{{ route('roles.edit', $rol->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i> 
                                </a>
                                @endcan
                                @can('seguridad.ver')
                                <a href="{{ route('roles.show', $rol->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> 
                                </a>
                                @endcan
                                @can('seguridad.eliminar')
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
        $('#tablaRoles').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            }
        });
    });
</script>
@stop





