@extends('adminlte::page')

@section('title', 'Agregar Proveedor')

@section('content_header')
    <h1>Agregar Proveedor</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('proveedores.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="nombre_proveedor">Nombre del Proveedor</label>
                    <input type="text" name="nombre_proveedor" id="nombre_proveedor" class="form-control @error('nombre_proveedor') is-invalid @enderror" value="{{ old('nombre_proveedor') }}" required>
                    @error('nombre_proveedor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rtn_proveedor">RTN</label>
                    <input type="text" name="rtn_proveedor" id="rtn_proveedor" class="form-control @error('rtn_proveedor') is-invalid @enderror" value="{{ old('rtn_proveedor') }}" required>
                    @error('rtn_proveedor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contacto_proveedor">Contacto</label>
                    <input type="text" name="contacto_proveedor" id="contacto_proveedor" class="form-control @error('contacto_proveedor') is-invalid @enderror" value="{{ old('contacto_proveedor') }}">
                    @error('contacto_proveedor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="direccion_proveedor">Dirección</label>
                    <input type="text" name="direccion_proveedor" id="direccion_proveedor" class="form-control @error('direccion_proveedor') is-invalid @enderror" value="{{ old('direccion_proveedor') }}">
                    @error('direccion_proveedor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telefono_proveedor">Teléfono</label>
                    <input type="text" name="telefono_proveedor" id="telefono_proveedor" class="form-control @error('telefono_proveedor') is-invalid @enderror" value="{{ old('telefono_proveedor') }}">
                    @error('telefono_proveedor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email_proveedor">Email</label>
                    <input type="email" name="email_proveedor" id="email_proveedor" class="form-control @error('email_proveedor') is-invalid @enderror" value="{{ old('email_proveedor') }}">
                    @error('email_proveedor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Guardar Proveedor</button>
                <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop
