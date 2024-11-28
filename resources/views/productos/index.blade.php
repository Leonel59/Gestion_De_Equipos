@extends('adminlte::page')

@section('title', 'Productos de Mantenimiento')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Productos de Mantenimiento</h1>
@stop

@section('content')
@can('mantenimiento.ver')
    <div class="card shadow-lg rounded-3">
        <div class="card-header d-flex justify-content-start align-items-center bg-gradient-primary text-white rounded-top">
            <h3 class="card-title mr-auto">Lista de Productos</h3>
            @can('mantenimiento.insertar')
                <a href="{{ route('productos.create') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-plus"></i> Agregar Producto
                </a>
            @endcan
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>¡Éxito!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table class="table table-striped table-hover rounded shadow-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Servicio de Mantenimiento</th>
                        <th>Equipo</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Costo</th>
                        <th>Fecha de Adquisición</th>

                        @canany(['mantenimiento.editar', 'mantenimiento.eliminar'])
                            <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr class="text-center">
                            <td>
                                @if ($producto->servicioMantenimiento)
                                    {{ $producto->servicioMantenimiento->tipo_mantenimiento }}
                                @else
                                    <span class="text-muted">No asignado</span>
                                @endif
                            </td>
                            <td>
                                @if ($producto->servicioMantenimiento && $producto->servicioMantenimiento->id_equipo_mant)
                                    {{ $producto->servicioMantenimiento->id_equipo_mant }}
                                @else
                                    <span class="text-muted">No asignado</span>
                                @endif
                            </td>
                            <td>{{ $producto->nombre_producto }}</td>
                            <td>{{ $producto->descripcion_producto }}</td>
                            <td>{{ $producto->cantidad_producto }}</td>
                            <td>${{ number_format($producto->costo_producto, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($producto->fecha_adquisicion_producto)->format('d/m/Y') }}</td>

                            @canany(['mantenimiento.editar', 'mantenimiento.eliminar'])
                                <td>
                                    @can('mantenimiento.editar')
                                        <a href="{{ route('productos.edit', $producto->id_producto) }}" class="btn btn-warning btn-sm rounded-pill">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                    @endcan
                                    @can('mantenimiento.eliminar')
                                        <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            @endcanany
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @else
   <!-- Mensaje de permiso denegado -->
   <div class="card border-light shadow-sm mt-3 text-center">
        <div class="card-body">
            <i class="fas fa-lock text-danger mb-2" style="font-size: 2rem;"></i>
            <p class="mb-0" style="font-size: 1.1rem; color: #9e9e9e;">No tienes permiso para ver esta información.</p>
        </div>
    </div>
@endcan

@stop

@push('css')
    <style>
        .card {
            border-radius: 15px;
        }
        .table th, .table td {
            padding: 10px;
        }
        .btn-lg {
            border-radius: 30px;
            font-size: 1.1rem;
        }
        .btn-sm {
            border-radius: 20px;
        }
        .alert {
            border-radius: 10px;
        }
    </style>
@endpush
