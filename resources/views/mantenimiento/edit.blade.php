@extends('adminlte::page')

@section('title', 'Editar Servicio de Mantenimiento')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Servicio de Mantenimiento</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('servicios.update', $servicio->id_mant) }}" method="POST">
                @csrf
                @method('PUT') <!-- Asegúrate de incluir esto para el método PUT -->

                <div class="form-group">
                    <label for="id_equipo_mant">Equipo de Mantenimiento</label>
                    <select class="form-control" id="id_equipo_mant" name="id_equipo_mant" required>
                        <option value="">Seleccione un equipo</option>
                        @foreach($equipos as $equipo)
                            <option value="{{ $equipo->cod_equipo }}" {{ $servicio->id_equipo_mant == $equipo->cod_equipo ? 'selected' : '' }}>
                                {{ $equipo->cod_equipo }} - {{ $equipo->tipo_equipo }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_equipo_mant')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tipo_mantenimiento">Tipo de Mantenimiento</label>
                    <select class="form-control" id="tipo_mantenimiento" name="tipo_mantenimiento" required>
                        <option value="">Seleccione el tipo</option>
                        <option value="Preventivo" {{ $servicio->tipo_mantenimiento == 'Preventivo' ? 'selected' : '' }}>Preventivo</option>
                        <option value="Correctivo" {{ $servicio->tipo_mantenimiento == 'Correctivo' ? 'selected' : '' }}>Correctivo</option>
                        <option value="Predictivo" {{ $servicio->tipo_mantenimiento == 'Predictivo' ? 'selected' : '' }}>Predictivo</option>
                    </select>
                    @error('tipo_mantenimiento')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="descripcion_mantenimiento">Descripción</label>
                    <textarea class="form-control" id="descripcion_mantenimiento" name="descripcion_mantenimiento" rows="3" required>{{ old('descripcion_mantenimiento', $servicio->descripcion_mantenimiento) }}</textarea>
                    @error('descripcion_mantenimiento')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cantidad_equipo_usado">Cantidad de Equipo Usado</label>
                    <input type="number" class="form-control" id="cantidad_equipo_usado" name="cantidad_equipo_usado" value="{{ old('cantidad_equipo_usado', $servicio->cantidad_equipo_usado) }}">
                    @error('cantidad_equipo_usado')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha_reparacion_equipo">Fecha de Reparación</label>
                    <input type="date" class="form-control" id="fecha_reparacion_equipo" name="fecha_reparacion_equipo" 
                        value="{{ old('fecha_reparacion_equipo', !empty($servicio->fecha_reparacion_equipo) ? \Carbon\Carbon::parse($servicio->fecha_reparacion_equipo)->format('Y-m-d') : '') }}">
                    @error('fecha_reparacion_equipo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha_entrega_equipo">Fecha de Entrega</label>
                    <input type="date" class="form-control" id="fecha_entrega_equipo" name="fecha_entrega_equipo" 
                        value="{{ old('fecha_entrega_equipo', !empty($servicio->fecha_entrega_equipo) ? \Carbon\Carbon::parse($servicio->fecha_entrega_equipo)->format('Y-m-d') : '') }}">
                    @error('fecha_entrega_equipo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="costo_mantenimiento">Costo de Mantenimiento</label>
                    <input type="number" class="form-control" id="costo_mantenimiento" name="costo_mantenimiento" step="0.01" value="{{ old('costo_mantenimiento', $servicio->costo_mantenimiento) }}">
                    @error('costo_mantenimiento')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="duracion_mantenimiento">Duración de Mantenimiento (horas)</label>
                    <input type="number" class="form-control" id="duracion_mantenimiento" name="duracion_mantenimiento" value="{{ old('duracion_mantenimiento', $servicio->duracion_mantenimiento) }}">
                    @error('duracion_mantenimiento')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha_creacion">Fecha de Creación</label>
                    <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion" 
                        value="{{ old('fecha_creacion', !empty($servicio->fecha_creacion) ? \Carbon\Carbon::parse($servicio->fecha_creacion)->format('Y-m-d') : '') }}" required>
                    @error('fecha_creacion')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="modificado_por">Modificado Por</label>
                    <input type="text" class="form-control" id="modificado_por" name="modificado_por" value="{{ old('modificado_por', $servicio->modificado_por) }}">
                    @error('modificado_por')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha_modificacion">Fecha de Modificación</label>
                    <input type="date" class="form-control" id="fecha_modificacion" name="fecha_modificacion" 
                        value="{{ old('fecha_modificacion', !empty($servicio->fecha_modificacion) ? \Carbon\Carbon::parse($servicio->fecha_modificacion)->format('Y-m-d') : '') }}">
                    @error('fecha_modificacion')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Actualizar Servicio</button>
                    <a href="{{ route('servicios.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

