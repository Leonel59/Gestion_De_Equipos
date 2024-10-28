@extends('adminlte::page')

@section('title', 'Agregar Equipo')

@section('content_header')
    <h1>Agregar Nuevo Equipo</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Formulario de Creación de Equipos</h3>
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

                <form action="{{ route('equipos.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="cod_equipo">Código del Equipo:</label>
                        <input type="text" name="cod_equipo" id="cod_equipo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="estado_equipo">Estado del Equipo:</label>
                        <select name="estado_equipo" id="estado_equipo" class="form-control" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                            <option value="En Mantenimiento">En Mantenimiento</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tipo_equipo">Tipo de Equipo:</label>
                        <select name="tipo_equipo" id="tipo_equipo" class="form-control" required>
                            <option value="">Seleccione un Tipo de Equipo</option>
                            <option value="Computadora">Computadora</option>
                            <option value="Impresora">Impresora</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="numero_serie">Número de Serie:</label>
                        <input type="text" name="numero_serie" id="numero_serie" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="marca_equipo">Marca del Equipo:</label>
                        <input type="text" name="marca_equipo" id="marca_equipo" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="modelo_equipo">Modelo del Equipo:</label>
                        <input type="text" name="modelo_equipo" id="modelo_equipo" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="precio_equipo">Precio del Equipo:</label>
                        <input type="number" name="precio_equipo" id="precio_equipo" class="form-control" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="fecha_adquisicion">Fecha de Adquisición:</label>
                        <input type="date" name="fecha_adquisicion" id="fecha_adquisicion" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="depreciacion_equipo">Depreciación del Equipo:</label>
                        <input type="number" name="depreciacion_equipo" id="depreciacion_equipo" class="form-control" step="0.01">
                    </div>

                    <button type="submit" class="btn btn-primary">Agregar Equipo</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


