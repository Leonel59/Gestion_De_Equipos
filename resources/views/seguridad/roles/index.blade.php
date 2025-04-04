@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
<h1 class="text-center font-weight-bold" style="color: rgba(0, 123, 255, 0.7);">Gestion de Roles</h1>
@stop


@section('content')
@can('seguridad.ver')
<div class="card shadow-lg rounded-3">
    <div class="card-header d-flex justify-content-between align-items-center bg-info text-white rounded-top">
        <h3 class="card-title mr-auto">Roles Registrados</h3>
        @can('seguridad.insertar')
        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Agregar nuevo rol
        </a>
        @endcan
    </div>
    <div class="card-body">
        @if($message = Session::get('mensaje'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: "Éxito!",
                    text: "{{$message}}",
                    icon: "success",
                    confirmButtonText: 'Aceptar',
                    width: '300px', // Ajusta el tamaño de la ventana
                    customClass: {
                        popup: 'my-popup' // Clase personalizada para estilos
                    }
                });
            });
        </script>
        @endif
        <table id="tablaRoles" class="table table-bordered text-center table-striped">
            <thead>
                <tr>
                    <th>Nombre del Rol</th>
                    <th>Permisos Globales</th>
                    @canany(['seguridad.editar', 'seguridad.eliminar'])
                    <th>Acciones</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @php $i = 0; @endphp
                @foreach($roles as $rol)
                <tr>
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
                        <button type="button" class="btn btn-danger btn-sm delete-rol" data-id="{{ $rol->id }}">
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

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .badge-permission {
        font-size: 0.85em;
        margin: 2px;
        padding: 5px 10px;
        color: #fff;
    }

    .badge-primary {
        background-color: #007bff;
    }

    .badge-secondary {
        background-color: #6c757d;
    }

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

    .dataTables_filter label,
    .dataTables_length label {
        font-weight: bold;
    }

    #tablaRoles th:nth-child(1),
    #tablaRoles td:nth-child(1) {
        width: 10%;
        /* Ajusta el ancho según necesites */
        min-width: 200px;
        /* Evita que sea demasiado estrecho */
    }

    #tablaRoles th:last-child,
    #tablaRoles td:last-child {
        width: 10%;
        /* Ajusta el ancho de "Acciones" */
        min-width: 150px;
        /* Evita que los botones se amontonen */
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        $('#tablaRoles').DataTable({
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
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                lengthMenu: "<b>Mostrar</b> _MENU_ <b>registros por página</b>",
                search: "<b>Buscar:</b>"
            }
        });

        $(document).on('click', '.delete-rol', function() {
            var rolId = $(this).data('id');
            var url = '{{ route("roles.destroy", ":id") }}'.replace(':id', rolId);

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás recuperar este registro!",
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
                            Swal.fire('Eliminado!', 'El rol ha sido eliminado.', 'success');
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'No se pudo eliminar el rol.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@stop




