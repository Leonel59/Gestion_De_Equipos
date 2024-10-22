@extends('adminlte::page')

@section('title', 'Crear Objeto')

@section('content_header')
<h1 class="text-center">Objetos</h1>
<hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
    <form action="{{ route('objetos.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group has-primary">
                    <label for="objeto">Nombre del Objeto:</label>
                    <input
                        type="text"
                        id="objeto"
                        class="form-control border-secondary"
                        placeholder="Ingrese el nombre del objeto"
                        name="objeto"
                        value="{{ old('objeto') }}"
                        autofocus
                    >
                    <span id="objetoError" class="text-danger" style="display: none;">El objeto no puede contener caracteres especiales ni números.</span>
                </div>
                @if ($errors->has('objeto'))
                    <div id="objeto-error" class="error text-danger pl-3" style="display: block;">
                        <strong>{{ $errors->first('objeto') }}</strong>
                    </div>
                @endif
            </div>

            <div class="col-sm-6 col-xs-12">
                <div class="form-group has-primary">
                    <label for="valor">Descripcion:</label>
                    <input
                        type="text"
                        id="descripcion"
                        class="form-control border-secondary"
                        placeholder="Ingrese la descripcion"
                        name="descripcion"
                        value="{{ old('descripcion') }}"
                        autofocus
                    >
                    <span id="descripcionError" class="text-danger" style="display: none;">La descripción solo puede contener letras y espacios.</span>
                </div>
                @if ($errors->has('descripcion'))
                    <div id="descripcion-error" class="error text-danger pl-3" style="display: block;">
                        <strong>{{ $errors->first('descripcion') }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-xs-12 mb-2">
                <a href="{{ route('objetos.index') }}" class="btn btn-danger w-100">
                    cancelar <i class="fa fa-times-circle ml-2"></i>
                </a>
            </div>
            <div class="col-sm-6 col-xs-12 mb-2">
                <button type="submit" class="btn btn-success w-100">
                    Guardar <i class="fa fa-check-circle ml-2"></i>
                </button>
            </div>
        </div>
    </form>
@stop

@section('css')
@stop

@section('js')
<script>
    let objetoAttempts = 0;
    let descripcionAttempts = 0;
    const maxAttempts = 3;
    const blockDuration = 5000; // Tiempo de bloqueo en milisegundos (5 segundos)

    function blockInput(inputId) {
        document.getElementById(inputId).disabled = true;
        setTimeout(() => {
            document.getElementById(inputId).disabled = false;
        }, blockDuration);
    }

    document.getElementById('objeto').addEventListener('input', function() {
        const regex = /^[A-Z][a-zA-Z]*$/;
        const objetoInput = this.value;

        if (!regex.test(objetoInput)) {
            document.getElementById('objetoError').style.display = 'block';
            objetoAttempts++;
            if (objetoAttempts >= maxAttempts) {
                blockInput('objeto');
                document.getElementById('objetoError').innerText = 'Campo bloqueado temporalmente por intentos fallidos.';
                setTimeout(() => {
                    document.getElementById('objetoError').innerText = 'El objeto no puede contener caracteres especiales ni números.';
                }, blockDuration);
                objetoAttempts = 0; // Reiniciar el contador después del bloqueo
            }
        } else {
            document.getElementById('objetoError').style.display = 'none';
            objetoAttempts = 0; // Reiniciar el contador si el valor es válido
        }
    });

    document.getElementById('descripcion').addEventListener('input', function() {
        const regex = /^[a-zA-Z\s]*$/;
        const descripcionInput = this.value;

        if (!regex.test(descripcionInput)) {
            document.getElementById('descripcionError').style.display = 'block';
            descripcionAttempts++;
            if (descripcionAttempts >= maxAttempts) {
                blockInput('descripcion');
                document.getElementById('descripcionError').innerText = 'Campo bloqueado temporalmente por intentos fallidos.';
                setTimeout(() => {
                    document.getElementById('descripcionError').innerText = 'La descripción solo puede contener letras y espacios.';
                }, blockDuration);
                descripcionAttempts = 0; // Reiniciar el contador después del bloqueo
            }
        } else {
            document.getElementById('descripcionError').style.display = 'none';
            descripcionAttempts = 0; // Reiniciar el contador si el valor es válido
        }
    });
</script>
@stop

