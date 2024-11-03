@extends('adminlte::page')

@section('title', 'Equipos')

@section('content_header')
    <h1>Lista de Equipos</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Equipos Registrados</h3>
                    @can('insertar') <!-- Verifica si el usuario puede insertar -->
                        <a href="{{ route('equipos.create') }}" class="btn btn-success">Agregar Equipo</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if(session('info'))
                    <div class="alert alert-success">{{ session('info') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <table id="tablaEquipos" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Estado</th>
                            <th>Tipo</th>
                            <th>Número de Serie</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Precio</th>
                            <th>Fecha de Adquisición</th>
                            <th>Creado Por</th>
                            <th>Ver Propiedades</th>
                            @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                                <th>Acciones</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipos as $equipo)
                        <tr>
                            <td>{{ $equipo->cod_equipo }}</td>
                            <td>{{ $equipo->estado_equipo ?? 'Desconocido' }}</td>
                            <td>{{ $equipo->tipo_equipo }}</td>
                            <td>{{ $equipo->numero_serie ?? 'N/A' }}</td>
                            <td>{{ $equipo->marca_equipo ?? 'N/A' }}</td>
                            <td>{{ $equipo->modelo_equipo ?? 'N/A' }}</td>
                            <td>{{ $equipo->precio_equipo ? '$' . number_format($equipo->precio_equipo, 2) : 'N/A' }}</td>
                            <td>
                                @if($equipo->fecha_adquisicion instanceof \Carbon\Carbon) 
                                    {{ $equipo->fecha_adquisicion->format('Y-m-d') }}
                                @else 
                                    {{ $equipo->fecha_adquisicion ?? 'N/A' }} 
                                @endif
                            </td>
                            <td>{{ $equipo->usuario->name ?? 'Desconocido' }}</td>
                            <td>
                                <a href="{{ route('equipos.show', $equipo->cod_equipo) }}" class="btn btn-info btn-sm">Ver Propiedades</a>
                            </td>
                            @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                                <td>
                                    <div class="d-flex">
                                        @can('editar') <!-- Verifica si el usuario puede editar -->
                                            <a href="{{ route('equipos.edit', $equipo->cod_equipo) }}" class="btn btn-warning btn-sm mr-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('eliminar') <!-- Verifica si el usuario puede eliminar -->
                                            <form action="{{ route('equipos.destroy', $equipo->cod_equipo) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este equipo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            @endcanany
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#tablaEquipos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            }
        });
    });
</script>
@endsection

