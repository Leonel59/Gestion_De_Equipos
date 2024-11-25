@extends('adminlte::page')

@section('title', 'Editar Suministro')

@section('content_header')
<h1>Editar Suministro</h1>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('suministros.update', $suministro->id_suministro) }}" method="POST">
            @csrf
            @method('PUT') <!-- Método PUT para la actualización -->

            <div class="form-group">
                <label for="id_proveedor">Proveedor</label>
                <select name="id_proveedor" id="id_proveedor" class="form-control @error('id_proveedor') is-invalid @enderror" required>
                    <option value="">Seleccione un proveedor</option>
                    @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id_proveedor }}" {{ old('id_proveedor', $suministro->id_proveedor) == $proveedor->id_proveedor ? 'selected' : '' }}>
                        {{ $proveedor->nombre_proveedor }}
                    </option>
                    @endforeach
                </select>
                @error('id_proveedor')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nombre_suministro">Nombre del Suministro</label>
                <input type="text" name="nombre_suministro" id="nombre_suministro" class="form-control @error('nombre_suministro') is-invalid @enderror" value="{{ old('nombre_suministro', $suministro->nombre_suministro) }}" required>
                @error('nombre_suministro')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion_suministro">Descripción</label>
                <textarea name="descripcion_suministro" id="descripcion_suministro" class="form-control @error('descripcion_suministro') is-invalid @enderror">{{ old('descripcion_suministro', $suministro->descripcion_suministro) }}</textarea>
                @error('descripcion_suministro')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="fecha_adquisicion">Fecha de Adquisición</label>
                <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" value="{{ old('fecha_adquisicion', $suministro->fecha_adquisicion) }}" required>
                <span id="mensaje_fecha" class="text-danger" style="display: none;"></span>
            </div>

            <div class="form-group">
                <label for="cantidad_suministro">Cantidad</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Und.</span>
                    </div>
                    <input type="number" name="cantidad_suministro" id="cantidad_suministro" class="form-control @error('cantidad_suministro') is-invalid @enderror" value="{{ old('cantidad_suministro', $suministro->cantidad_suministro) }}" required min="1">
                    @error('cantidad_suministro')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="costo_unitario">Costo Unitario</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">L.</span>
                    </div>
                    <input type="number" name="costo_unitario" id="costo_unitario" class="form-control @error('costo_unitario') is-invalid @enderror" value="{{ old('costo_unitario', $suministro->costo_unitario) }}" required step="0.01" min="0">
                    @error('costo_unitario')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('suministros.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop

@section('js')


<script>
    $(document).ready(function() {

        // Validaciones por tipo de campo
        function validateInput(selector, regex) {
            $(selector).on('input', function() {
                this.value = this.value.replace(regex, '');
            });
        }

        // Aplicación de validaciones específicas
        validateInput('#nombre_suministro, #descripcion_suministro', /[^a-zA-Z\s]/g); // Solo letras y espacio
        validateInput('#cantidad_suministro, #costo_unitario', /[^0-9]/g); // Solo números enteros


        // Validación para fecha de adquisición
        $('#fecha_adquisicion').on('change', function() {
            const fechaSeleccionada = new Date(this.value);
            const fechaActual = new Date();

            // Ajustar la fecha actual para que solo tenga día, mes y año (sin horas)
            fechaActual.setHours(0, 0, 0, 0);

            const mensajeFecha = $('#mensaje_fecha');

            if (fechaSeleccionada > fechaActual) {
                mensajeFecha.text('No puede ser mayor a la fecha actual.');
                mensajeFecha.show();
                this.value = '';
            } else {
                mensajeFecha.hide();
            }
        });

    });
</script>
@endsection