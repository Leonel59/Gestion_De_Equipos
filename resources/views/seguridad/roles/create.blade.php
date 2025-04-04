@extends('adminlte::page')

@section('title', 'Crear Rol')

@section('css')
<style>
    /* Estilo general */
    .form-control {
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.95rem;
        border: 1px solid #ced4da;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
        border-color: #6c757d;
        box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
    }

    .error {
        font-size: 0.85rem;
        color: #e3342f;
        margin-top: 4px;
    }

    /* Título */
    .title {
        font-family: 'Roboto', sans-serif;
        font-size: 1.8rem;
        font-weight: 600;
        color: #343a40;
        text-align: center;
        margin-bottom: 1rem;
    }

    /* Estilo de los botones */
    .btn {
        font-size: 0.9rem;
        font-weight: 500;
        padding: 8px 20px;
        border-radius: 6px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn:hover {
        transform: scale(1.05);
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
        justify-content: flex-end; /* Alinea los botones a la derecha */
        align-items: center;
        margin-top: 20px;
    }

    .button-container .btn {
        margin-right: 10px;
    }
</style>
@stop

@section('content_header')
<h1 class="title">Crear Nuevo Rol</h1>
@stop

@section('content')
<div class="card shadow-sm rounded">
    <div class="card-body">
        <form id="createRoleForm" action="{{ route('roles.store') }}" method="POST">
            @csrf

            <!-- Campo Nombre del Rol -->
            <div class="form-group">
                <label for="name" class="font-weight-bold">Nombre del Rol:</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    class="form-control"
                    placeholder="Escribe el nombre del rol"
                    required
                    oninput="validateName(this)">
                <div id="nameError" class="error" style="display: none;">
                    No se permiten caracteres especiales.
                </div>
                @if ($errors->has('name'))
                <div class="error">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
                @endif
            </div>

           <!-- Botones alineados a la derecha -->
           <div class="button-container">
                <a href="{{ route('roles.index') }}" class="btn btn-cancel transition">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-save transition">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@stop


@section('js')
<script>
    // Validación para evitar números y caracteres especiales en tiempo real
    function validateName(input) {
        const regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/; // Permite solo letras y espacios
        const errorDiv = document.getElementById('nameError');

        // Comprobamos si el valor actual no es válido
        if (!regex.test(input.value)) {
            errorDiv.style.display = 'block';
            input.classList.add('is-invalid');
        } else {
            errorDiv.style.display = 'none';
            input.classList.remove('is-invalid');
        }
    }

    // Prevenir que se ingresen números o caracteres especiales mientras se escribe
    document.getElementById('name').addEventListener('keypress', function(e) {
        const regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/; // Permite solo letras y espacios
        const key = String.fromCharCode(e.which || e.keyCode);

        // Si la tecla presionada no coincide con la expresión regular, evitamos su ingreso
        if (!regex.test(key)) {
            e.preventDefault(); // Bloquea la entrada del carácter
        }
    });
</script>
@stop

