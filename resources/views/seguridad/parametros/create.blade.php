@extends('adminlte::page')

@section('title', 'Crear Parametro')

@section('content_header')
<h1 class="text-center">Parametros</h1>
<hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
    <form action="{{ route('parametros.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group has-primary">
                    <label for="parametro">Parametro:</label>
                    <input
                        type="text"
                        id="parametro"
                        class="form-control border-secondary"
                        placeholder="Ingrese el parametro"
                        name="parametro"
                        value="{{ old('parametro') }}"
                        autofocus
                        oninput="validateParametro()"
                    >
                    <small id="parametro-validation-message" class="text-danger"></small>
                </div>
                @if ($errors->has('parametro'))
                    <div id="parametro-error" class="error text-danger pl-3" style="display: block;">
                        <strong>{{ $errors->first('parametro') }}</strong>
                    </div>
                @endif
            </div>

            <div class="col-sm-6 col-xs-12">
                <div class="form-group has-primary">
                    <label for="valor">Valor:</label>
                    <input
                        type="text"
                        id="valor"
                        class="form-control border-secondary"
                        placeholder="Ingrese el valor"
                        name="valor"
                        value="{{ old('valor') }}"
                        autofocus
                        oninput="validateValor()"
                    >
                    <small id="valor-validation-message" class="text-danger"></small>
                </div>
                @if ($errors->has('valor'))
                    <div id="valor-error" class="error text-danger pl-3" style="display: block;">
                        <strong>{{ $errors->first('valor') }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-xs-12 mb-2">
                <a href="{{ route('parametros.index') }}" class="btn btn-danger w-100">
                    Cancelar <i class="fa fa-times-circle ml-2"></i>
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
    let parametroAttempts = 0;
    let valorAttempts = 0;
    const maxAttempts = 3; // Límite de intentos
    const blockTime = 3000; // Tiempo de bloqueo en milisegundos

    function validateParametro() {
        const parametroInput = document.getElementById('parametro');
        const message = document.getElementById('parametro-validation-message');
        const regex = /^[A-Z][a-zA-Z]*$/; // Solo permite letras, debe iniciar con mayúscula

        if (parametroInput.disabled) {
            message.textContent = 'Campo bloqueado por demasiados intentos fallidos. Intente más tarde.';
            return;
        }

        if (!regex.test(parametroInput.value)) {
            parametroAttempts++;
            message.textContent = 'El nombre del parámetro debe iniciar con una letra mayúscula y no puede contener caracteres especiales ni espacios.';
            if (parametroAttempts >= maxAttempts) {
                parametroInput.disabled = true;
                setTimeout(() => {
                    parametroInput.disabled = false;
                    parametroAttempts = 0; // Reiniciar intentos
                    message.textContent = '';
                }, blockTime);
            }
        } else {
            message.textContent = '';
            parametroAttempts = 0; // Reiniciar intentos si la validación es correcta
        }
    }

    function validateValor() {
        const valorInput = document.getElementById('valor');
        const message = document.getElementById('valor-validation-message');
        const regex = /^[0-9]+$/; // Solo permite números

        if (valorInput.disabled) {
            message.textContent = 'Campo bloqueado por demasiados intentos fallidos. Intente más tarde.';
            return;
        }

        if (!regex.test(valorInput.value)) {
            valorAttempts++;
            message.textContent = 'El valor solo puede ser un número y no puede contener caracteres especiales ni letras.';
            if (valorAttempts >= maxAttempts) {
                valorInput.disabled = true;
                setTimeout(() => {
                    valorInput.disabled = false;
                    valorAttempts = 0; // Reiniciar intentos
                    message.textContent = '';
                }, blockTime);
            }
        } else {
            message.textContent = '';
            valorAttempts = 0; // Reiniciar intentos si la validación es correcta
        }
    }
</script>
@stop


