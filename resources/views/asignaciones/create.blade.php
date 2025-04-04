@extends('adminlte::page')

@section('title', 'Crear Asignación')

@section('content_header')
<h1>Crear Nueva Asignación</h1>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('asignaciones.store') }}" method="POST">
            @csrf

            <div class="form-group">
    <label for="id_equipo">Equipo</label>
    <select name="id_equipo" id="id_equipo" class="form-control @error('id_equipo') is-invalid @enderror" required>
        <option value="">Seleccione un equipo</option>
        @foreach($equipos as $equipo)
            <option value="{{ $equipo->id_equipo }}" {{ old('id_equipo') == $equipo->id_equipo ? 'selected' : '' }} 
                    data-tipo-equipo="{{ $equipo->tipo_equipo }}">
                {{ $equipo->cod_equipo }} - {{ $equipo->tipo_equipo }}
            </option>
        @endforeach
    </select>
    @error('id_equipo')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>



<div class="form-group">
    <label for="id_sucursal">Sucursal</label>
    <select name="id_sucursal" id="id_sucursal" class="form-control @error('id_sucursal') is-invalid @enderror" required>
        <option value="">Seleccione una sucursal</option>
        @foreach($sucursales as $sucursal)
            <option value="{{ $sucursal->id_sucursal }}" {{ old('id_sucursal') == $sucursal->id_sucursal ? 'selected' : '' }}>
                {{ $sucursal->nombre_sucursal }}
            </option>
        @endforeach
    </select>
    @error('id_sucursal')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>


            <!-- Campo Empleado -->
            <div class="form-group" id="empleado_group">
                <label for="cod_empleados">Empleado:</label>
                <select id="cod_empleados" name="cod_empleados" class="form-control">
                    <option value="">Seleccione un empleado</option>
                </select>
            </div>

            <!-- Campo Área -->
            <div class="form-group" id="area_group">
                <label for="id_area">Área:</label>
                <select id="id_area" name="id_area" class="form-control">
                    <option value="">Seleccione un área</option>
                </select>
            </div>


            <div class="form-group">
    <label for="detalle_asignacion">Detalle de Asignación:</label>
    <input type="text" id="detalle_asignacion" name="detalle_asignacion" 
           class="form-control @error('detalle_asignacion') is-invalid @enderror" 
           value="{{ old('detalle_asignacion') }}" 
           placeholder="Ingrese el detalle de la asignación" 
           required>
    @error('detalle_asignacion')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    </div>

    <div class="form-group">
    <label for="fecha_asignacion">Fecha de Asignación:</label>
    <input type="date" id="fecha_asignacion" name="fecha_asignacion" class="form-control @error('fecha_asignacion') is-invalid @enderror" value="{{ old('fecha_asignacion') }}" required>
    <span id="mensaje_fecha" class="text-danger" style="display: none;"></span>
    @error('fecha_asignacion')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

            <div class="form-group">
    <label for="fecha_devolucion">Fecha de Devolución:</label>
    <input type="date" id="fecha_devolucion" name="fecha_devolucion" 
           class="form-control @error('fecha_devolucion') is-invalid @enderror" 
           value="{{ old('fecha_devolucion') }}">
    @error('fecha_devolucion')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    <span id="mensaje_fecha_devolucion" style="color: red; display: none;">La fecha de devolución no puede ser menor que la fecha de asignación.</span>
</div>


<div class="form-group">
    <label for="suministros">Suministros:</label>
    <div class="form-check mb-2">
        @foreach($suministros as $suministro)
            <div class="form-check form-check-inline mb-2">
                <input
                    type="checkbox"
                    class="form-check-input"
                    id="suministro_{{ $suministro->id_suministro }}"
                    name="suministros[]"
                    value="{{ $suministro->id_suministro }}"
                    {{ $suministro->cantidad_suministro > 0 ? '' : 'disabled' }}
                    {{ in_array($suministro->id_suministro, old('suministros', [])) ? 'checked' : '' }}
                >
                <label 
                    class="form-check-label {{ $suministro->cantidad_suministro > 0 ? '' : 'text-muted' }}" 
                    for="suministro_{{ $suministro->id_suministro }}"
                >
                    {{ $suministro->nombre_suministro }} 
                    ({{ $suministro->cantidad_suministro > 0 ? 'Disponibles: ' . $suministro->cantidad_suministro : 'Sin stock' }})
                </label>
            </div>
        @endforeach
    </div>
</div>





