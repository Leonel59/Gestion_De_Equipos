@extends('adminlte::page')

@section('title', 'Crear Factura')

@section('content_header')
    <h1>Crear Nueva Factura</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('facturas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_proveedor">Proveedor</label>
            <select name="id_proveedor" id="id_proveedor" class="form-control" required>
                <option value="">Seleccione un proveedor</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id_proveedor }}">{{ $proveedor->nombre_proveedor }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tipo_factura">Tipo de Factura</label>
            <input type="text" name="tipo_factura" id="tipo_factura" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="nombre_cliente">Nombre del Cliente</label>
            <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="rtn_cliente">RTN del Cliente</label>
            <input type="text" name="rtn_cliente" id="rtn_cliente" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="fecha_facturacion">Fecha de Facturación</label>
            <input type="date" name="fecha_facturacion" id="fecha_facturacion" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="direccion_empresa">Dirección de la Empresa (opcional)</label>
            <input type="text" name="direccion_empresa" id="direccion_empresa" class="form-control">
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" required min="1">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="garantia">Garantía (opcional)</label>
            <input type="text" name="garantia" id="garantia" class="form-control">
        </div>

        <div class="form-group">
            <label for="precio_unitario">Precio Unitario</label>
            <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" required min="0" step="0.01">
        </div>

        <div class="form-group">
            <label for="impuesto">Impuesto</label>
            <input type="number" name="impuesto" id="impuesto" class="form-control" required min="0" step="0.01">
        </div>

        <div class="form-group">
            <label for="total">Total</label>
            <input type="number" name="total" id="total" class="form-control" required min="0" step="0.01">
        </div>

        <button type="submit" class="btn btn-success">Guardar Factura</button>
        <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@stop
