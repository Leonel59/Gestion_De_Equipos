@extends('adminlte::page')

@section('title', 'Editar Objeto')

@section('content_header')
<h1 class="text-center">Editar Objeto</h1>
<hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
    <form action="{{route('objetos.update',$objeto->id)}}" method="POST">
@csrf
@method('PUT')

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
    value="{{$objeto->objeto}}"
    autofocus
    >

</div>
@if ($errors->has('objeto'))

<div
id="objeto-error"
class="error text-danger pl-3"
for="objeto"
style="display: block;"
>
<strong>{{$errors->first('objeto')}}</strong>
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
    value="{{$objeto->descripcion}}"
    autofocus
    >

</div>
@if ($errors->has('descripcion'))

<div
id="descripcion-error"
class="error text-danger pl-3"
for="descripcion"
style="display: block;"
>
<strong>{{$errors->first('descripcion')}}</strong>
</div>
@endif

</div>

</div>

<div class="row">
<div class="col-sm-6 col-xs-12 mb-2">
    <a href="{{route('objetos.index')}}"
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
