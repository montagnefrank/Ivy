$(document).ready(function() {
//variabe que dice si estoy editando o insertando nuevo
var accion = "";
        var iva = 0;
        var totalgeneral = 0;
        var subtotal = 0;
        var descuento = 0;
        //codigo opara el datatable
        var oTable = $('#tblorden').DataTable({
"paging": false,
        "ordering": false,
        "info": false,
        "footerCallback": function(row, data, start, end, display) {
        var api = this.api(),
                data;
                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };
                // Total over all pages
                subtotal = api
                .column(3)
                .data()
                .reduce(function(a, b) {
                return intVal(a) + intVal(b);
                }, 0);
                // Update footer
                $(api.row(2).column(3).footer()).html(
                '$' + subtotal
                );
                $('tr:eq(1) th:eq(3)', api.table().footer()).html('$' + calculariva('12', subtotal));
                //$('tr:eq(2) th:eq(3)', api.table().footer()).html('$'+calculariva('14',total));
                $('tr:eq(3) th:eq(3)', api.table().footer()).html('$' + calculartotalconiva('12', subtotal));
        }
});
        //funciones especiales
                function calculartotalconiva(iva, valor) {
                var calc = iva * valor / 100;
                        valor = valor + calc;
                        totalgeneral = valor.toFixed(2);
                        return totalgeneral;
                }

        function calculariva(ivaa, valor) {
        var calc = ivaa * valor / 100;
                iva = calc.toFixed(2);
                return iva;
        }

        //codigo para el select    
        $("#detalle").select2({
        theme: "bootstrap",
                placeholder: "Seleccione el Producto",
                allowClear: true

        });
                $("#cliente").select2({
        ajax: {
        url: url_buscarclientes,
                dataType: 'json',
                delay: 250,
                data: function(params) {
                return {
                q: params.term // search term
                };
                },
                processResults: function(data) {
                // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data

                return {
                results: data
                };
                },
                cache: true
        },
                minimumInputLength: 2,
                placeholder: "Seleccione el cliente",
                theme: "bootstrap"


        });
                $('#cliente').on("select2:select", function(e) {
        $('#cedula').val(e.params.data.cedula);
                $('#direccion').val(e.params.data.direccion);
                $('#telefono').val(e.params.data.telefono);
        });
                $('#limpiarCliente').on('click', function() {
        $('#cliente').val(''); // Select the option with a value of 'US'
                $('#cliente').trigger('change');
                $('#cedula').val('');
                $('#direccion').val('');
                $('#telefono').val('');
        });
                //codgo para las fechas 
                $('#fpago').datetimepicker({
        format: 'YYYY-MM-DD',
                showTodayButton: true
        });
                $('#femision').datetimepicker({
        format: 'YYYY-MM-DD',
                showTodayButton: true
        });
                //al seleccionar un producto
                $('#detalle').on('change', function() {
        if ($(this).val() != "") {
        $.ajax({
        url: urlobtenerproducto,
                data: "id=" + $(this).val(),
                type:   'post',
                dataType: 'json',
                success: function(data) {
                $('#precio').val(data[0].cpprecioproducto_contado);
                        $('#cuenta').val(data[0].cpcodigo_producto);
                }
        });
        } else {
        $('#precio').val('');
                $('#cuenta').val('');
        }
        });
                //insertando datos en la tabla de ventas
                $("#form_nuevoventa").validate({
        errorClass: "my-error-class",
                validClass: "my-valid-class",
                // Reglas de validacion
                rules: {
                formapago: {
                required: true
                },
                        cantidad: {
                        required: true
                        },
                        femision: {
                        required: true
                        },
                        fpago: {
                        required: true
                        },
                        detalle: {
                        required: true
                        },
                        precio: {
                        required: true
                        }
                },
                // Mensajes de validacion
                messages: {
                formapago: {
                required: "Campo Requerido"
                },
                        fpago: {
                        required: "Campo Requerido"
                        },
                        femision: {
                        required: "Campo Requerido"
                        },
                        cantidad: {
                        required: "Campo Requerido"
                        },
                        precio: {
                        required: "Campo Requerido"
                        },
                        detalle: {
                        required: "Campo Requerido"
                        }

                },
                submitHandler: function(form) {

                var formData = new FormData(document.getElementById('form_nuevoventa'));
                        $.ajax({
                        url: url_insertar_tabla_temporal,
                                data: formData,
                                type:   'post',
                                dataType: 'json',
                                processData: false, // tell jQuery not to process the data
                                contentType: false,
                                success: function(data) {

                                var fila = oTable.row.add([
                                        data[0].cpcantidad_ax,
                                        data[0].cpdet_aux,
                                        data[0].cppu_aux,
                                        data[0].cppt_aux,
                                        '<div class="btn-group" role="group" aria-label="..." id="' + data[0].id_auxc + '">' +
                                        '<button type="button" class="btn btn-primary" id="btneliminar">' +
                                        '<span class="glyphicon glyphicon-ban-circle"></span>' +
                                        '</button>' +
                                        '</div>'
                                ]).draw(false);
                                        //actualizo la fila con su id
                                        var row = oTable.row(fila).node();
                                        $(row).attr('id', data[0].id_auxc);
                                        //limpio los campos
                                        $('#detalle').val(''); // Select the option with a value of 'US'
                                        $('#detalle').trigger('change');
                                        $('#precio').val('');
                                        $('#cuenta').val('');
                                        $('#cantidad').val('');
                                },
                                complete: function() {}

                        });
                }
        });
                //boton de registrar las ventas
                $('#registrar').on('click', function() {

        femision = $('#femision').val();
                fpago = $('#fpago').val();
                formapago = $('#formapago').val();
                factura = $('#factura').val();
                cedula = $('#cedula').val();
                comentario = $('#comentario').val();
                if (femision == "" || fpago == "" || cedula == "" || factura == "" || subtotal == 0 || totalgeneral == 0) {
        alertify.error('Faltan datos por introducir.</br> Por favor Reviselos.');
                return;
        }

        $.ajax({
        url: url_nuevoventas,
                data: 'subtotal=' + subtotal + '&iva=' + iva + "&tgeneral=" + totalgeneral + "&femision=" + femision + "&fpago=" + fpago + "&formapago=" + formapago + "&factura=" + factura + "&cedula=" + cedula + "&comentario=" + comentario,
                type:   'post',
                dataType: 'json',
                success: function(data) {
                $('#limpiarCliente').trigger('click');
                        oTable.clear().draw();
                        window.open(url_imprimir + "/" + data, '_blank');
                }
        });
        });
                //boton de cancelar ordenes guardadas
                $('#cancelar').on('click', function() {
        $.ajax({
        url: url_cancelar,
                data: "id=todos",
                type:   'post',
                dataType: 'json',
                success: function(data) {
                oTable.clear().draw();
                }
        });
        });
                //boton de eliminar por id los detalles de facturas
                $('#tblorden').on('click', '#btneliminar', function() {
        id = $(this).parents('div').attr('id');
                //consultando datos del clientes a editar
                $.ajax({
                url: url_cancelar,
                        data: "id=" + id,
                        type:   'post',
                        dataType: 'json',
                        success: function(data) {
                        //elimino la fila del objeto
                        oTable.row('#' + id).remove().draw(false);
                        }
                });
        });
        });