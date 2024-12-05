@extends('adminlte::page')

@section('title', 'Crear Factura')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Crear Nueva Factura de Proveedor</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible mt-2 text-dark rounded-3" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </span>
            <strong>{{ $errors->first() }}</strong>
        </div>
    @endif

    <!-- Actualiza el formulario para permitir la carga de archivos -->
    <form action="{{ route('facturas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card shadow-lg rounded-4">
            <div class="card-header bg-gradient-primary text-white rounded-top">
                <h3 class="card-title">Datos de la Factura</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="id_proveedor">Proveedor</label>
                    <select name="id_proveedor" id="id_proveedor" class="form-control rounded-pill" required>
                        <option value="">Seleccione un proveedor</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->id_proveedor }}">{{ $proveedor->nombre_proveedor }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
    <label for="tipo_factura">Tipo de Factura</label>
    <select name="tipo_factura" id="tipo_factura" class="form-control rounded-pill" required>
        <option value="">Seleccione un tipo de factura</option>
        <option value="Por Mantenimiento">Por Mantenimiento</option>
        <option value="Por Compra de equipo">Por Compra de equipo</option>
        <option value="Por Suministro">Por Suministro</option>
    </select>
</div>

                <div class="form-group">
                    <label for="nombre_cliente">Nombre del Cliente</label>
                    <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control rounded-pill" required>
                </div>

                <div class="form-group">
                    <label for="rtn_cliente">RTN del Cliente</label>
                    <input type="text" name="rtn_cliente" id="rtn_cliente" class="form-control rounded-pill" required>
                </div>

                <div class="form-group">
                    <label for="fecha_facturacion">Fecha de Facturación</label>
                    <input type="date" name="fecha_facturacion" id="fecha_facturacion" class="form-control rounded-pill" required>
                </div>

                <!-- Nuevo campo para cargar la imagen de la factura -->
                <div class="form-group">
                    <label for="imagen">Subir Imagen de la Factura</label>
                    <input type="file" name="imagen" id="imagen" class="form-control rounded-pill">
                </div>

                <div class="form-group d-flex justify-content-center">
                    <button type="submit" class="btn btn-success btn-sm rounded-pill shadow-lg p-3 mr-3">
                        Guardar Factura
                    </button>
                    <a href="{{ route('facturas.index') }}" class="btn btn-secondary btn-sm rounded-pill shadow-lg p-3">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    <style>
        .btn-success {
            background: linear-gradient(145deg, #6f9e4f, #5e7e3e);
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
            // Restricción de caracteres especiales en los campos específicos
            const restrictedFields = ['tipo_factura', 'nombre_cliente', 'rtn_cliente'];

            restrictedFields.forEach(field => {
                const inputField = document.getElementById(field);

                inputField.addEventListener('input', function (event) {
                    // Permitir solo letras, números y espacios
                    this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, '');
                });
            });
        });
    </script>
@stop
