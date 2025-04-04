@extends('adminlte::page')

@section('title', 'Agregar Equipo')

@section('content_header')
<h1>Agregar Equipo</h1>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <form id="miFormulario" action="{{ route('equipos.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cod_equipo">Código Equipo</label>
                        <input type="text" class="form-control" id="cod_equipo" name="cod_equipo" required>
                        <span id="codEquipoError" style="color: red; display: none;">Este código ya existe, ingrese uno diferente.</span>
                    </div>
                    <div class="form-group">
                        <label for="estado_equipo">Estado</label>
                        <select class="form-control" id="estado_equipo" name="estado_equipo" required>
                            <option value="">Seleccione</option>
                            <option value="Disponible">Disponible</option>
                            <option value="En Mantenimiento">En Mantenimiento</option>
                            <option value="Comodin">Comodin</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tipo_equipo">Tipo de Equipo</label>
                        <select class="form-control" id="tipo_equipo" name="tipo_equipo" required>
                            <option value="">Seleccione</option>
                            <option value="Computadora">Computadora</option>
                            <option value="Impresora">Impresora</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="marca_equipo">Marca Equipo</label>
                        <input type="text" class="form-control" id="marca_equipo" name="marca_equipo" required>
                    </div>
                    <div class="form-group">
                        <label for="modelo_equipo">Modelo Equipo</label>
                        <input type="text" class="form-control" id="modelo_equipo" name="modelo_equipo" required>
                    </div>
                    <div class="form-group">
                        <label for="numero_serie">Número de Serie</label>
                        <input type="text" class="form-control" id="numero_serie" name="numero_serie" required>
                    </div>


                    <div class="form-group">
                        <label for="precio_equipo">Precio Equipo</label>
                        <div class="input-group">
                            <span class="input-group-text">L.</span>
                            <input type="number" class="form-control" id="precio_equipo" name="precio_equipo" step="0.01" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fecha_adquisicion">Fecha de Adquisición</label>
                        <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" required>
                        <span id="mensaje_fecha" class="text-danger" style="display: none;"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Campos específicos para Computadora -->
                    <div id="camposComputadora" style="display: none;">
                        <h5>Propiedades de Computadora</h5>
                        <div class="form-group">
                            <label for="serie_cargador_comp">Serie Cargador</label>
                            <input type="text" class="form-control" id="serie_cargador_comp" name="serie_cargador_comp" required>
                        </div>
                        <div class="form-group">
                            <label for="procesador_comp">Procesador</label>
                            <input type="text" class="form-control" id="procesador_comp" name="procesador_comp" required>
                        </div>
                        <div class="form-group">
                            <label for="memoria_comp">Memoria</label>
                            <input type="text" class="form-control" id="memoria_comp" name="memoria_comp" required>
                        </div>
                        <div class="form-group">
                            <label for="tarjeta_grafica_comp">Tarjeta Gráfica (Opcional)</label>
                            <input type="text" name="tarjeta_grafica_comp" id="tarjeta_grafica_comp" class="form-control" value="{{ old('tarjeta_grafica_comp', $equipo->tarjeta_grafica_comp ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="tipodisco_comp">Tipo de Disco</label>
                            <input type="text" class="form-control" id="tipodisco_comp" name="tipodisco_comp" required>
                        </div>
                        <div class="form-group">
                            <label for="sistema_operativo_comp">Sistema Operativo</label>
                            <input type="text" class="form-control" id="sistema_operativo_comp" name="sistema_operativo_comp" required>
                        </div>
                    </div>

                    <!-- Campos específicos para Impresora -->
                    <div id="camposImpresora" style="display: none;" tabindex="0">
                        <h5>Propiedades de Impresora</h5>
                        <div class="form-group">
                            <label for="tipo_impresora">Tipo de Impresora</label>
                            <input type="text" class="form-control" id="tipo_impresora" name="tipo_impresora" required>
                        </div>
                        <div class="form-group">
                            <label for="resolucion_impresora">Resolución</label>
                            <input type="text" class="form-control" id="resolucion_impresora" name="resolucion_impresora" required>
                        </div>
                        <div class="form-group">
                            <label for="conectividad_impresora">Conectividad</label>
                            <input type="text" class="form-control" id="conectividad_impresora" name="conectividad_impresora" required>
                        </div>
                    </div>

                    <!-- Campos específicos para Otro Equipo -->
                    <div id="camposOtro" style="display: none;">
                        <h5>Propiedades de Otro Equipo</h5>
                        <div class="form-group">
                            <label for="capacidad">Capacidad</label>
                            <input type="text" class="form-control" id="capacidad" name="capacidad">
                        </div>
                        <div class="form-group">
                            <label for="tamano">Tamaño</label>
                            <input type="text" class="form-control" id="tamano" name="tamano">
                        </div>
                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="text" class="form-control" id="color" name="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="button" id="btnGuardar" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>

            </div>
        </form>

    </div>
