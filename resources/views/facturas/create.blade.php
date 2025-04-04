@extends('adminlte::page')

@section('title', 'Crear Factura')

@section('content_header')
<h1 class="text-center text-primary font-weight-bold">Crear Nueva Factura de Proveedor</h1>

@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- Actualiza el formulario para permitir la carga de archivos -->
<form id="miFormulario" action="{{ route('facturas.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-gradient-primary text-white rounded-top">
            <h3 class=" text-center card-title">Datos de la Factura</h3>
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
                <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control rounded-pill" required maxlength="30">
            </div>

            <div class="form-group">
                <label for="rtn_cliente">RTN del Cliente</label>
                <input type="text" name="rtn_cliente" id="rtn_cliente" class="form-control rounded-pill" required maxlength="14">
            </div>

            <div class="form-group">
                <label for="fecha_adquisicion">Fecha de Facturacion</label>
                <input type="date" class="form-control" id="fecha_facturacion" name="fecha_facturacion" required>
                <span id="mensaje_fecha" class="text-danger" style="display: none;"></span>
            </div>

            <!-- Nuevo campo para cargar la imagen de la factura -->
            <div class="form-group">
                <label for="imagen">Subir Imagen de la Factura</label>
                <input type="file" name="imagen" id="imagen" class="form-control rounded-pill" required>
            </div>


            <button type="submit" id="btnGuardar" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Cancelar
            </a>

        </div>
    </div>
</form>
@stop
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@section('js')
<script>
    $(document).ready(function() {

        // Validaciones por tipo de campo
        function validateInput(selector, regex) {
            $(selector).on('input', function() {
                this.value = this.value.replace(regex, '');
            });
        }

        // Aplicación de validaciones específicas
        validateInput('#nombre_cliente', /[^a-zA-Z\s]/g); // Solo letras 
        validateInput('#rtn_cliente', /[^0-9]/g); // Solo números 

        // Validación para fecha de facturación
        $('#fecha_facturacion').on('change', function() {
            const fechaSeleccionada = new Date(this.value);
            const fechaActual = new Date();
            fechaActual.setHours(0, 0, 0, 0); // Ignorar la hora para una mejor comparación
            const mensajeFecha = $('#mensaje_fecha');

            if (fechaSeleccionada > fechaActual) {
                mensajeFecha.text('La fecha de facturación no puede ser mayor a la actual.');
                mensajeFecha.show();
                this.value = '';
            } else {
                mensajeFecha.hide();
            }
        });

        // Validación en tiempo real para campos requeridos
        $('#nombre_cliente, #rtn_cliente, #fecha_facturacion, #id_proveedor, #tipo_factura').on('change input', function() {
            // Verificar si el campo está vacío
            if ($(this).val().trim() === "") {
                $(this).addClass('is-invalid'); // Añadir clase de error
            } else {
                $(this).removeClass('is-invalid'); // Quitar clase de error
            }
        });

        // Validación cuando se intenta enviar el formulario
        $('#btnGuardar').on("click", function(event) {
            event.preventDefault(); // Evita que el formulario se envíe sin validaciones

            // Verificar si hay campos vacíos
            let camposVacios = 0;
            $('#nombre_cliente, #rtn_cliente, #fecha_facturacion, #id_proveedor, #tipo_factura').each(function() {
                if ($(this).val().trim() === "") {
                    $(this).addClass('is-invalid'); // Añadir clase de error
                    camposVacios++;
                }
            });

            // Validar que se haya subido una imagen
            const imagenInput = document.getElementById("imagen");
            if (imagenInput.files.length === 0) {
                camposVacios++;
                $('#imagen').addClass('is-invalid'); // Marcar imagen como no cargada
            }

            // Si hay campos vacíos, no enviar el formulario
            if (camposVacios > 0) {
                Swal.fire({
                    icon: "error",
                    title: "Atención",
                    text: "Por favor complete todos los campos.",
                    confirmButtonText: "Aceptar"
                });
                return; // Detener el envío
            }

            // Si todos los campos son válidos, enviar el formulario
            Swal.fire({
                icon: "question",
                title: "¿Guardar?",
                text: "¿Estás seguro de que deseas guardar este registro?",
                showCancelButton: true,
                confirmButtonText: "Sí, guardar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("miFormulario").submit(); // Enviar formulario si confirma
                }
            });
        });

    });
</script>
@stop