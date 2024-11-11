@extends('adminlte::page')

@section('title', 'Editar Producto de Mantenimiento')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Editar Producto de Mantenimiento</h1>
@stop

@section('content')
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-gradient-primary text-white rounded-top d-flex justify-content-start align-items-center">
            <h3 class="card-title mr-auto">Actualizar Producto</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST">
                @csrf
                @method('PUT') <!-- Método PUT para la actualización -->

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
                </div>

                <!-- Campo Descripción Producto -->
                <div class="form-group">
                    <label for="descripcion_producto">Descripción del Producto</label>
                    <input type="text" name="descripcion_producto" class="form-control" value="{{ old('descripcion_producto', $producto->descripcion_producto) }}" required id="descripcion_producto">
                </div>

                <!-- Campo Cantidad Producto -->
                <div class="form-group">
                    <label for="cantidad_producto">Cantidad</label>
                    <input type="number" name="cantidad_producto" class="form-control" value="{{ old('cantidad_producto', $producto->cantidad_producto) }}" placeholder="Cantidad del producto" id="cantidad_producto">
                </div>

                <!-- Campo Costo Producto -->
                <div class="form-group">
                    <label for="costo_producto">Costo</label>
                    <input type="number" step="0.01" name="costo_producto" class="form-control" value="{{ old('costo_producto', $producto->costo_producto) }}" placeholder="Costo del producto">
                </div>

                <!-- Campo Fecha Adquisición Producto -->
                <div class="form-group">
                    <label for="fecha_adquisicion_producto">Fecha de Adquisición</label>
                    <input type="date" name="fecha_adquisicion_producto" class="form-control" value="{{ old('fecha_adquisicion_producto', $producto->fecha_adquisicion_producto) }}">
                </div>

                <button type="submit" class="btn btn-primary btn-lg mt-3 rounded-pill">Actualizar Producto</button>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            // Detectar el cambio de selección en el campo "Servicio de Mantenimiento"
            document.getElementById('servicio_mantenimiento_id').addEventListener('change', function () {
                // Obtener los datos asociados al servicio seleccionado
                var selectedOption = this.options[this.selectedIndex];
                var equipo = selectedOption.getAttribute('data-equipo');
                var descripcion = selectedOption.getAttribute('data-descripcion');

                // Mostrar los campos de Equipo y Descripción del Mantenimiento si se selecciona un servicio
                if (equipo && descripcion) {
                    document.getElementById('equipo_mantenimiento').value = equipo;
                    document.getElementById('descripcion_mantenimiento').value = descripcion;
                    document.getElementById('equipo_group').style.display = 'block';
                    document.getElementById('descripcion_group').style.display = 'block';
                } else {
                    document.getElementById('equipo_group').style.display = 'none';
                    document.getElementById('descripcion_group').style.display = 'none';
                }
            });

            // Al cargar la página, si ya está seleccionado un servicio, mostrar el equipo y descripción
            window.addEventListener('DOMContentLoaded', function () {
                var selectedOption = document.getElementById('servicio_mantenimiento_id').options[document.getElementById('servicio_mantenimiento_id').selectedIndex];
                var equipo = selectedOption.getAttribute('data-equipo');
                var descripcion = selectedOption.getAttribute('data-descripcion');
                if (equipo && descripcion) {
                    document.getElementById('equipo_mantenimiento').value = equipo;
                    document.getElementById('descripcion_mantenimiento').value = descripcion;
                    document.getElementById('equipo_group').style.display = 'block';
                    document.getElementById('descripcion_group').style.display = 'block';
                }
            });

            // Filtrar caracteres especiales en los campos "Nombre Producto", "Descripción Producto" y "Cantidad"
            function removeSpecialChars(event) {
                // Expresión regular para permitir solo letras, números y espacios
                let regex = /[^a-zA-Z0-9\s]/g;
                event.target.value = event.target.value.replace(regex, '');
            }

            // Asignar el evento de entrada para los campos
            document.getElementById('nombre_producto').addEventListener('input', removeSpecialChars);
            document.getElementById('descripcion_producto').addEventListener('input', removeSpecialChars);
            document.getElementById('cantidad_producto').addEventListener('input', removeSpecialChars);
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
    </style>
@endpush

