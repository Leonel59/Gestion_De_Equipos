@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('css')
<style>
    /* Estilo para el formulario */
    .form-group {
        margin-bottom: 1.5rem; /* Espaciado entre campos */
    }

    .btn-primary {
        border-radius: 30px; /* Bordes redondeados */
        padding: 10px 20px; /* Espaciado del botón */
        transition: background-color 0.3s ease, transform 0.3s ease; /* Efecto al pasar el mouse */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Color más oscuro al pasar el mouse */
        transform: scale(1.05); /* Efecto de escalado */
    }

    .card {
        border-radius: 15px; /* Bordes redondeados para la tarjeta */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra */
    }

    h1 {
        color: #343a40; /* Color del encabezado */
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
</style>
@stop

@section('content_header')
    <h1 class="text-center">Crear Nuevo Usuario</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('usuarios.store') }}" method="POST" id="userForm">
                @csrf

                <div class="form-group">
                    <label for="name">Nombre Completo</label>
                    <input type="text" name="name" class="form-control" required pattern="[A-Z].*" title="La primera letra debe ser mayúscula.">
                </div>

                <div class="form-group">
                    <label for="username">Nombre de Usuario</label>
                    <input type="text" name="username" class="form-control" required pattern="^[a-zA-Z0-9]*$" title="No se permiten caracteres especiales.">
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="form-group position-relative">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" class="form-control" required pattern="(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" title="La contraseña debe tener al menos 8 caracteres, incluir al menos un número y un carácter especial.">
                    <span class="show-password" onclick="togglePasswordVisibility('password')">Ver contraseña</span>
                </div>

                <div class="form-group position-relative">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                    <span class="show-password" onclick="togglePasswordVisibility('password_confirmation')">Ver contraseña</span>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Guardar Usuario</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.querySelector(`input[name="${fieldId}"]`);
        field.type = field.type === 'password' ? 'text' : 'password';
    }

    document.getElementById('userForm').addEventListener('submit', function(event) {
        const password = document.querySelector('input[name="password"]').value;
        const passwordConfirmation = document.querySelector('input[name="password_confirmation"]').value;

        if (password !== passwordConfirmation) {
            event.preventDefault(); // Evitar el envío del formulario
            alert('La contraseña y la confirmación de contraseña no coinciden.');
        }
    });
</script>
@stop

