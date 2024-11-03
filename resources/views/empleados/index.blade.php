@extends('adminlte::page')

@section('title', 'Empleados')

@section('content_header')
    <h1>Lista de Empleados</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Empleados Registrados</h3>
                    @can('insertar') <!-- Verifica si el usuario puede insertar -->
                        <button class="btn btn-success" id="btnAgregarEmpleado">Agregar Empleado</button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <table id="tablaEmpleados" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Cargo</th>
                            @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                                <th>Acciones</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empleados as $empleado)
                        <tr>
                            <td>{{ $empleado->cod_empleado }}</td>
                            <td>{{ $empleado->nombre_empleado }}</td>
                            <td>{{ $empleado->apellido_empleado }}</td>
                            <td>{{ $empleado->correo }}</td>
                            <td>{{ $empleado->cargo_empleado }}</td>
                            @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                                <td>
                                    @can('editar') <!-- Verifica si el usuario puede editar -->
                                        <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                    @endcan
                                    @can('eliminar') <!-- Verifica si el usuario puede eliminar -->
                                        <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este empleado?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
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
</div>

<!-- Modal para agregar empleado -->
<div class="modal fade" id="modalAgregarEmpleado" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalLabel">Agregar Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('empleados.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="cod_empleado">Código Empleado</label>
                        <input type="text" class="form-control" id="cod_empleado" name="cod_empleado" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" pattern="\d*" title="Solo se permiten números">
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion">
                    </div>
                    <div class="form-group">
                        <label for="sucursal">Sucursal</label>
                        <input type="text" class="form-control" id="sucursal" name="sucursal">
                    </div>
                    <div class="form-group">
                        <label for="area">Área</label>
                        <input type="text" class="form-control" id="area" name="area">
                    </div>
                    <div class="form-group">
                        <label for="dni_empleado">DNI Empleado</label>
                        <input type="text" class="form-control" id="dni_empleado" name="dni_empleado" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre_empleado">Nombre</label>
                        <input type="text" class="form-control" id="nombre_empleado" name="nombre_empleado" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido_empleado">Apellido</label>
                        <input type="text" class="form-control" id="apellido_empleado" name="apellido_empleado" required>
                    </div>
                    <div class="form-group">
                        <label for="cargo_empleado">Cargo</label>
                        <input type="text" class="form-control" id="cargo_empleado" name="cargo_empleado" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_contratacion">Fecha de Contratación</label>
                        <input type="date" class="form-control" id="fecha_contratacion" name="fecha_contratacion" required>
                    </div>
                    <div class="form-group">
                        <label for="sexo_empleado">Sexo</label>
                        <select class="form-control" id="sexo_empleado" name="sexo_empleado" required>
                            <option value="">Seleccione</option>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Empleado</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tablaEmpleados').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: ':not(:last-child)' // No incluir la columna de acciones
                    }
                }, 
                {
                    extend: 'print',
                    text: 'Imprimir',
                    className: 'btn btn-secondary',
                    exportOptions: {
                        columns: ':not(:last-child)' // No incluir la columna de acciones
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: ':not(:last-child)' // No incluir la columna de acciones
                    }
                }
            ]
        });

        $('#btnAgregarEmpleado').click(function(){
            $('#modalAgregarEmpleado').modal('show');
        });
    });
</script>
@endsection
