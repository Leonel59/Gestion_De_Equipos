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
                    <label for="cod_empleados">Código de Empleado:</label>
                    <select id="cod_empleados" name="cod_empleados" class="form-control @error('cod_empleados') is-invalid @enderror">
                        <option value="">Seleccione un código de empleado</option>
                        @foreach($empleados as $empleado)
                            <option value="{{ $empleado->cod_empleado }}" {{ old('cod_empleados') == $empleado->cod_empleado ? 'selected' : '' }}>
                                {{ $empleado->cod_empleado }} 
                            </option>
                        @endforeach
                    </select>
                    @error('cod_empleados')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sucursal">Sucursal:</label>
                    <input type="text" id="sucursal" name="sucursal" class="form-control @error('sucursal') is-invalid @enderror" value="{{ old('sucursal') }}" placeholder="Ingrese la sucursal">
                    @error('sucursal')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="detalle_asignacion">Detalle de Asignación:</label>
                    <input type="text" id="detalle_asignacion" name="detalle_asignacion" class="form-control @error('detalle_asignacion') is-invalid @enderror" value="{{ old('detalle_asignacion') }}" placeholder="Ingrese el detalle de la asignación">
                    @error('detalle_asignacion')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha_asignacion">Fecha de Asignación:</label>
                    <input type="date" id="fecha_asignacion" name="fecha_asignacion" class="form-control @error('fecha_asignacion') is-invalid @enderror" value="{{ old('fecha_asignacion', now()->format('Y-m-d')) }}">
                    @error('fecha_asignacion')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha_devolucion">Fecha de Devolución:</label>
                    <input type="date" id="fecha_devolucion" name="fecha_devolucion" class="form-control @error('fecha_devolucion') is-invalid @enderror" value="{{ old('fecha_devolucion') }}">
                    @error('fecha_devolucion')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Crear Asignación</button>
                    <a href="{{ route('asignaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2/css/select2.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#cod_empleados').select2({
                theme: 'bootstrap4',
                placeholder: 'Seleccione un código de empleado'
            });

            // Validar que la fecha de devolución no sea antes de la fecha de asignación
            $('#fecha_asignacion, #fecha_devolucion').on('change', function() {
                const fechaAsignacion = new Date($('#fecha_asignacion').val());
                const fechaDevolucion = new Date($('#fecha_devolucion').val());

                if (fechaDevolucion < fechaAsignacion) {
                    alert('La fecha de devolución no puede ser anterior a la fecha de asignación.');
                    $('#fecha_devolucion').val('');
                }
            });
        });
    </script>
@stop
