@extends('adminlte::page')

@section('title', 'Facturas')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Lista de Facturas de Proveedores</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

@can('factura.ver')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible mt-2 text-dark rounded-3" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </span>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    @can('factura.insertar')
        <div class="mb-3 d-flex justify-content-center">
            <a href="{{ route('facturas.create') }}" class="btn btn-success text-center btn-sm rounded-pill shadow-lg p-3 transform-hover">
                <span class="font-weight-bold text-white">Agregar Factura</span>
                <i class="fas fa-plus-square ml-2"></i>
            </a>
        </div>
    @endcan

    <div class="card shadow-lg rounded-4">
        <div class="card-header d-flex justify-content-start align-items-center bg-gradient-primary text-white rounded-top">
            <h3 class="card-title mr-auto">Lista de Facturas</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive-sm mt-5">
                <table id="facturasTable" class="table table-striped table-bordered table-condensed table-hover rounded-4 shadow-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Código</th>
                            <th>Proveedor</th>
                            <th>Tipo de Factura</th>
                            <th>Cliente</th>
                            <th>RTN Cliente</th>
                            <th>Fecha de Facturación</th>
                            <th>Imagen</th> <!-- Nueva columna de Imagen -->
                            @canany(['factura.editar', 'factura.eliminar'])
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
                                <td>
                                    @if($factura->imagen)
                                        <a href="{{ asset('storage/' . $factura->imagen) }}" download class="btn btn-primary btn-sm rounded-pill">
                                            Descargar Imagen
                                        </a>
                                    @else
                                        No disponible
                                    @endif
                                </td>
                                @canany(['factura.editar', 'factura.eliminar'])
                                    <td class="text-center">
                                        @can('factura.eliminar')
                                            <form action="{{ route('facturas.destroy', $factura->cod_factura) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm rounded-pill" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta factura?')">
                                                    <i class="fas fa-trash"></i>
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
    </div>

    @else
   <!-- Mensaje de permiso denegado -->
   <div class="card border-light shadow-sm mt-3 text-center">
        <div class="card-body">
            <i class="fas fa-lock text-danger mb-2" style="font-size: 2rem;"></i>
            <p class="mb-0" style="font-size: 1.1rem; color: #9e9e9e;">No tienes permiso para ver esta información.</p>
        </div>
    </div>
@endcan

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .transform-hover {
            transition: transform 0.3s ease;
        }

        .transform-hover:hover {
            transform: scale(1.05);
        }

        .btn-success {
            background: linear-gradient(145deg, #6f9e4f, #5e7e3e);
            box-shadow: 2px 2px 6px #aaa, -2px -2px 6px #fff;
        }
    </style>
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
