@extends('adminlte::page')

@section('title', 'Crear Servicio de Mantenimiento')

@section('content')
<div class="container">
    <div class="card rounded-lg shadow-lg">
        <div class="card-header bg-primary text-white rounded-top">
            <h3 class="card-title">Crear Servicio de Mantenimiento</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('servicios.store') }}" method="POST">
                @csrf

                <!-- Información del equipo -->
                <h5>Información del Equipo</h5>
                <div class="form-group">
                    <label for="id_equipo_mant">Equipo de Mantenimiento</label>
                    <select class="form-control rounded" id="id_equipo_mant" name="id_equipo_mant" required>
                        <option value="">Seleccione un equipo</option>
                        @foreach($equipos as $equipo)
                            <option value="{{ $equipo->cod_equipo }}" 
                                    data-estado="{{ $equipo->estado_equipo }}" 
                                    {{ old('id_equipo_mant') == $equipo->cod_equipo ? 'selected' : '' }}>
                                {{ $equipo->cod_equipo }} - {{ $equipo->tipo_equipo }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_equipo_mant')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Estado del equipo -->
                <div class="form-group" id="estado_equipo_container" style="display: none;">
                    <label for="estado_equipo">Estado del Equipo</label>
                    <input type="text" class="form-control rounded" id="estado_equipo" name="estado_equipo" readonly>
                </div>

                <!-- Tipo de Mantenimiento -->
                <h5>Tipo de Mantenimiento</h5>
                <div class="form-group">
                    <label for="tipo_mantenimiento">Tipo de Mantenimiento</label>
                    <select class="form-control rounded" id="tipo_mantenimiento" name="tipo_mantenimiento" required>
                        <option value="">Seleccione el tipo</option>
                        <option value="Preventivo" {{ old('tipo_mantenimiento') == 'Preventivo' ? 'selected' : '' }}>Preventivo</option>
                        <option value="Correctivo" {{ old('tipo_mantenimiento') == 'Correctivo' ? 'selected' : '' }}>Correctivo</option>
                        <option value="Predictivo" {{ old('tipo_mantenimiento') == 'Predictivo' ? 'selected' : '' }}>Predictivo</option>
                    </select>
                    @error('tipo_mantenimiento')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Descripción -->
                <h5>Detalles del Mantenimiento</h5>
                <div class="form-group">
                    <label for="descripcion_mantenimiento">Descripción</label>
                    <textarea class="form-control rounded" id="descripcion_mantenimiento" name="descripcion_mantenimiento" rows="3" placeholder="Describa el mantenimiento realizado..." pattern="^[A-Za-zÀ-ÿ0-9\s]+$" title="Solo letras y números" required>{{ old('descripcion_mantenimiento') }}</textarea>
                    @error('descripcion_mantenimiento')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Cantidad y duración -->
                <div class="form-group">
                    <label for="cantidad_equipo_usado">Cantidad de Equipo Usado</label>
                    <input type="number" class="form-control rounded" id="cantidad_equipo_usado" name="cantidad_equipo_usado" value="{{ old('cantidad_equipo_usado') }}" min="1" placeholder="Ingrese la cantidad de equipo usado">
                    @error('cantidad_equipo_usado')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="duracion_mantenimiento">Duración de Mantenimiento (horas)</label>
                    <input type="number" class="form-control rounded" id="duracion_mantenimiento" name="duracion_mantenimiento" value="{{ old('duracion_mantenimiento') }}" min="1" step="0.1" placeholder="Duración en horas" required>
                    @error('duracion_mantenimiento')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Fechas -->
                <h5>Fechas del Mantenimiento</h5>
                <div class="form-group">
                    <label for="fecha_reparacion_equipo">Fecha de Reparación</label>
                    <input type="date" class="form-control rounded" id="fecha_reparacion_equipo" name="fecha_reparacion_equipo" value="{{ old('fecha_reparacion_equipo') }}" required>
                    @error('fecha_reparacion_equipo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha_entrega_equipo">Fecha de Entrega</label>
                    <input type="date" class="form-control rounded" id="fecha_entrega_equipo" name="fecha_entrega_equipo" value="{{ old('fecha_entrega_equipo') }}" required>
                    @error('fecha_entrega_equipo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Costos -->
                <h5>Costos</h5>
                <div class="form-group">
                    <label for="costo_mantenimiento">Costo de Mantenimiento</label>
                    <div class="input-group">
                        <select class="form-control" id="moneda" name="moneda" required>
                            <option value="HNL" {{ old('moneda') == 'HNL' ? 'selected' : '' }}>Lempiras (HNL)</option>
                            <option value="USD" {{ old('moneda') == 'USD' ? 'selected' : '' }}>Dólares (USD)</option>
                        </select>
                        <input type="number" class="form-control rounded" id="costo_mantenimiento" name="costo_mantenimiento" step="0.01" value="{{ old('costo_mantenimiento') }}" placeholder="Ejemplo: 100.00" required>
                    </div>
                    <small class="form-text text-muted">Ingrese el monto en el formato 100.00</small>
                    @error('costo_mantenimiento')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Información de creación y modificación -->
                <h5>Registro de Creación y Modificación</h5>
                <div class="form-group">
                    <label for="fecha_creacion">Fecha de Creación</label>
                    <input type="date" class="form-control rounded" id="fecha_creacion" name="fecha_creacion" value="{{ now()->format('Y-m-d') }}" readonly required>
                    @error('fecha_creacion')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
    <label for="modificado_por">Modificado Por</label>
    <input type="text" class="form-control rounded" id="modificado_por" name="modificado_por" 
           pattern="^[A-Za-zÀ-ÿ\s]+$" title="Solo letras, sin números ni caracteres especiales" 
           value="{{ Auth::user()->name }}" placeholder="Nombre del usuario" readonly>
    @error('modificado_por')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

                <div class="form-group">
                    <label for="fecha_modificacion">Fecha de Modificación</label>
                    <input type="date" class="form-control rounded" id="fecha_modificacion" name="fecha_modificacion" value="{{ now()->format('Y-m-d') }}" readonly>
                    @error('fecha_modificacion')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="form-group d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary rounded-pill">Crear Servicio</button>
                    <a href="{{ route('servicios.index') }}" class="btn btn-secondary rounded-pill">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const equipoSelect = document.getElementById('id_equipo_mant');
        const estadoEquipoContainer = document.getElementById('estado_equipo_container');
        const estadoEquipoInput = document.getElementById('estado_equipo');

        equipoSelect.addEventListener('change', function() {
            const selectedOption = equipoSelect.options[equipoSelect.selectedIndex];
            const estado = selectedOption.getAttribute('data-estado');

            if (estado) {
                estadoEquipoInput.value = estado;
                estadoEquipoContainer.style.display = 'block';
            } else {
                estadoEquipoContainer.style.display = 'none';
                estadoEquipoInput.value = '';
            }
        });
    });
</script>
@endsection



