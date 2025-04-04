@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
<h1 class="text-center font-weight-bold" style="color: rgba(0, 123, 255, 0.7);">Gestion de Usuarios</h1>
@stop

@section('content')

@can('seguridad.ver')
<!-- Verificación de permisos para insertar, editar y eliminar -->
<div class="card shadow-lg rounded-3">
    <div class="card-header d-flex justify-content-between align-items-center bg-info text-white rounded-top">
        <h3 class="card-title mr-auto">Usuarios Registrados</h3>
        @can('seguridad.insertar')
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Agregar nuevo usuario
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
        <!-- Tabla de usuarios -->
        <table id="tablaUsuarios"  class="table text-center table-bordered text-center table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Permisos</th>
                    @canany(['seguridad.editar', 'seguridad.eliminar'])
                    <th>Acciones</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @php $i = 0; @endphp
                @foreach($usuarios as $usuario)
                <tr>
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
                        <button type="button" class="btn btn-danger btn-sm delete-usuario" data-id="{{ $usuario->id }}">
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
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    .badge-permission {
        font-size: 0.85em;
        margin: 2px;
        padding: 5px 10px;
        color: #fff;
        background-color: #17a2b8;
        /* Color celeste */
        border-radius: 15px;
        /* Bordes redondeados */
    }

    .badge-primary {
        background-color: #007bff;
    }

    .badge-secondary {
        background-color: #6c757d;
    }

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


@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        $('#tablaUsuarios').DataTable({
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

        $(document).on('click', '.delete-usuario', function() {
            var usuarioId = $(this).data('id');
            var url = '{{ route("usuarios.destroy", ":id") }}'.replace(':id', usuarioId);

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás recuperar este usuario!",
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
                            Swal.fire('Eliminado!', 'El usuario ha sido eliminado.', 'success');
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'No se pudo eliminar el usuario.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@stop

