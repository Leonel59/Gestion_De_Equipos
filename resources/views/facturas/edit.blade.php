@extends('adminlte::page')

@section('title', 'Editar Factura')

@section('content_header')
    <h1>Editar Factura</h1>
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

    <form action="{{ route('facturas.update', $factura->cod_factura) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="id_proveedor">Proveedor</label>
            <select name="id_proveedor" id="id_proveedor" class="form-control" required>
                <option value="">Seleccione un proveedor</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id_proveedor }}" {{ $factura->id_proveedor == $proveedor->id_proveedor ? 'selected' : '' }}>
                        {{ $proveedor->nombre_proveedor }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tipo_factura">Tipo de Factura</label>
            <input type="text" name="tipo_factura" id="tipo_factura" class="form-control" required value="{{ old('tipo_factura', $factura->tipo_factura) }}">
        </div>

        <div class="form-group">
            <label for="nombre_cliente">Nombre del Cliente</label>
            <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" required value="{{ old('nombre_cliente', $factura->nombre_cliente) }}">
        </div>

        <div class="form-group">
            <label for="rtn_cliente">RTN del Cliente</label>
            <input type="text" name="rtn_cliente" id="rtn_cliente" class="form-control" required value="{{ old('rtn_cliente', $factura->rtn_cliente) }}">
        </div>

        <div class="form-group">
            <label for="fecha_facturacion">Fecha de Facturación</label>
            <input type="date" name="fecha_facturacion" id="fecha_facturacion" class="form-control" required value="{{ old('fecha_facturacion', $factura->fecha_facturacion) }}">
        </div>

        <div class="form-group">
            <label for="direccion_empresa">Dirección de la Empresa (opcional)</label>
            <input type="text" name="direccion_empresa" id="direccion_empresa" class="form-control" value="{{ old('direccion_empresa', $factura->direccion_empresa) }}">
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" required min="1" value="{{ old('cantidad', $factura->cantidad) }}">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" required>{{ old('descripcion', $factura->descripcion) }}</textarea>
        </div>

        <div class="form-group">
            <label for="garantia">Garantía (opcional)</label>
            <input type="text" name="garantia" id="garantia" class="form-control" value="{{ old('garantia', $factura->garantia) }}">
        </div>

        <div class="form-group">
            <label for="precio_unitario">Precio Unitario</label>
            <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" required min="0" step="0.01" value="{{ old('precio_unitario', $factura->precio_unitario) }}">
        </div>

        <div class="form-group">
            <label for="impuesto">Impuesto</label>
            <input type="number" name="impuesto" id="impuesto" class="form-control" required min="0" step="0.01" value="{{ old('impuesto', $factura->impuesto) }}">
        </div>

        <div class="form-group">
            <label for="total">Total</label>
            <input type="number" name="total" id="total" class="form-control" required min="0" step="0.01" value="{{ old('total', $factura->total) }}">
        </div>

        <button type="submit" class="btn btn-success">Actualizar Factura</button>
        <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@stop
