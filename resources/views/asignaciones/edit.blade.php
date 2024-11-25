@extends('adminlte::page')

@section('title', 'Editar Asignación')

@section('content_header')
<h1>Editar Asignación</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('asignaciones.update', $asignacion->id_asignacion) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Equipo -->
            <div class="form-group">
                <label for="id_equipo">Equipo:</label>
                <select id="id_equipo" name="id_equipo" class="form-control" required>
                    <option value="">Seleccione un equipo</option>
                    @foreach($equipos as $equipo)
                    <option value="{{ $equipo->id_equipo }}" data-tipo-equipo="{{ $equipo->tipo_equipo }}" {{ $asignacion->id_equipo == $equipo->id_equipo ? 'selected' : '' }}>
                        {{ $equipo->cod_equipo }} - {{ $equipo->tipo_equipo }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Sucursal -->
            <div class="form-group">
                <label for="id_sucursal">Sucursal:</label>
                <select id="id_sucursal" name="id_sucursal" class="form-control" required>
                    <option value="">Seleccione una sucursal</option>
                    @foreach($sucursales as $sucursal)
                    <option value="{{ $sucursal->id_sucursal }}" {{ $asignacion->id_sucursal == $sucursal->id_sucursal ? 'selected' : '' }}>
                        {{ $sucursal->nombre_sucursal }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Empleado -->
            <div class="form-group" id="empleado_group">
                <label for="cod_empleados">Empleado:</label>
                <select id="cod_empleados" name="cod_empleados" class="form-control">
                    <option value="">Seleccione un empleado</option>
                    @foreach($empleados as $empleado)
                        <option value="{{ $empleado->cod_empleados }}" 
                            {{ old('cod_empleados', $asignacion->cod_empleados) == $empleado->cod_empleados ? 'selected' : '' }}>
                            {{ $empleado->nombre_empleado }} {{ $empleado->apellido_empleado }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Área -->
            <div class="form-group" id="area_group">
                <label for="id_area">Área:</label>
                <select id="id_area" name="id_area" class="form-control">
                    <option value="">Seleccione un área</option>
                    @if ($areas)
                    <option value="{{ $areas->id_area }}" selected>{{ $areas->nombre_area }}</option>
                    @endif
                </select>
            </div>

            <!-- Detalle de la Asignación -->
            <div class="form-group">
                <label for="detalle_asignacion">Detalle de Asignación:</label>
                <input type="text" id="detalle_asignacion" name="detalle_asignacion" class="form-control @error('detalle_asignacion') is-invalid @enderror" value="{{ old('detalle_asignacion', $asignacion->detalle_asignacion) }}">
                @error('detalle_asignacion')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Fecha de Asignación -->
            <div class="form-group">
                <label for="fecha_asignacion">Fecha de Asignación:</label>
                <input type="date" class="form-control" id="fecha_asignacion" name="fecha_asignacion" 
                    value="{{ old('fecha_asignacion', $asignacion->fecha_asignacion) }}" required>
                <small id="fechaWarning" class="text-danger" style="display: none;">No puede ser mayor a la fecha actual.</small>
                <span id="mensaje_fecha" class="text-danger" style="display: none;"></span>
            </div>

            <!-- Fecha de Devolución -->
            <div class="form-group">
                <label for="fecha_devolucion">Fecha de Devolución:</label>
                <input type="date" class="form-control @error('fecha_devolucion') is-invalid @enderror" id="fecha_devolucion" name="fecha_devolucion" 
                    value="{{ old('fecha_devolucion', $asignacion->fecha_devolucion) }}">
                @error('fecha_devolucion')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <small id="fechaWarningDevolucion" class="text-danger" style="display: none;">No puede ser menor a la fecha de asignacion.</small>
            </div>

            <!-- Suministros -->
            <div class="form-group">
                <label for="suministros">Suministros:</label>
                <div class="d-flex flex-wrap">
                    @foreach($suministros as $suministro)
                        <div class="form-check form-check-inline mb-2">
                            <input 
                                type="checkbox" 
                                class="form-check-input" 
                                id="suministro_{{ $suministro->id_suministro }}" 
                                name="suministros[]" 
                                value="{{ $suministro->id_suministro }}"
                                {{ in_array($suministro->id_suministro, $asignacion->suministros->pluck('id_suministro')->toArray()) ? 'checked' : '' }}
                            >
                            <label 
                                class="form-check-label" 
                                for="suministro_{{ $suministro->id_suministro }}"
                            >
                                {{ $suministro->nombre_suministro }} 
                                ({{ $suministro->cantidad_suministro > 0 ? 'Disponibles: ' . $suministro->cantidad_suministro : 'Sin stock' }})
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Botones -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('asignaciones.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
$(document).ready(function () {
    // Validaciones por tipo de campo
    function validateInput(selector, regex) {
        $(selector).on('input', function () {
            this.value = this.value.replace(regex, '');
        });
    }

    validateInput('#detalle_asignacion', /[^a-zA-Z\s]/g); // Solo letras

    // Validacion para la fecha de adquisición
    document.getElementById('fecha_asignacion').addEventListener('input', function () {
        var fechaSeleccionada = new Date(this.value);
        var fechaActual = new Date();

        fechaActual.setHours(0, 0, 0, 0); // Ajustar la fecha actual a solo la fecha

        if (fechaSeleccionada > fechaActual) {
            document.getElementById('fechaWarning').style.display = 'block'; // Mostrar advertencia
            this.value = ''; // Limpiar el campo de fecha
        } else {
            document.getElementById('fechaWarning').style.display = 'none'; // Ocultar advertencia
        }
    });

    // Validación para la fecha de devolución
    document.getElementById('fecha_devolucion').addEventListener('input', function () {
        var fechaAsignacion = document.getElementById('fecha_asignacion').value;
        var fechaDevolucion = new Date(this.value);

        if (!fechaAsignacion) {
            alert('Debe seleccionar una fecha de asignación primero.');
            this.value = ''; // Limpiar el campo de fecha
            return;
        }

        fechaAsignacion = new Date(fechaAsignacion);

        if (fechaDevolucion < fechaAsignacion) {
            document.getElementById('fechaWarningDevolucion').style.display = 'block'; // Mostrar advertencia
            this.value = ''; // Limpiar el campo de fecha
        } else {
            document.getElementById('fechaWarningDevolucion').style.display = 'none'; // Ocultar advertencia
        }
    });

    // Lógica inicial para ocultar/mostrar campos según el equipo seleccionado
    const tipoEquipoInicial = $('#id_equipo').find(':selected').data('tipo-equipo');
    toggleFields(tipoEquipoInicial);

    // Actualizar campos al cambiar el equipo
    $('#id_equipo').change(function () {
        const tipoEquipo = $(this).find(':selected').data('tipo-equipo');
        toggleFields(tipoEquipo);
    });

    function toggleFields(tipoEquipo) {
        const empleadoGroup = $('#empleado_group');
        const areaGroup = $('#area_group');

        if (tipoEquipo === 'Impresora') {
            empleadoGroup.hide(); // Ocultar empleados
            $('#cod_empleados').val(''); // Limpiar selección de empleado
            areaGroup.show(); // Mostrar área
        } else {
            empleadoGroup.show(); // Mostrar empleados
            areaGroup.hide(); // Ocultar área
        }
    }
});
</script>
@stop

