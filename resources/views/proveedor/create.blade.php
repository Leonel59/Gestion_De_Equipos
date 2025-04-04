@extends('adminlte::page')

@section('title', 'Agregar Proveedor')

@section('content_header')
<h1 class="text-center text-primary font-weight-bold">Agregar Proveedor</h1>
<hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card shadow-lg rounded-4">
    <div class="card-header bg-gradient-primary text-white rounded-top">
        <h3 class="card-title">Información del Proveedor</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('proveedor.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nombre_proveedor">Nombre del Proveedor</label>
                <input type="text" name="nombre_proveedor" id="nombre_proveedor" class="form-control rounded-pill @error('nombre_proveedor') is-invalid @enderror" value="{{ old('nombre_proveedor') }}" required>
                @error('nombre_proveedor')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="rtn_proveedor">RTN</label>
                <input type="text" name="rtn_proveedor" maxlength="15" id="rtn_proveedor" class="form-control rounded-pill @error('rtn_proveedor') is-invalid @enderror" value="{{ old('rtn_proveedor') }}" required>
                @error('rtn_proveedor')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
    <label for="contacto_proveedor">Contacto</label>
    <input type="text" name="contacto_proveedor" id="contacto_proveedor" class="form-control rounded-pill @error('contacto_proveedor') is-invalid @enderror" 
           value="{{ old('contacto_proveedor') }}" required>
    
    @error('contacto_proveedor')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>


<div class="form-group">
    <label for="correo_personal">Correo Electrónico</label>
    <input type="email" class="form-control rounded-pill @error('correo_personal') is-invalid @enderror" 
           id="correo_personal" name="correo_personal" placeholder="example@gmail.com" value="{{ old('correo_personal') }}" required>
    
    @error('correo_personal')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>



<div class="form-group">
    <label for="telefono_personal">Número de Teléfono</label>
    <input type="text" class="form-control rounded-pill @error('telefono_personal') is-invalid @enderror" 
           id="telefono_personal" name="telefono_personal" maxlength="15" placeholder="+504 3367-8945" 
           value="{{ old('telefono_personal') }}" required>
    
    @error('telefono_personal')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>


            <!-- Direcciones -->
            <div class="form-group">
    <label for="direccion">Dirección</label>
    <input type="text" class="form-control rounded-pill @error('direccion') is-invalid @enderror" 
           id="direccion" name="direccion" value="{{ old('direccion') }}" required>
    
    @error('direccion')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

            <div class="form-group">
                <label for="departamento">Departamento</label>
                <select class="form-control" id="departamento" name="departamento" required>
                    <option value="">Seleccione el departamento</option>
                    <option value="Francisco Morazan">Francisco Morazan</option>
                    <option value="Olancho">Olancho</option>
                    <option value="Comayagua">Comayagua</option>
                    <option value="El Paraiso">El Paraiso</option>
                    <option value="Intibuca">Intibuca</option>
                    <option value="Lempira">Lempira</option>
                    <option value="Choluteca">Choluteca</option>
                    <option value="La Paz">La Paz</option>
                </select>
            </div>
            <div class="form-group">
    <label for="ciudad">Ciudad</label>
    <input type="text" name="ciudad" id="ciudad" class="form-control rounded-pill @error('ciudad') is-invalid @enderror" 
           value="{{ old('ciudad') }}" required>
    @error('ciudad')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

            <div class="form-group d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">
                    Guardar Proveedor
                </button>
                <a href="{{ route('proveedor.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
<style>
    .btn-success {
        background: linear-gradient(145deg, #6f9e4f, #5e7e3e);
        box-shadow: 2px 2px 6px #aaa, -2px -2px 6px #fff;
    }

    .btn-secondary {
        background: linear-gradient(145deg, #888, #555);
        box-shadow: 2px 2px 6px #aaa, -2px -2px 6px #fff;
    }

    .form-control {
        border-radius: 20px;
    }
</style>
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
        validateInput('#nombre_proveedor', /[^a-zA-Z\s]/g); // Solo letras
validateInput('#contacto_proveedor', /[^a-zA-Z\s]/g); // Solo letras

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


    