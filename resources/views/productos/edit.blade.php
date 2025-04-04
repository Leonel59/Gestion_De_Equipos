@extends('adminlte::page')

@section('title', 'Editar Producto de Mantenimiento')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Editar Producto de Mantenimiento</h1>
@stop

@section('content')
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-gradient-primary text-white rounded-top d-flex justify-content-between align-items-center">
            <h3 class="card-title">Actualizar Producto</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST" id="editForm">
                @csrf
                @method('PUT')

                <!-- Selección del Servicio de Mantenimiento -->
                <div class="form-group">
                    <label for="servicio_mantenimiento_id">Servicio de Mantenimiento</label>
                    <select name="servicio_mantenimiento_id" class="form-control" id="servicio_mantenimiento_id" required>
                        <option value="">Seleccionar Servicio</option>
                        @foreach ($servicios as $servicio)
                            <option value="{{ $servicio->id_mant }}" 
                                    data-equipo="{{ $servicio->id_equipo_mant }}" 
                                    data-descripcion="{{ $servicio->descripcion_mantenimiento }}"
                                    @if ($servicio->id_mant == $producto->servicio_mantenimiento_id) selected @endif>
                                {{ $servicio->id_equipo_mant }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Mostrar el Equipo -->
                <div class="form-group" id="equipo_group" style="display:none;">
                    <label for="equipo_mantenimiento">Equipo</label>
                    <input type="text" name="equipo_mantenimiento" id="equipo_mantenimiento" class="form-control" readonly value="{{ old('equipo_mantenimiento', $producto->servicioMantenimiento->id_equipo_mant ?? '') }}">
                </div>

                <!-- Mostrar la Descripción del Mantenimiento -->
                <div class="form-group" id="descripcion_group" style="display:none;">
                    <label for="descripcion_mantenimiento">Descripción del Mantenimiento</label>
                    <input type="text" name="descripcion_mantenimiento" id="descripcion_mantenimiento" class="form-control" readonly value="{{ old('descripcion_mantenimiento', $producto->servicioMantenimiento->descripcion_mantenimiento ?? '') }}">
                </div>
                
                <!-- Campo Nombre Producto -->
<div class="form-group">
    <label for="nombre_producto">Nombre del Producto</label>
    <input type="text" name="nombre_producto" class="form-control" value="{{ old('nombre_producto', $producto->nombre_producto) }}" required id="nombre_producto">
    <small class="text-danger d-none" id="nombreError">Solo se permiten letras y espacios.</small>
</div>

               <!-- Campo Descripción Producto -->
<div class="form-group">
    <label for="descripcion_producto">Descripción del Producto</label>
    <input type="text" name="descripcion_producto" class="form-control" value="{{ old('descripcion_producto', $producto->descripcion_producto) }}" required id="descripcion_producto">
    <small class="text-danger d-none" id="descripcionError">Solo se permiten letras y espacios.</small>
</div>

                <!-- Campo Cantidad Producto -->
                <div class="form-group">
                    <label for="cantidad_producto">Cantidad</label>
                    <input type="number" name="cantidad_producto" class="form-control" value="{{ old('cantidad_producto', $producto->cantidad_producto) }}" required placeholder="Cantidad del producto" id="cantidad_producto">
                </div>

                <!-- Campo Costo Producto -->
                <div class="form-group">
                    <label for="costo_producto">Costo</label>
                    <input type="number" step="0.01" name="costo_producto" class="form-control" value="{{ old('costo_producto', $producto->costo_producto) }}" required placeholder="Costo del producto" id="costo_producto">
                </div>

                <!-- Campo Fecha Adquisición Producto -->
                <div class="form-group">
                    <label for="fecha_adquisicion_producto">Fecha de Adquisición</label>
                    <input type="date" name="fecha_adquisicion_producto" class="form-control" value="{{ old('fecha_adquisicion_producto', $producto->fecha_adquisicion_producto) }}" required id="fecha_adquisicion_producto">
                </div>

                <div class="d-flex justify-content-end mt-3">
    <a href="{{ route('productos.index') }}" class="btn btn-secondary ">Cancelar</a>
    <button type="submit" class="btn btn-primary ">Actualizar Producto</button>
</div>
            </form>
        </div>
    </div>

    @push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Bloquear fechas futuras en el campo de fecha
            let fechaInput = document.getElementById('fecha_adquisicion_producto');
            let hoy = new Date().toISOString().split('T')[0];
            fechaInput.setAttribute('max', hoy);

            // Mostrar equipo y descripción al cargar si hay datos
            let servicioSelect = document.getElementById('servicio_mantenimiento_id');
            let equipoInput = document.getElementById('equipo_mantenimiento');
            let descripcionInput = document.getElementById('descripcion_mantenimiento');
            let equipoGroup = document.getElementById('equipo_group');
            let descripcionGroup = document.getElementById('descripcion_group');

            function actualizarEquipoDescripcion() {
                let selectedOption = servicioSelect.options[servicioSelect.selectedIndex];
                let equipo = selectedOption.getAttribute('data-equipo');
                let descripcion = selectedOption.getAttribute('data-descripcion');

                if (equipo && descripcion) {
                    equipoInput.value = equipo;
                    descripcionInput.value = descripcion;
                    equipoGroup.style.display = 'block';
                    descripcionGroup.style.display = 'block';
                } else {
                    equipoGroup.style.display = 'none';
                    descripcionGroup.style.display = 'none';
                }
            }

            servicioSelect.addEventListener('change', actualizarEquipoDescripcion);
            actualizarEquipoDescripcion(); // Ejecutar al cargar

            // Validaciones en tiempo real para Nombre y Descripción
            function validarTexto(input, errorElement) {
                let regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
                if (!regex.test(input.value)) {
                    input.classList.add('is-invalid');
                    errorElement.classList.remove('d-none');
                } else {
                    input.classList.remove('is-invalid');
                    errorElement.classList.add('d-none');
                }
            }

            let nombreProducto = document.getElementById('nombre_producto');
            let descripcionProducto = document.getElementById('descripcion_producto');
            let nombreError = document.getElementById('nombreError');
            let descripcionError = document.getElementById('descripcionError');

            nombreProducto.addEventListener('input', function () {
                validarTexto(nombreProducto, nombreError);
            });

            descripcionProducto.addEventListener('input', function () {
                validarTexto(descripcionProducto, descripcionError);
            });

            // Validaciones antes de enviar el formulario
            document.getElementById('editForm').addEventListener('submit', function (event) {
                let valido = true;
                let mensajesError = [];

                if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(nombreProducto.value)) {
                    valido = false;
                    nombreProducto.classList.add('is-invalid');
                    nombreError.classList.remove('d-none');
                    mensajesError.push("El nombre del producto solo puede contener letras y espacios.");
                }

                if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(descripcionProducto.value)) {
                    valido = false;
                    descripcionProducto.classList.add('is-invalid');
                    descripcionError.classList.remove('d-none');
                    mensajesError.push("La descripción del producto solo puede contener letras y espacios.");
                }

                if (!valido) {
                    event.preventDefault();
                    alert(mensajesError.join("\n"));
                }
            });
        });
    </script>
@endpush

@stop

@push('css')
    <style>
        .card {
            border-radius: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-lg {
            border-radius: 30px;
            font-size: 1.1rem;
        }
        .btn-sm {
            border-radius: 20px;
        }
        .alert {
            border-radius: 10px;
        }
        .form-control {
            border-radius: 10px;
        }
        .is-invalid {
            border: 2px solid red;
            background-color: #fdd;
        }
    </style>
@endpush