<div class="form-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('asignaciones.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script src="{{ asset('vendor/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function() {

        // Validaciones por tipo de campo
        function validateInput(selector, regex) {
            $(selector).on('input', function() {
                this.value = this.value.replace(regex, '');
            });
        }

        validateInput('#detalle_asignacion', /[^a-zA-Z\s]/g); // Solo letras

        // Validación para fecha de adquisición
       
$('#fecha_asignacion').on('change', function() {
    const fechaSeleccionada = new Date(this.value);
    const fechaActual = new Date();
    const mensajeFecha = $('#mensaje_fecha');

    // Ajustar la fecha actual para comparar solo el año, mes y día (sin horas)
    fechaActual.setHours(0, 0, 0, 0);  // Esto hace que la hora se ponga a las 00:00:00 para solo comparar fecha

    // Verificar si la fecha seleccionada es mayor a la fecha actual
    if (fechaSeleccionada > fechaActual) {
        mensajeFecha.text('La fecha de asignación no puede ser mayor a la fecha actual.');
        mensajeFecha.show();
        this.value = '';  // Limpiar el valor de la fecha
    } else {
        mensajeFecha.hide();
    }
});

        // Validación para fecha de devolución
    $('#fecha_devolucion').on('change', function () {
        const fechaAsignacion = $('#fecha_asignacion').val();
        if (fechaAsignacion) {
            validarFechasDevolucion(fechaAsignacion, this.value);
        }
    });

    // Función para validar que la fecha de devolución no sea menor que la fecha de asignación
    function validarFechasDevolucion(fechaAsignacion, fechaDevolucion) {
        const fechaAsignacionDate = new Date(fechaAsignacion);
        const fechaDevolucionDate = new Date(fechaDevolucion);
        const mensajeFechaDevolucion = $('#mensaje_fecha_devolucion');

        if (fechaDevolucionDate < fechaAsignacionDate) {
            mensajeFechaDevolucion.text('La fecha de devolución no puede ser menor que la fecha de asignación.');
            mensajeFechaDevolucion.show();
            $('#fecha_devolucion').val('');
        } else {
            mensajeFechaDevolucion.hide();
        }
    }

        $('#id_sucursal').change(function() {
            var idSucursal = $(this).val();
            $('#cod_empleados').empty().append('<option value="">Seleccione un empleado</option>');

            if (idSucursal) {
                $.ajax({
                    url: '/asignaciones/empleados/' + idSucursal, // Cambiamos la URL aquí
                    type: 'GET',
                    success: function(data) {
                        $.each(data, function(index, empleado) {
                            $('#cod_empleados').append('<option value="' + empleado.cod_empleados + '">' + empleado.nombre_empleado + ' ' + empleado.apellido_empleado + '</option>');
                        });
                    }
                });
            }
        });


        document.getElementById('cod_empleados').addEventListener('change', function() {
            const empleadoId = this.value;

            if (empleadoId) {
                fetch(`/asignaciones/empleados/${empleadoId}/areas`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Respuesta del servidor:', data); // Depuración
                        const areaDropdown = document.getElementById('id_area');
                        areaDropdown.innerHTML = '<option value="">Seleccione un área</option>';

                        if (data.success && data.areas) {
                            // Si hay un área, agregarla al dropdown
                            areaDropdown.innerHTML = `<option value="${data.areas.id_area}" selected>${data.areas.nombre_area}</option>`;
                        } else {
                            console.error(data.message || 'Error al cargar el área.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });




        //Ocultar empleado y area
        $('#id_equipo').change(function() {
            const tipoEquipo = $(this).find(':selected').data('tipo-equipo');
            const empleadoGroup = $('#empleado_group');
            const areaGroup = $('#area_group');

            if (tipoEquipo === 'Impresora') {
                // Si es impresora, solo se muestra el área
                empleadoGroup.hide();
                $('#cod_empleados').val(''); // Limpia el campo de empleado
                areaGroup.show();
            } else if (tipoEquipo === 'Computadora') {
                // Si es computadora, solo se muestra el empleado
                areaGroup.hide();
                $('#id_area').val(''); // Limpia el campo de área
                empleadoGroup.show();
            } else {
                // En caso de otro tipo de equipo o selección vacía, muestra ambos
                empleadoGroup.show();
                areaGroup.show();
            }
        });

        // Cargar empleados según la sucursal seleccionada
        $('#id_sucursal').change(function() {
            const idSucursal = $(this).val();
            const empleadoDropdown = $('#cod_empleados');
            const areaDropdown = $('#id_area');

            empleadoDropdown.empty().append('<option value="">Seleccione un empleado</option>');
            areaDropdown.empty().append('<option value="">Seleccione un área</option>');

            if (idSucursal) {
                // Cargar empleados
                $.get(`/asignaciones/empleados/${idSucursal}`, function(data) {
                    if (data.success) {
                        data.empleados.forEach((empleado) => {
                            empleadoDropdown.append(
                                `<option value="${empleado.cod_empleados}">${empleado.nombre_empleado} ${empleado.apellido_empleado}</option>`
                            );
                        });
                    }
                });

                // Cargar áreas
                $.get(`/asignaciones/areas/${idSucursal}`, function(data) {
                    if (data.success) {
                        data.areas.forEach((areas) => {
                            areaDropdown.append(
                                `<option value="${areas.id_area}">${areas.nombre_area}</option>`
                            );
                        });
                    }
                });
            }
        });
    });
</script>

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2/css/select2.min.css') }}">
@stop
