@extends('adminlte::page')

@section('title', 'Editar Pregunta')

@section('content_header')
<h1 class="text-center">Editar Pregunta de Seguridad</h1>
<hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
    <div class="container">
        <form action="{{ route('preguntas.update', $pregunta->id) }}" method="POST" id="pregunta-form">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles de la Pregunta</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="pregunta">Pregunta:</label>
                        <input
                            type="text"
                            id="pregunta"
                            class="form-control border-primary"
                            placeholder="Ingrese la pregunta..."
                            name="pregunta"
                            value="{{ old('pregunta', $pregunta->pregunta) }}"
                            required
                            autofocus
                        >
                        <span id="preguntaError" class="text-danger" style="display: none;">
                            La pregunta solo puede contener letras, números y los símbolos ¿?.
                        </span>
                        @if ($errors->has('pregunta'))
                            <div class="text-danger">
                                <strong>{{ $errors->first('pregunta') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('preguntas.index') }}" class="btn btn-danger">
                        Cancelar <i class="fa fa-times-circle ml-2"></i>
                    </a>
                    <button type="submit" class="btn btn-success">
                        Guardar <i class="fa fa-check-circle ml-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
<script>
    let preguntaAttempts = 0;
    const maxAttempts = 3;
    const blockDuration = 5000; // Tiempo de bloqueo en milisegundos (5 segundos)

    function blockInput(inputId) {
        document.getElementById(inputId).disabled = true;
        setTimeout(() => {
            document.getElementById(inputId).disabled = false;
        }, blockDuration);
    }

    document.getElementById('pregunta').addEventListener('input', function() {
        const regex = /^[A-Za-z0-9¿? ]*$/; // Permitir letras, números y los símbolos ¿?
        const preguntaInput = this.value;

        if (!regex.test(preguntaInput)) {
            document.getElementById('preguntaError').style.display = 'block';
            preguntaAttempts++;
            if (preguntaAttempts >= maxAttempts) {
                blockInput('pregunta');
                document.getElementById('preguntaError').innerText = 'Campo bloqueado temporalmente por intentos fallidos.';
                setTimeout(() => {
                    document.getElementById('preguntaError').innerText = 'La pregunta solo puede contener letras, números y los símbolos ¿?.';
                }, blockDuration);
                preguntaAttempts = 0; // Reiniciar el contador después del bloqueo
            }
        } else {
            document.getElementById('preguntaError').style.display = 'none';
            preguntaAttempts = 0; // Reiniciar el contador si el valor es válido
        }
    });
</script>
@stop
