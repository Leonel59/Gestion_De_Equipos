@extends('adminlte::page')

@section('title', 'Editar Equipo')

@section('content_header')
    <h1>Editar Equipo</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Formulario de Edición de Equipos</h3>
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

                <form action="{{ route('equipos.update', $equipo->cod_equipo) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="cod_equipo">Código del Equipo:</label>
                        <input type="text" name="cod_equipo" id="cod_equipo" class="form-control" value="{{ $equipo->cod_equipo }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="estado_equipo">Estado del Equipo:</label>
                        <select name="estado_equipo" id="estado_equipo" class="form-control" required>
                            <option value="Activo" {{ $equipo->estado_equipo == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ $equipo->estado_equipo == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="En Mantenimiento" {{ $equipo->estado_equipo == 'En Mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tipo_equipo">Tipo de Equipo:</label>
                        <select name="tipo_equipo" id="tipo_equipo" class="form-control" required>
                            <option value="">Seleccione un Tipo de Equipo</option>
                            <option value="Computadora" {{ $equipo->tipo_equipo == 'Computadora' ? 'selected' : '' }}>Computadora</option>
                            <option value="Impresora" {{ $equipo->tipo_equipo == 'Impresora' ? 'selected' : '' }}>Impresora</option>
                            <option value="Otro" {{ $equipo->tipo_equipo == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="numero_serie">Número de Serie:</label>
                        <input type="text" name="numero_serie" id="numero_serie" class="form-control" value="{{ $equipo->numero_serie }}">
                    </div>

                    <div class="form-group">
                        <label for="marca_equipo">Marca del Equipo:</label>
                        <input type="text" name="marca_equipo" id="marca_equipo" class="form-control" value="{{ $equipo->marca_equipo }}">
                    </div>

                    <div class="form-group">
                        <label for="modelo_equipo">Modelo del Equipo:</label>
                        <input type="text" name="modelo_equipo" id="modelo_equipo" class="form-control" value="{{ $equipo->modelo_equipo }}">
                    </div>

                    <div class="form-group">
                        <label for="precio_equipo">Precio del Equipo:</label>
                        <input type="number" name="precio_equipo" id="precio_equipo" class="form-control" value="{{ $equipo->precio_equipo }}" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="fecha_adquisicion">Fecha de Adquisición:</label>
                        <input type="date" name="fecha_adquisicion" id="fecha_adquisicion" class="form-control" value="{{ $equipo->fecha_adquisicion }}">
                    </div>

                    <div class="form-group">
                        <label for="depreciacion_equipo">Depreciación del Equipo:</label>
                        <input type="number" name="depreciacion_equipo" id="depreciacion_equipo" class="form-control" value="{{ $equipo->depreciacion_equipo }}" step="0.01">
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Equipo</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
