@extends('adminlte::page')



@section('css')
<!-- <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet"> -->
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@stop

@section('title', 'Usuarios')
@section('content_header')
    <h1 class="text-center">Usuarios</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

<a href="{{route('usuarios.create')}}"
    class="btn btn-outline-info text-center btn-block">
<span>Crear Nuevo Usuario</span> <i class="fas fa-plus-square"></i>
</a>

<div class="table-responsive-sm mt-5">
    <table id="tablaUsuarios" class="table table-striped table-bordered table-condensed table-hover">
<thead class="thead-dark">
    <tr>
<th>#</th>
<th>Nombre</th>
<th>Usuario</th>
<th>Correo</th>
<th>Estado</th>
<th>Fecha de Creacion</th>
<th>Fecha de Actualización</th>
<th>Opciones</th>
    </tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>Leonel</td>
<td>Lmejia</td>
<td>leonel@gmail.com</td>
<td>Activo</td>
<td>2024-28-09</td>
<td>2024-28-09</td>


<td class="text-center">
    <form action="{{route('usuarios.destroy',1)}}" method="POST">
        <a href="{{route('usuarios.edit',1)}}"
        class="btn btn-warning btm-sm fa fa-edit">
        </a>
        <button type="submit"
        class="btn btn-danger btm-sm fa fa-times-circle"
        ></button>
    </form>
</td>
</tr>
</tbody>
@stop

@section('css')

@stop

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
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tablaRoles').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },
            dom: 'Blfrtip',
            // dom: '<"pt-2 row" <"col-xl mt-2"l><"col-xl text-center"B><"col-xl text-right mt-2 buscar"f>> <"row"rti<"col"><p>>',
            buttons: [
                {
                    extend: 'pdf',
                    className: 'btn btn-danger glyphicon glyphicon-duplicate',
                   
                }, 
                {
                    extend: 'print',
                    text: 'Imprimir',
                    className: 'btn btn-secondary glyphicon glyphicon-duplicate'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-success glyphicon glyphicon-duplicate'
                }
            ]
        });
    });
</script>
</script>
@stop



