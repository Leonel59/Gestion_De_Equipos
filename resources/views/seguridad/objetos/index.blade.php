@extends('adminlte::page')

@section('title', 'Gestion Interfaces')

@section('css')
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .badge-permission {
            font-size: 0.9em;
            margin: 2px;
            padding: 5px 10px;
            color: #fff;
        }
        .badge-primary { background-color: #007bff; }
        .badge-secondary { background-color: #6c757d; }

        .btn-create-objeto {
            border-radius: 50px;
            padding: 10px 30px;
            font-size: 1.1em;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-create-objeto:hover {
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

        .no-access {
            color: red;
            font-weight: bold;
            text-align: center;
        }

        .locked-icon {
            color: gray;
            font-size: 1.5em;
            margin-left: 10px;
        }
    </style>
@stop


@section('content_header')
    <h1 class="text-center header-title">Gestion de Interfaces</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

<!-- Verificación de permisos para el módulo de Seguridad -->
@can('seguridad.ver')
    <div class="row mb-3">
        @can('seguridad.insertar')
            <a href="{{ route('objetos.create') }}" class="btn btn-outline-info btn-block text-center btn-create-objeto">
                <span>Crear Nueva Interfaz</span> <i class="fas fa-plus-circle"></i>
            </a>
        @endcan
    </div>

    <div class="table-responsive-sm mt-5">
        <table id="tablaObjetos" class="table table-striped table-bordered table-condensed table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    
                    <th>Roles y Permisos Globales</th>
                    @canany(['seguridad.editar', 'seguridad.eliminar'])
                        <th>Opciones</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @php $i = 0; @endphp
                @foreach($objetos as $objeto)
                    <tr>
                        <td>{{ ++$i }}</td>
                        
                        <td>
                            @if($objeto->roles->isNotEmpty())
                                @foreach($objeto->roles as $role)
                                    <div>
                                        <strong>{{ $role->name }}</strong>
                                        <div>
                                            {{-- Agrupación de permisos por módulo --}}
                                            @php
                                                $groupedPermissions = [];
                                                foreach ($role->permissions as $permission) {
                                                    $parts = explode('.', $permission->name);
                                                    $module = $parts[0];
                                                    $action = $parts[1] ?? 'otro';
                                                    $groupedPermissions[$module][] = $action;
                                                }
                                            @endphp
                                            @foreach($groupedPermissions as $module => $actions)
                                                <span class="badge badge-permission badge-primary">
                                                    {{ $module }}: {{ implode(', ', $actions) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <span class="badge badge-secondary">Sin roles asignados</span>
                            @endif
                        </td>
                        @canany(['seguridad.editar', 'seguridad.eliminar'])
                            <td class="text-center">
                                @can('seguridad.editar')
                                    <a href="{{ route('objetos.edit', $objeto->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Editar
                                    </a>
                                @endcan
                                
                                @can('seguridad.eliminar')
                                    <form action="{{ route('objetos.destroy', $objeto->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar este objeto?')">
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
        $('#tablaObjetos').DataTable({
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



