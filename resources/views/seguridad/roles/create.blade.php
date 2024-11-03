@extends('adminlte::page')

@section('title', 'Crear Rol')

@section('content_header')
<h1 class="text-center text-primary font-weight-bold">Crear Nuevo Rol</h1>
<hr class="bg-dark border-2 border-top border-dark">
@stop

@section('content')
<form id="createRoleForm" action="{{ route('roles.store') }}" method="POST">
    @csrf

    <!-- Selección del Rol -->
    <div class="row mb-4">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="rol" class="font-weight-bold">Seleccionar Rol:</label>
                <select id="rol" name="rol" class="form-control border-primary shadow-sm">
                    <option value="" disabled selected>Seleccione un rol</option>
                    <option value="admin">Admin</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="usuario">Usuario</option>
                </select>
                @if ($errors->has('rol'))
                    <div class="error text-danger pl-3" style="display: block;">
                        <strong>{{ $errors->first('rol') }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Selección de Usuario -->
    <div class="row mb-4">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="usuario" class="font-weight-bold">Seleccionar Usuario:</label>
                <select id="usuario" name="usuario" class="form-control border-primary shadow-sm">
                    <option value="" disabled selected>Seleccione un usuario</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('usuario'))
                    <div class="error text-danger pl-3" style="display: block;">
                        <strong>{{ $errors->first('usuario') }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Listado de Permisos -->
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive-sm mt-5">
                <table id="tablaRoles" class="table table-striped table-bordered table-hover">
                    <thead class="text-center bg-light">
                        <tr>
                            <th>#</th>
                            <th>Permiso</th>
                            <th>Seleccionar</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @php $i = 0; @endphp
                        @foreach(['ver', 'insertar', 'editar', 'eliminar'] as $permiso)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ ucfirst($permiso) }}</td>
                                <td>
                                    <input type="checkbox" id="permiso-{{ $permiso }}" name="permisos[]" value="{{ $permiso }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Botones de Guardar y Cancelar -->
    <div class="row mt-4">
        <div class="col-sm-6 mb-2">
            <a href="{{ route('roles.index') }}" class="btn btn-danger w-100 transition-btn">
                Cancelar <i class="fa fa-times-circle ml-2"></i>
            </a>
        </div>
        <div class="col-sm-6 mb-2">
            <button type="submit" class="btn btn-success w-100 transition-btn">
                Guardar <i class="fa fa-check-circle ml-2"></i>
            </button>
        </div>
    </div>
</form>

<script>
    document.getElementById('rol').addEventListener('change', function() {
        var selectedRole = this.value;

        // Obtener los checkboxes de permisos
        var permisoVer = document.getElementById('permiso-ver');
        var permisoInsertar = document.getElementById('permiso-insertar');
        var permisoEditar = document.getElementById('permiso-editar');
        var permisoEliminar = document.getElementById('permiso-eliminar');

        // Resetear permisos y desbloquear todos
        permisoVer.checked = permisoInsertar.checked = permisoEditar.checked = permisoEliminar.checked = false;
        permisoVer.disabled = permisoInsertar.disabled = permisoEditar.disabled = permisoEliminar.disabled = false;

        // Aplicar permisos según el rol seleccionado
        if (selectedRole === 'admin') {
            // Admin tiene todos los permisos
            permisoVer.checked = permisoInsertar.checked = permisoEditar.checked = permisoEliminar.checked = true;
        } else if (selectedRole === 'supervisor') {
            // Supervisor solo tiene permiso de ver
            permisoVer.checked = true;
            permisoInsertar.disabled = permisoEditar.disabled = permisoEliminar.disabled = true;
        } else if (selectedRole === 'usuario') {
            // Usuario tiene permisos de ver e insertar
            permisoVer.checked = permisoInsertar.checked = true;
            permisoEditar.disabled = permisoEliminar.disabled = true;
        }
    });
</script>
@stop
