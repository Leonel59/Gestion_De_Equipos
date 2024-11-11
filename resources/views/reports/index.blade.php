@extends('adminlte::page')

@section('title', 'Administrar Reportes')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Administrar Reportes</h1>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            
            <!-- Panel de creación de reporte -->
            <div class="col-md-10">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title text-primary">Generar Nuevo Reporte</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reportes.equipos') }}" method="GET">
                            <div class="form-group">
                                <label for="reporteNombre">Nombre del Reporte</label>
                                <input type="text" class="form-control" id="reporteNombre" name="reporteNombre" placeholder="Ingrese el nombre del reporte">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-lg">Generar Reporte</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista de reportes generados -->
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title text-primary">Lista de Reportes Generados</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre del Reporte</th>
                                    <th>Fecha de Creación</th>
                                    <th>Tipo de Reporte</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($equipos as $index => $equipo)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $equipo['nombre'] ?? 'Reporte de Equipos' }}</td>
                                        
                                        <td>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
                                        <td>{{ $equipo['tipo'] ?? 'General' }}</td>
                                        <td>
                                            <a href="{{ route('reportes.equipos') }}" class="btn btn-info btn-sm">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script>
        function confirmDelete(reportId) {
            $('#deleteForm').attr('action', '/reportes/' + reportId); // Ajusta la URL para eliminar el reporte
            $('#deleteModal').modal('show');
        }
    </script>
@stop