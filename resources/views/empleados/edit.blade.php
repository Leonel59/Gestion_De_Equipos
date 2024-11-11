@extends('adminlte::page')

@section('title', 'Editar Empleado')

@section('content_header')
<h1>Editar Empleado</h1>
@endsection
@if(session('mensaje'))
<div class="alert alert-success">
    {{ session('mensaje') }}
</div>
@endif

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Modificar Datos del Empleado</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('empleados.update', $empleado->cod_empleados) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_empleado">Nombre</label>
                                <input type="text" class="form-control" name="nombre_empleado" value="{{old ('nombre_empleado', $empleado->nombre_empleado) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="apellido_empleado">Apellido</label>
                                <input type="text" class="form-control" name="apellido_empleado" value="{{old ('apellido_empleado', $empleado->apellido_empleado) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="id_sucursal">Sucursal</label>
                                <select class="form-control" id="id_sucursal" name="id_sucursal" required>
                                    <option value="">Seleccione una sucursal</option>
                                    @foreach ($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id_sucursal }}" {{ $empleado->id_sucursal == $sucursal->id_sucursal ? 'selected' : '' }}>
                                        {{ $sucursal->nombre_sucursal }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_area">Área</label>
                                <select class="form-control" id="id_area" name="id_area" required>
                                    <option value="">Seleccione un área</option>
                                    @foreach ($areas as $area)
                                    <option value="{{ $area->id_area }}" {{ $empleado->id_area == $area->id_area ? 'selected' : '' }}>
                                        {{ $area->nombre_area }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cargo_empleado">Cargo</label>
                                <input type="text" class="form-control" name="cargo_empleado" value="{{old ('cargo_empleado', $empleado->cargo_empleado) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="estado_empleado">Estado</label>
                                <select class="form-control" id="estado_empleado" name="estado_empleado" required>
                                    <option value="Activo" {{ $empleado->estado_empleado == 'Activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="Inactivo" {{ $empleado->estado_empleado == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="fecha_contratacion">Fecha de Contratación</label>
                                <input type="date" class="form-control" name="fecha_contratacion" value="{{ old ('fecha_contratacion', $empleado->fecha_contratacion) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="correo_personal">Correo Personal</label>
                                <input type="email" class="form-control" name="correo_personal" placeholder="example@gmail.com" value="{{ old('correo_personal', $empleado->correos->first()->correo_personal ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="correo_profesional">Correo Profesional (Opcional)</label>
                                <input type="email" class="form-control" name="correo_profesional" placeholder="example@gmail.com"  value="{{ old('correo_profesional', $empleado->correos->first()->correo_profesional ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="telefono_personal">Número de Teléfono Personal</label>
                                <input type="text" class="form-control" name="telefono_personal" placeholder="+504 3367-8945" value="{{ old('telefono_personal', $empleado->telefonos->first()->telefono_personal ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="telefono_trabajo">Número de Teléfono Laboral (Opcional)</label>
                                <input type="text" class="form-control" name="telefono_trabajo" placeholder="+504 2200-6644" value="{{ old('telefono_trabajo', $empleado->telefonos->first()->telefono_trabajo ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" name="direccion" value="{{ old('direccion', $empleado->direcciones->first()->direccion ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <input type="text" class="form-control" name="departamento" value="{{ old('departamento',$empleado->direcciones->first()->departamento ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="ciudad">Ciudad</label>
                                <input type="text" class="form-control" name="ciudad" value="{{ old('ciudad', $empleado->direcciones->first()->ciudad ?? '') }}">
                            </div>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary">Actualizar </button>
                    <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
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