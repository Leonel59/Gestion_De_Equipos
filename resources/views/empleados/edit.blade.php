@extends('adminlte::page')

@section('title', 'Editar Empleado')

@section('content_header')
    <h1>Editar Empleado</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Modificar Datos del Empleado</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('empleados.update', $empleado->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="cod_empleado">Código Empleado</label>
                        <input type="text" class="form-control" id="cod_empleado" name="cod_empleado" value="{{ $empleado->cod_empleado }}" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="{{ $empleado->correo }}" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $empleado->telefono }}">
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $empleado->direccion }}">
                    </div>
                    <div class="form-group">
                        <label for="sucursal">Sucursal</label>
                        <input type="text" class="form-control" id="sucursal" name="sucursal" value="{{ $empleado->sucursal }}">
                    </div>
                    <div class="form-group">
                        <label for="area">Área</label>
                        <input type="text" class="form-control" id="area" name="area" value="{{ $empleado->area }}">
                    </div>
                    <div class="form-group">
                        <label for="dni_empleado">DNI Empleado</label>
                        <input type="text" class="form-control" id="dni_empleado" name="dni_empleado" value="{{ $empleado->dni_empleado }}" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre_empleado">Nombre</label>
                        <input type="text" class="form-control" id="nombre_empleado" name="nombre_empleado" value="{{ $empleado->nombre_empleado }}" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido_empleado">Apellido</label>
                        <input type="text" class="form-control" id="apellido_empleado" name="apellido_empleado" value="{{ $empleado->apellido_empleado }}" required>
                    </div>
                    <div class="form-group">
                        <label for="cargo_empleado">Cargo</label>
                        <input type="text" class="form-control" id="cargo_empleado" name="cargo_empleado" value="{{ $empleado->cargo_empleado }}" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_contratacion">Fecha de Contratación</label>
                        <input type="date" class="form-control" id="fecha_contratacion" name="fecha_contratacion" value="{{ $empleado->fecha_contratacion }}" required>
                    </div>
                    <div class="form-group">
                        <label for="sexo_empleado">Sexo</label>
                        <select class="form-control" id="sexo_empleado" name="sexo_empleado" required>
                            <option value="">Seleccione</option>
                            <option value="masculino" {{ $empleado->sexo_empleado == 'masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="femenino" {{ $empleado->sexo_empleado == 'femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="otro" {{ $empleado->sexo_empleado == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection