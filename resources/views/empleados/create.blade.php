@extends('adminlte::page')

@section('title', 'Agregar Empleado')

@section('content_header')
<h1>Agregar Empleado</h1>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('empleados.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="nombre_empleado">Nombre</label>
                        <input type="text" class="form-control" id="nombre_empleado" name="nombre_empleado" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido_empleado">Apellido</label>
                        <input type="text" class="form-control" id="apellido_empleado" name="apellido_empleado" required>
                    </div>
                    <div class="form-group">
                        <label for="id_sucursal">Sucursal:</label>
                        <select class="form-control" id="id_sucursal" name="id_sucursal" required>
                            <option value="">Seleccione una sucursal</option>
                            @foreach ($sucursales as $sucursal)
                            <option value="{{ $sucursal->id_sucursal }}">{{ $sucursal->nombre_sucursal }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_area">Área:</label>
                        <select class="form-control" id="id_area" name="id_area" required>
                            <option value="">Seleccione un área</option>
                            <!-- Las áreas se cargarán dinámicamente mediante JavaScript -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cargo_empleado">Cargo</label>
                        <input type="text" class="form-control" id="cargo_empleado" name="cargo_empleado" required>
                    </div>
                    <div class="form-group">
                        <label for="estado_empleado">Estado</label>
                        <select class="form-control" id="estado_empleado" name="estado_empleado" required>
                            <option value="">Seleccione</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_contratacion">Fecha de Contratación</label>
                        <input type="date" class="form-control" id="fecha_contratacion" name="fecha_contratacion" required>
                        <span id="mensaje_fecha" class="text-danger" style="display: none;"></span>
                    </div>
                    <!-- Correos -->

                    <div class="form-group">
                        <label for="correo_personal">Correo Personal</label>
                        <input type="email" class="form-control" id="correo_personal" name="correo_personal" placeholder="example@gmail.com">
                    </div>

                    <div class="form-group">
                        <label for="correo_profesional">Correo Profesional (Opcional)</label>
                        <input type="email" class="form-control" id="correo_profesional" name="correo_profesional" placeholder="example@gmail.com">
                    </div>


                </div>
                <div class="col-md-6">
                    <!-- Teléfonos -->

                    <div class="form-group">
                        <label for="telefono_personal">Número de Teléfono Personal</label>
                        <input type="text" class="form-control" id="telefono_personal" name="telefono_personal" placeholder="+504 3367-8945">
                    </div>
                    <div class="form-group">
                        <label for="telefono_trabajo">Número de Teléfono Laboral (Opcional)</label>
                        <input type="text" class="form-control" id="telefono_trabajo" name="telefono_trabajo" placeholder="+504 2200-8945">
                    </div>

                    <!-- Direcciones -->
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion">
                    </div>
                    <div class="form-group">
                        <label for="departamento">Departamento</label>
                        <input type="text" class="form-control" id="departamento" name="departamento">
                    </div>
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad">
                    </div>
                </div>
            </div>
    </div>
    <div class="modal-footer">
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
    </form>
</div>
</div>
@endsection

@section('js')
<script>
    $('#id_sucursal').on('change', function() {
        var sucursalID = $(this).val();
        if (sucursalID) {
            $.ajax({
                url: '/get-areas/' + sucursalID,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#id_area').empty().append('<option value="">Seleccione un área</option>');
                    $.each(data, function(key, value) {
                        $('#id_area').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        } else {
            $('#id_area').empty().append('<option value="">Seleccione un área</option>');
        }
    });

    // Validaciones por tipo de campo
    function validateInput(selector, regex) {
        $(selector).on('input', function() {
            this.value = this.value.replace(regex, '');
        });
    }

    // Aplicación de validaciones específicas
    validateInput('#nombre_empleado, #apellido_empleado, #cargo_empleado', /[^a-zA-Z\s]/g); // Solo letras
    validateInput('#departamento, #ciudad', /[^a-zA-Z\s]/g); // Solo letras
    validateInput('#direccion', /[^a-zA-Z\s]/g); // Solo letras

    // Validación para fecha de contratacion
    $('#fecha_contratacion').on('change', function() {
        const fechaSeleccionada = new Date(this.value);
        const fechaActual = new Date();
        const mensajeFecha = $('#mensaje_fecha');

        if (fechaSeleccionada > fechaActual) {
            mensajeFecha.text('No puede ser mayor a la fecha actual.');
            mensajeFecha.show();
            this.value = '';
        } else {
            mensajeFecha.hide();
        }
    });

    // Validacion para ingresar telefonos
    document.querySelectorAll('#telefono_personal, #telefono_trabajo').forEach(function(input) {
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

</script>
@endsection