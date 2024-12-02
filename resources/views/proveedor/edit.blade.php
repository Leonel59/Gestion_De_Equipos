@extends('adminlte::page')

@section('title', 'Editar Proveedor')

@section('content_header')
<h1>Editar Proveedor</h1>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('proveedor.update', $proveedor->id_proveedor) }}" method="POST">
            @csrf
            @method('PUT') <!-- Método PUT para la actualización -->

            <div class="form-group">
                <label for="nombre_proveedor">Nombre del Proveedor</label>
                <input type="text" name="nombre_proveedor" id="nombre_proveedor" class="form-control @error('nombre_proveedor') is-invalid @enderror" value="{{ old('nombre_proveedor', $proveedor->nombre_proveedor) }}" required>
                @error('nombre_proveedor')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="rtn_proveedor">RTN</label>
                <input type="text" name="rtn_proveedor" id="rtn_proveedor" maxlength="15" class="form-control @error('rtn_proveedor') is-invalid @enderror" value="{{ old('rtn_proveedor', $proveedor->rtn_proveedor) }}" required>
                @error('rtn_proveedor')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="contacto_proveedor">Contacto</label>
                <input type="text" name="contacto_proveedor" id="contacto_proveedor" class="form-control @error('contacto_proveedor') is-invalid @enderror" value="{{ old('contacto_proveedor', $proveedor->contacto_proveedor) }}">
                @error('contacto_proveedor')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="correo_personal">Correo Electronico</label>
                <input type="email" class="form-control" name="correo_personal" maxlength="30" placeholder="example@gmail.com" value="{{ old('correo_personal', $proveedor->correos->first()->correo_personal ?? '') }}">
            </div>

            <div class="form-group">
                <label for="telefono_personal">Número de Teléfono </label>
                <input type="text" class="form-control" name="telefono_personal" maxlength="15" placeholder="+504 3367-8945" value="{{ old('telefono_personal', $proveedor->telefonos->first()->telefono_personal ?? '') }}">
            </div>


            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" name="direccion" maxlength="50" value="{{ old('direccion', $proveedor->direcciones->first()->direccion ?? '') }}">
            </div>

            <div class="form-group">
                <label for="departamento">Departamento</label>
                <select class="form-control" id="departamento" name="departamento" required>
                    <option value=" Francisco Morazan" {{ $proveedor->departamento == 'Francisco Morazan' ? 'selected' : '' }}>Francisco Morazan</option>
                    <option value=" Olancho" {{ $proveedor->departamento == 'Olancho' ? 'selected' : '' }}>Olancho </option>
                    <option value=" Comayagua" {{ $proveedor->departamento == 'Comayagua' ? 'selected' : '' }}>Comayagua</option>
                    <option value=" El Paraiso" {{ $proveedor->departamento == 'El Paraiso' ? 'selected' : '' }}>El Paraiso</option>
                    <option value=" Intibuca" {{ $proveedor->departamento == 'Intibuca ' ? 'selected' : '' }}>Intibuca</option>
                    <option value=" Lempira" {{ $proveedor->departamento == 'Lempira ' ? 'selected' : '' }}>Lempira</option>
                    <option value=" Choluteca" {{ $proveedor->departamento == 'Choluteca' ? 'selected' : '' }}>Choluteca</option>
                    <option value=" La Paz" {{ $proveedor->departamento == 'La Paz' ? 'selected' : '' }}>La Paz</option>

                </select>
            </div>

            <div class="form-group">
                <label for="ciudad">Ciudad</label>
                <input type="text" class="form-control" name="ciudad" maxlength="30" value="{{ old('ciudad', $proveedor->direcciones->first()->ciudad ?? '') }}">
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('proveedor.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lista de campos donde se bloquearán caracteres especiales
        const restrictedFields = [
            'nombre_proveedor',
            'rtn_proveedor',
            'contacto_proveedor',
            'direccion',
            'ciudad' // Agregado el campo de dirección
        ];

        restrictedFields.forEach(field => {
            const inputField = document.getElementById(field);

            inputField.addEventListener('input', function() {
                // Permitir solo letras, números y espacios
                this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, '');
            });
        });

        // Validaciones por tipo de campo
        function validateInput(selector, regex) {
            $(selector).on('input', function() {
                this.value = this.value.replace(regex, '');
            });
        }

        validateInput('#ciudad', /[^a-zA-Z\s]/g); // Solo letras
        validateInput('#rtn_proveedor', /[^0-9\s]/g); // Solo numeros

        // Validación para el campo de correo
        const emailField = document.getElementById('correo_personal');
        if (emailField) {
            emailField.addEventListener('input', function() {
                // Permitir solo caracteres válidos para correos (letras, números, @, y punto)
                this.value = this.value.replace(/[^a-zA-Z0-9@.]/g, '');
            });
        }

        // Validacion para ingresar telefono
        document.querySelectorAll('#telefono_personal').forEach(function(input) {
            input.addEventListener('input', function(event) {
                // Expresión regular: solo permite números, guiones y el signo +
                const regex = /^[0-9+\-\s]*$/;

                // Si el valor del input no cumple con la expresión regular, lo corregimos
                if (!regex.test(event.target.value)) {
                    // Eliminamos el último carácter que no cumple con la validación
                    event.target.value = event.target.value.replace(/[^0-9+\-\s]/g, '');
                }
            });
        });
    });
</script>
@stop
