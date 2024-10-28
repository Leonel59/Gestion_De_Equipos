@extends('adminlte::page')

@section('title', 'Servicios de Mantenimiento')

@section('content_header')
    <h1 class="text-center">Servicios de Mantenimiento</h1>
@stop

@section('content')
    <div class="container-fluid">
        @if (session('info'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('info') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('servicios.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Agregar Servicio
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de Servicios</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Equipo</th>
                            <th>Tipo de Mantenimiento</th>
                            <th>Descripción</th>
                            <th>Costo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($servicios as $servicio)
                            <tr>
                                <td>{{ $servicio->id_mant }}</td>
                                <td>{{ $servicio->id_equipo_mant }}</td> <!-- Asegúrate de mostrar el nombre del equipo si es necesario -->
                                <td>{{ $servicio->tipo_mantenimiento }}</td>
                                <td>{{ $servicio->descripcion_mantenimiento }}</td>
                                <td>${{ number_format($servicio->costo_mantenimiento, 2) }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('servicios.edit', $servicio->id_mant) }}" class="btn btn-warning btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('servicios.destroy', $servicio->id_mant) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este servicio?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        body {
            background-color: #f4f6f9; /* Cambia el color de fondo si lo deseas */
        }
    </style>
@stop
