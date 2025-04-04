@extends('adminlte::page')

@section('title', 'Crear Objeto')

@section('css')
<style>
    /* Estilo general */
    .form-control {
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 1rem;
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
    /* Animación sutil */
    .transition {
        transition: all 0.3s ease;
    }

    /* Estilo para los toggles tipo iPhone */
    .toggle-checkbox {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .toggle-checkbox input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        border-radius: 50%;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: 0.4s;
    }

    input:checked + .slider {
        background-color: #4CAF50;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }
    
    /* Estilo para las tarjetas de permisos */
.permission-card {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 1rem;
    display: inline-block;
    width: 23%;
    margin-right: 1%;
    margin-bottom: 20px;
    background-color: #f0f0f5; /* Color más suave */
    border: 1px solid #ddd;
}

/* Encabezado de la tarjeta de permiso */
.permission-card-header {
    background-color: #007bff; /* Azul más suave */
    color: white;
    font-weight: bold;
    padding: 10px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    text-align: center;
}

/* Cuerpo de la tarjeta */
.permission-card-body {
    padding: 10px 15px;
}

/* Estilo de los checkboxes y etiquetas */
.permission-card-body .form-check {
    margin-bottom: 12px;
    display: flex;
    align-items: center;
}

.permission-card-body .form-check input {
    width: 20px;
    height: 20px;
    margin-right: 10px;
}

/* Estilo de las etiquetas de los permisos */
.permission-card-body .form-check label {
    font-size: 0.9rem;
    font-weight: normal;
    color: #333;
}

/* Botones con iconos estilo iPhone */
.permission-card-body .form-check input:checked + label::before {
    content: '\2713'; /* Marca de verificación */
    font-size: 16px;
    color: #4CAF50; /* Color verde */
    margin-left: 5px;
}

.permission-card-body .form-check input[type="checkbox"]:not(:checked) + label::before {
    content: '\2716'; /* X */
    font-size: 16px;
    color: #f44336; /* Color rojo */
    margin-left: 5px;
}

/* Estilo de los toggles tipo iPhone */
.toggle-checkbox {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 28px;
}

.toggle-checkbox input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    border-radius: 50%;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
}

input:checked + .slider {
    background-color: #4CAF50;
}

input:checked + .slider:before {
    transform: translateX(22px);
}

/* Estilo general */
.form-control {
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 1rem;
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

.button-container .btn {
        margin-right: 10px;
    }

</style>
@stop

@section('content')
<div class="container">
    <h2 class="title">Crear Nueva Interfaces</h2>

    <form action="{{ route('objetos.store') }}" method="POST">
        @csrf

        

        <!-- Selección de Roles y Permisos -->
        <div class="form-group mt-3">
            <label for="roles">Roles y Permisos</label>
            <div class="row">
                @foreach ($roles as $role)
                    <div class="col-md-6 mb-4" id="roleBox{{ $role->id }}">
                        <!-- Selección del rol con icono deslizante -->
                        <div class="form-check">
                            <label class="toggle-checkbox">
                                <input type="checkbox" name="roles[{{ $role->id }}][id]" 
                                       value="{{ $role->id }}" class="role-checkbox" 
                                       id="role{{ $role->id }}">
                                <span class="slider"></span>
                            </label>
                            <label class="form-check-label" for="role{{ $role->id }}">{{ $role->name }}</label>
                        </div>

                        <!-- Permisos del rol (mostrar rutas y acciones) -->
                        <div class="mt-3 permissions" id="permissions{{ $role->id }}" style="display:none;">
                            @foreach ($rutas as $route => $label)
                                <div class="permission-card">
                                    <div class="permission-card-header">{{ $label }}</div>
                                    <div class="permission-card-body">
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   name="roles[{{ $role->id }}][permisos][{{ $route }}][ver]" 
                                                   value="1" 
                                                   class="form-check-input" 
                                                   id="ver-{{ $role->id }}-{{ $route }}">
                                            <label class="form-check-label" for="ver-{{ $role->id }}-{{ $route }}">Ver</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   name="roles[{{ $role->id }}][permisos][{{ $route }}][insertar]" 
                                                   value="1" 
                                                   class="form-check-input" 
                                                   id="insertar-{{ $role->id }}-{{ $route }}">
                                            <label class="form-check-label" for="insertar-{{ $role->id }}-{{ $route }}">Insertar</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   name="roles[{{ $role->id }}][permisos][{{ $route }}][editar]" 
                                                   value="1" 
                                                   class="form-check-input" 
                                                   id="editar-{{ $role->id }}-{{ $route }}">
                                            <label class="form-check-label" for="editar-{{ $role->id }}-{{ $route }}">Editar</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   name="roles[{{ $role->id }}][permisos][{{ $route }}][eliminar]" 
                                                   value="1" 
                                                   class="form-check-input" 
                                                   id="eliminar-{{ $role->id }}-{{ $route }}">
                                            <label class="form-check-label" for="eliminar-{{ $role->id }}-{{ $route }}">Eliminar</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

         <!-- Botones alineados a la derecha -->
         <div class="button-container">
                <a href="{{ route('objetos.index') }}" class="btn btn-cancel transition">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-save transition">
                    Guardar
                </button>
            </div>
    </form>
</div>

@push('js')
<script>
    // Eliminar esta función de validación de caracteres especiales
/*
document.getElementById('name').addEventListener('keydown', function(event) {
    const regex = /^[a-zA-Z0-9\s]*$/; // Permite solo letras, números y espacios

    // Si el valor de la tecla presionada no cumple con el regex, prevenir la entrada
    if (!regex.test(event.key) && event.key !== 'Backspace' && event.key !== 'Tab' && event.key !== 'Delete') {
        event.preventDefault();
    }
});
*/

    // Mostrar y ocultar permisos según el checkbox del rol
    document.querySelectorAll('.role-checkbox').forEach(input => {
        input.addEventListener('change', function() {
            const roleId = this.id.replace('role', '');
            const permissionDiv = document.getElementById('permissions' + roleId);
            const roleBox = document.getElementById('roleBox' + roleId);
            
            if (this.checked) {
                // Ocultar otros roles
                document.querySelectorAll('.role-checkbox').forEach(box => {
                    if (box !== this) {
                        box.parentElement.parentElement.style.display = 'none';
                    }
                });
                permissionDiv.style.display = 'block';
            } else {
                // Mostrar otros roles
                document.querySelectorAll('.role-checkbox').forEach(box => {
                    box.parentElement.parentElement.style.display = 'block';
                });
                permissionDiv.style.display = 'none';
            }
        });
    });
</script>
@endpush

@endsection



