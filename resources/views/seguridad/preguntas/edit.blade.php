@extends('adminlte::page')

@section('title', 'Editar Pregunta')

@section('content_header')
<h1 class="text-center">Editar Pregunta</h1>
<hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
    <form action="{{ route('preguntas.update', $pregunta->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12">
                <div class="form-group has-primary">
                    <label for="pregunta">Pregunta:</label>
                    <input
                        type="text"
                        id="pregunta"
                        class="form-control border-secondary"
                        placeholder="Ingrese la pregunta..."
                        name="pregunta"
                        value="{{ old('pregunta', $pregunta->pregunta) }}"
                        autofocus
                    >
                </div>
                @if ($errors->has('pregunta'))
                    <div id="pregunta-error" class="error text-danger pl-3" style="display: block;">
                        <strong>{{ $errors->first('pregunta') }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-xs-12 mb-2">
                <a href="{{ route('preguntas.index') }}" class="btn btn-danger w-100">
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
@stop
