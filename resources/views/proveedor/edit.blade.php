@extends('adminlte::page')

@section('title', 'Editar Proveedor')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Editar Proveedor</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible text-dark rounded-3 shadow" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </span>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-gradient-primary text-white rounded-top">
            <h3 class="card-title">Actualizar Información del Proveedor</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('proveedores.update', $proveedor->id_proveedor) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre_proveedor">Nombre del Proveedor</label>
                    <input type="text" name="nombre_proveedor" id="nombre_proveedor" class="form-control rounded-pill @error('nombre_proveedor') is-invalid @enderror" value="{{ old('nombre_proveedor', $proveedor->nombre_proveedor) }}" required>
                    @error('nombre_proveedor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rtn_proveedor">RTN</label>
                    <input type="text" name="rtn_proveedor" id="rtn_proveedor" class="form-control rounded-pill @error('rtn_proveedor') is-invalid @enderror" value="{{ old('rtn_proveedor', $proveedor->rtn_proveedor) }}" required>
                    @error('rtn_proveedor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contacto_proveedor">Contacto</label>
                    <input type="text" name="contacto_proveedor" id="contacto_proveedor" class="form-control rounded-pill @error('contacto_proveedor') is-invalid @enderror" value="{{ old('contacto_proveedor', $proveedor->contacto_proveedor) }}">
                    @error('contacto_proveedor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="direccion_proveedor">Dirección</label>
                    <input type="text" name="direccion_proveedor" id="direccion_proveedor" class="form-control rounded-pill @error('direccion_proveedor') is-invalid @enderror" value="{{ old('direccion_proveedor', $proveedor->direccion_proveedor) }}">
                    @error('direccion_proveedor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telefono_proveedor">Teléfono</label>
                    <input type="text" name="telefono_proveedor" id="telefono_proveedor" class="form-control rounded-pill @error('telefono_proveedor') is-invalid @enderror" value="{{ old('telefono_proveedor', $proveedor->telefono_proveedor) }}">
                    @error('telefono_proveedor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email_proveedor">Email</label>
                    <input type="email" name="email_proveedor" id="email_proveedor" class="form-control rounded-pill @error('email_proveedor') is-invalid @enderror" value="{{ old('email_proveedor', $proveedor->email_proveedor) }}">
                    @error('email_proveedor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill shadow-lg p-3 mr-3">
                        Actualizar Proveedor
                    </button>
                    <a href="{{ route('proveedores.index') }}" class="btn btn-secondary btn-sm rounded-pill shadow-lg p-3">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <style>
        .btn-primary {
            background: linear-gradient(145deg, #4b8fcc, #3a6e9a);
            box-shadow: 2px 2px 6px #aaa, -2px -2px 6px #fff;
        }

        .btn-secondary {
            background: linear-gradient(145deg, #888, #555);
            box-shadow: 2px 2px 6px #aaa, -2px -2px 6px #fff;
        }

        .form-control {
            border-radius: 20px;
        }
    </style>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const restrictedFields = [
                'nombre_proveedor',
                'rtn_proveedor',
                'contacto_proveedor',
                'telefono_proveedor',
                'direccion_proveedor'
            ];

            restrictedFields.forEach(field => {
                const inputField = document.getElementById(field);

                inputField.addEventListener('input', function (event) {
                    this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, '');
                });
            });
        });
    </script>
@stop
