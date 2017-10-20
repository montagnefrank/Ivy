$(document).ready(function() {
    //variabe que dice si estoy editando o insertando nuevo
    var accion="";
    
         var oTable = $('#tblventas').DataTable({
           
                "language": {
                    "lengthMenu": "Mostrando _MENU_ filas por pág.",
                    "zeroRecords": "No se encontraron elementos",
                    "info": "Página _PAGE_ de _PAGES_ /Total (_MAX_)",
                    "infoEmpty": "No se encontraron elementos",
                    "infoFiltered": "(filtrado de un total _MAX_)",
                    "sSearch": "Buscar:"
                },
                "lengthMenu": [[-1], ["All"]],
               dom: 'rtip',
              
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    subtotal = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.row(1).column( 3 ).footer() ).html(
                        '$'+subtotal.toFixed(2)
                    );
            
                    // Total over all pages
                    total = api
                        .column( 5, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.row(1).column( 5 ).footer() ).html(
                        '$'+total.toFixed(2)
                    );
                    
                    // Total over all pages
                    valor = api
                        .column( 8, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.row(1).column( 8 ).footer() ).html(
                        '$'+valor.toFixed(2)
                    );
                    // Total over all pages
                    valor = api
                        .column( 11, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.row(1).column( 11 ).footer() ).html(
                        '$'+valor.toFixed(2)
                    );
                       
                }
         });
        
      
        
        $('#finicio').datetimepicker({
                format: 'YYYY-MM-DD',
                showTodayButton:true
        }); 
        $('#ffin').datetimepicker({
            format: 'YYYY-MM-DD',
            showTodayButton:true
        });
        
        
        
        //validando formulario de nuevo objeto
        $("#form_general").validate({
            errorClass: "my-error-class",
            validClass: "my-valid-class",
            // Reglas de validacion
            rules: {
                finicio: {required: true},
                ffin: {required: true}
           },
            // Mensajes de validacion
            messages: {
                finicio: {required: "Campo Requerido"},
                ffin: {required: "Campo Requerido"}
               
            }
        });
         
        
        $(".botonExcel").click(function(event){
            $("#FormularioExportacion").submit();
        });
        
     });
