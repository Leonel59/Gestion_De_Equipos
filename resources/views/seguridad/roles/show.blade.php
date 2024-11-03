@extends('adminlte::page')

@section('title', 'Detalles del Rol')

@section('css')
<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.02);
    }

    .list-group-item {
        border: none;
        border-radius: 10px;
        background-color: #f8f9fa;
        margin: 5px 0;
        transition: background-color 0.2s;
    }

    .list-group-item:hover {
        background-color: #e2e6ea;
    }

    .btn {
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: bold;
    }

    h1 {
        font-family: 'Arial', sans-serif;
        font-weight: 700;
        color: #007bff;
    }

    h3 {
        color: #333;
    }
</style>
@stop

@section('content_header')
    <h1 class="text-center">Detalles del Rol: {{ $rol->name }}</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

<div class="card">
    <div class="card-body">
        <h3 class="text-center">Información del Rol</h3>
        <ul class="list-group">
            <li class="list-group-item"><strong>ID:</strong> <span class="text-muted">{{ $rol->id }}</span></li>
            <li class="list-group-item"><strong>Nombre:</strong> <span class="text-muted">{{ $rol->name }}</span></li>
            <li class="list-group-item"><strong>Permisos:</strong>
                @if($rol->permissions->isNotEmpty())
                    <ul>
                        @foreach($rol->permissions as $permiso)
                            <li class="text-muted">{{ $permiso->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-danger">Sin permisos asignados</span>
                @endif
            </li>
        </ul>
        <a href="{{ route('roles.index') }}" class="btn btn-primary mt-3">Regresar a Roles</a>
    </div>
</div>

@stop