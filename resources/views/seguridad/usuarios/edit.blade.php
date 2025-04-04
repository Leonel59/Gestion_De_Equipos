@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('css')
<style>
    /* Estilo para el formulario */
    .form-group {
        margin-bottom: 1.5rem;
        /* Espaciado entre campos */
    }

    .btn-primary {
        border-radius: 30px;
        /* Bordes redondeados */
        padding: 10px 20px;
        /* Espaciado del botón */
        transition: background-color 0.3s ease, transform 0.3s ease;
        /* Efecto al pasar el mouse */
    }

    .btn-primary:hover {
        background-color: #0056b3;
        /* Color más oscuro al pasar el mouse */
        transform: scale(1.05);
        /* Efecto de escalado */
    }

    .card {
        border-radius: 15px;
        /* Bordes redondeados para la tarjeta */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        /* Sombra */
    }

    h1 {
        color: #343a40;
        /* Color del encabezado */
        font-weight: bold;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    .show-password {
        cursor: pointer;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 0.9rem;
    }

    .btn-cancel {
        background-color: #dee2e6;
        color: #495057;
        border: 1px solid #ced4da;
    }

    .btn-cancel:hover {
        background-color: #ced4da;
    }
    .btn-save {
        background-color: #007bff;
        color: #fff;
        border: none;
    }

    .btn-save:hover {
        background-color: #0056b3;
    }

    /* Alinear los botones a la derecha */
    .button-container {
        display: flex;
        justify-content: flex-end;
        /* Alinea los botones a la derecha */
        align-items: center;
        margin-top: 20px;
    }

    /* Animación sutil */
    .transition {
        transition: all 0.3s ease;
    }
</style>
@stop

@section('content_header')
<h1 class="text-center">Editar Usuario</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" id="userForm">
            @csrf
            @method('PUT') <!-- Método PUT para la actualización -->

            <div class="form-group">
                <label for="name">Nombre Completo</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $usuario->name) }}" required pattern="[A-Z].*" title="La primera letra debe ser mayúscula.">
            </div>

            <div class="form-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" name="username" class="form-control" value="{{ old('username', $usuario->username) }}" required pattern="^[a-zA-Z0-9]*$" title="No se permiten caracteres especiales.">
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $usuario->email) }}" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña (Deja vacío para no cambiar)</label>
                <input type="password" name="password" class="form-control" pattern="(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" title="La contraseña debe tener al menos 8 caracteres, incluir al menos un número y un carácter especial.">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="form-group">
                <label for="role">Rol</label>
                <select name="role" class="form-control" required>
                    @foreach ($roles as $rol)
                    <option value="{{ $rol->id }}"
                        {{ $usuario->roles->isNotEmpty() && $usuario->roles->first()->id == $rol->id ? 'selected' : '' }}>
                        {{ $rol->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <!-- Botones de Guardar y Cancelar -->
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('usuarios.index') }}" class="btn btn-cancel mr-2 transition">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-save transition">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    // Validación de coincidencia de contraseñas
    document.getElementById('userForm').addEventListener('submit', function(event) {
        const password = document.querySelector('input[name="password"]').value;
        const passwordConfirmation = document.querySelector('input[name="password_confirmation"]').value;

        // Verifica si la contraseña ha sido modificada y si coincide con la confirmación
        if (password && password !== passwordConfirmation) {
            event.preventDefault(); // Evitar el envío del formulario
            alert('La contraseña y la confirmación de contraseña no coinciden.');
        }
    });


    // Validación en tiempo real del campo de correo electrónico
    document.querySelector('input[name="email"]').addEventListener('input', function(event) {
        // Solo permite letras, números, @ y .
        const regex = /[^a-zA-Z0-9@.]/g;
        this.value = this.value.replace(regex, '');
    });

    // Validación en tiempo real del campo de nombre de usuario
    document.querySelector('input[name="username"]').addEventListener('input', function(event) {
        // Solo permite letras, números y guion bajo (sin caracteres especiales)
        const regex = /[^a-zA-Z0-9_]/g;
        this.value = this.value.replace(regex, '');
    });

    // Validación en tiempo real del campo de nombre completo
    document.querySelector('input[name="name"]').addEventListener('input', function(event) {
        // Solo permite letras, espacios y guion (sin caracteres especiales)
        const regex = /[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s-]/g;
        this.value = this.value.replace(regex, '');
    });
</script>
@stop
