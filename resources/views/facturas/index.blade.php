@extends('adminlte::page')

@section('title', 'Facturas')

@section('content_header')
    <h1>Lista de Facturas</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @can('insertar') <!-- Verifica si el usuario puede insertar -->
        <div class="mb-3">
            <a href="{{ route('facturas.create') }}" class="btn btn-success">Agregar Factura</a>
        </div>
    @endcan

    <div class="card">
        <div class="card-body">
            <table id="facturasTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Proveedor</th>
                        <th>Tipo de Factura</th>
                        <th>Cliente</th>
                        <th>RTN Cliente</th>
                        <th>Fecha de Facturación</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                            <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach($facturas as $factura)
                        <tr>
                            <td>{{ $factura->cod_factura }}</td>
                            <td>{{ $factura->proveedor->nombre_proveedor }}</td>
                            <td>{{ $factura->tipo_factura }}</td>
                            <td>{{ $factura->nombre_cliente }}</td>
                            <td>{{ $factura->rtn_cliente }}</td>
                            <td>{{ $factura->fecha_facturacion }}</td>
                            <td>{{ $factura->cantidad }}</td>
                            <td>{{ $factura->total }}</td>
                            @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                                <td>
                                    @can('editar') <!-- Verifica si el usuario puede editar -->
                                        <a href="{{ route('facturas.edit', $factura->cod_factura) }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('eliminar') <!-- Verifica si el usuario puede eliminar -->
                                        <form action="{{ route('facturas.destroy', $factura->cod_factura) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta factura?')">
                                                <i class="fa fa-trash"></i>
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
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function () {
            $('#facturasTable').DataTable();
        });
    </script>
@stop
