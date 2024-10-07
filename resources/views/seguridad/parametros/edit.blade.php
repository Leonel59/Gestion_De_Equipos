@extends('adminlte::page')

@section('title', 'Crear Parametro')

@section('content_header')
<h1 class="text-center">Parametro</h1>
<hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
    <form action="{{route('parametros.update',$parametro->id)}}" method="POST">
@csrf

@method('PUT')

<div class="row">
<div class="col-sm-6 col-xs-12">
<div class="form-group has-primary">
    <label for="parametro">Parametro:</label>
    <input
    type="text"
    id="parametro"
    class="form-control border-secondary"
    placeholder="Ingrese el nombre del parametro"
    name="parametro"
    value="{{$parametro->parametro}}"
    autofocus
    >

</div>
@if ($errors->has('parametro'))

<div
id="parametro-error"
class="error text-danger pl-3"
for="parametro"
style="display: block;"
>
<strong>{{$errors->first('parametro')}}</strong>
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
    value="{{$parametro->valor}}"
    autofocus
    >

</div>
@if ($errors->has('valor'))

<div
id="valor-error"
class="error text-danger pl-3"
for="valor"
style="display: block;"
>
<strong>{{$errors->first('valor')}}</strong>
</div>
@endif

</div>

</div>

<div class="row">
<div class="col-sm-6 col-xs-12 mb-2">
    <a href="{{route('parametros.index')}}"
    class="btn btn-danger w-100"
    >cancelar <i class="fa fa-times-circle ml-2"></i> </a>
</div>
<div class="col-sm-6 col-xs-12 mb-2">
   <button
   type="submit"
   class="btn btn-success w-100"
   >
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