</div>
</div>
</div>
@endsection

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

        // Evento para cerrar el modal cuando se haga clic en el botón "Cerrar"
        $('#btnCerrarModal').click(function() {
            $('#modalAgregarEquipo').modal('hide');
        });

        // Evento para cerrar el modal cuando se haga clic en la "X" de la parte superior
        $('.close').click(function() {
            $('#modalAgregarEquipo').modal('hide');
        });


        // Validaciones por tipo de campo
        function validateInput(selector, regex) {
            $(selector).on('input', function() {
                this.value = this.value.replace(regex, '');
            });
        }

        // Aplicación de validaciones específicas
        validateInput('#cod_equipo', /[^a-zA-Z0-9]/g); // Solo letras y números
        validateInput('#marca_equipo, #color, #tipo_impresora', /[^a-zA-Z\s]/g); // Solo letras
        validateInput('#modelo_equipo, #numero_serie', /[^a-zA-Z0-9\s]/g); // Letras, números y espacio
        validateInput('#precio_equipo', /[^0-9.]/g); // Números y punto decimal
        validateInput('#serie_cargador_comp, #tipodisco_comp', /[^a-zA-Z0-9\s]/g); // Letras y números
        validateInput('#procesador_comp', /[^a-zA-Z0-9\s]/g); // Letras y números
        validateInput('#memoria_comp, #sistema_operativo_comp', /[^a-zA-Z0-9\s]/g); // Letras, números y espacios
        validateInput('#tarjeta_grafica_comp, #resolucion_impresora', /[^a-zA-Z0-9\s]/g); // Letras y números
        validateInput('#conectividad_impresora', /[^a-zA-Z,\s]/g); // Letras, espacios y comas
        validateInput('#capacidad, #tamano', /[^a-zA-Z0-9\s]/g); // Letras y números

        // Verificación de la existencia del código en tiempo real
        $('#cod_equipo').on('input', function() {
            let codEquipo = $(this).val();
            if (codEquipo) {
                $.ajax({
                    url: '/verificar-codigo-equipo',
                    method: 'GET',
                    data: {
                        cod_equipo: codEquipo
                    },
                    success: function(response) {
                        $('#codEquipoError').toggle(response.exists);
                    }
                });
            } else {
                $('#codEquipoError').hide();
            }
        });

        // Validación para fecha de adquisición
        $('#fecha_adquisicion').on('change', function() {
            const fechaSeleccionada = new Date(this.value);
            const fechaActual = new Date();
            const mensajeFecha = $('#mensaje_fecha');

            if (fechaSeleccionada > fechaActual) {
                mensajeFecha.text('No puede ser mayor a la fecha actual.');
                mensajeFecha.show();
                this.value = '';
            } else {
                mensajeFecha.hide();
            }
        });
    });

    $('#tipo_equipo').change(function() {
        var tipoEquipo = $(this).val();
        $('#camposComputadora, #camposImpresora, #camposOtro').hide();

        // Limpiamos required de todos los campos
        $('#camposComputadora input, #camposImpresora input, #camposOtro input').prop('required', false);

        if (tipoEquipo === 'Computadora') {
            $('#camposComputadora').show();

            // Desmarcar 'required' solo para tarjeta gráfica
            $('#tarjeta_grafica_comp').prop('required', false);

            $('#camposComputadora input').not('#tarjeta_grafica_comp').prop('required', true);
        } else if (tipoEquipo === 'Impresora') {
            $('#camposImpresora').show();
            $('#camposImpresora input').prop('required', true);
        } else if (tipoEquipo === 'Otro') {
            $('#camposOtro').show();
            $('#camposOtro input').prop('required', true);
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("miFormulario");
    const btnGuardar = document.getElementById("btnGuardar");
    const codigoEquipo = document.getElementById("cod_equipo");
    const fechaAdquisicion = document.getElementById("fecha_adquisicion");
    const codEquipoError = $('#codEquipoError');
    const mensajeFecha = $('#mensaje_fecha');
    
    // Función de verificación personalizada para el código de equipo
    function verificarCodigoEquipo(codigo) {
        return $.ajax({
            url: '/verificar-codigo-equipo',
            method: 'GET',
            data: { cod_equipo: codigo }
        }).then(response => response.exists);
    }

    // Validación cuando el formulario intenta enviarse
    btnGuardar.addEventListener("click", async function() {
        let errores = [];

        // Verificación de validez del formulario usando validaciones nativas
        if (!form.checkValidity()) {
            form.reportValidity(); // ⚠ Muestra los mensajes nativos del navegador
            return;
        }

        // Verificar si el código de equipo ya existe
        const codigoEquipoValor = codigoEquipo.value.trim();
        if (codigoEquipoValor) {
            const codigoExistente = await verificarCodigoEquipo(codigoEquipoValor);
            if (codigoExistente) {
                errores.push("El código de equipo ya está registrado.");
            }
        }

        // Verificación de fecha de adquisición
        const fechaSeleccionada = new Date(fechaAdquisicion.value);
        const fechaActual = new Date();
        if (fechaSeleccionada > fechaActual) {
            errores.push("La fecha de adquisición no puede ser mayor a la fecha actual.");
        }

        // Si hay errores, se muestran
        if (errores.length > 0) {
            Swal.fire({
                icon: "error",
                title: "Error en el formulario",
                html: errores.join("<br>"),
                confirmButtonText: "Aceptar"
            });
        } else {
            // Confirmación antes de enviar el formulario
            Swal.fire({
                icon: "question",
                title: "¿Guardar equipo?",
                text: "¿Estás seguro de que deseas guardar este equipo?",
                showCancelButton: true,
                confirmButtonText: "Sí, guardar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("miFormulario").submit(); // Enviar formulario si confirma
                }
            });
        }
    });
});
</script>
@endsection

