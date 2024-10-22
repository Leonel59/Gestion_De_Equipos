@extends('adminlte::page') 

@section('title', 'Editar Rol')

@section('content_header')
<h1 class="text-center">Editar Rol</h1>
<hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
<form id="editRoleForm" action="{{ route('roles.update', $role->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- Método para actualizar el rol -->

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="form-group has-primary">
                <label for="rol">Nombre del Rol:</label>
                <input
                    type="text"
                    id="rol"
                    class="form-control border-secondary"
                    placeholder="Ingrese el rol..."
                    name="rol"
                    value="{{ old('rol', $role->name) }}"
                    autofocus
                >
                @if ($errors->has('rol'))
                    <div id="rol-error" class="error text-danger pl-3" style="display: block;">
                        <strong>{{ $errors->first('rol') }}</strong>
                    </div>
                @else
                    <div id="rol-error" class="error text-danger pl-3" style="display: none;"></div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="table-responsive-sm mt-5">
                <table id="tablaRoles" class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center">
                        <tr>
                            <th colspan="6">Listado de Permisos</th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Pantalla</th>
                            <th>Ver</th>
                            <th>Insertar</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @php $i = 0; @endphp
                        @foreach($objetos as $objeto)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $objeto->objeto }}</td>
                                <td><input type="checkbox" name="permisos[]" value="VER_{{ $objeto->objeto }}" {{ in_array("VER_{$objeto->objeto}", $role->permissions->pluck('name')->toArray()) ? 'checked' : '' }}></td>
                                <td><input type="checkbox" name="permisos[]" value="INSERTAR_{{ $objeto->objeto }}" {{ in_array("INSERTAR_{$objeto->objeto}", $role->permissions->pluck('name')->toArray()) ? 'checked' : '' }}></td>
                                <td><input type="checkbox" name="permisos[]" value="EDITAR_{{ $objeto->objeto }}" {{ in_array("EDITAR_{$objeto->objeto}", $role->permissions->pluck('name')->toArray()) ? 'checked' : '' }}></td>
                                <td><input type="checkbox" name="permisos[]" value="ELIMINAR_{{ $objeto->objeto }}" {{ in_array("ELIMINAR_{$objeto->objeto}", $role->permissions->pluck('name')->toArray()) ? 'checked' : '' }}></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-xs-12 mb-2">
            <a href="{{ route('roles.index') }}" class="btn btn-danger w-100">
                Cancelar <i class="fa fa-times-circle ml-2"></i>
            </a>
        </div>
        <div class="col-sm-6 col-xs-12 mb-2">
            <button type="submit" class="btn btn-success w-100">
                Actualizar <i class="fa fa-check-circle ml-2"></i>
            </button>
        </div>
    </div>
</form>

@stop

@section('css')
@stop

@section('js')
<script>
    let canInput = true;

    document.getElementById('rol').addEventListener('input', function() {
        const rol = this.value.trim();
        const rolError = document.getElementById('rol-error');

        // Limpiar mensaje de error previo
        rolError.style.display = 'none';

        // Validación en tiempo real
        if (!canInput) {
            rolError.innerText = 'No puede ingresar caracteres especiales por 5 segundos.';
            rolError.style.display = 'block';
            this.value = rol.replace(/[^A-Za-z0-9_\- ]/g, ''); // Elimina caracteres especiales
            return;
        }

        if (rol.length < 4 || rol.length > 255 || /[^A-Za-z0-9_\- ]/.test(rol)) {
            rolError.innerText = 'El nombre del rol debe tener entre 4 y 255 caracteres y no debe contener caracteres especiales.';
            rolError.style.display = 'block';

            if (/[^A-Za-z0-9_\- ]/.test(rol)) {
                canInput = false;
                setTimeout(() => {
                    canInput = true;
                }, 5000); // Resetea la variable después de 5 segundos
            }
        }
    });

    document.getElementById('editRoleForm').addEventListener('submit', function(event) {
        const rol = document.getElementById('rol').value.trim();
        const rolError = document.getElementById('rol-error');

        // Limpiar errores previos
        rolError.style.display = 'none';

        // Validación
        let valid = true;

        // Validación de nombre del rol
        if (rol.length < 4 || rol.length > 255 || /[^A-Za-z0-9_\- ]/.test(rol)) {
            rolError.innerText = 'El nombre del rol debe tener entre 4 y 255 caracteres y no debe contener caracteres especiales.';
            rolError.style.display = 'block';
            valid = false;
        }

        // Evitar el envío del formulario si no es válido
        if (!valid) {
            event.preventDefault(); // Evitar el envío del formulario
        }
    });
</script>
@stop

