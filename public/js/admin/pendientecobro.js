$(document).ready(function() {

         var oTable = $('#tblfacturaventas').DataTable({
           
                "language": {
                    "lengthMenu": "Mostrando _MENU_ filas por pág.",
                    "zeroRecords": "No se encontraron elementos",
                    "info": "Página _PAGE_ de _PAGES_ /Total (_MAX_)",
                    "infoEmpty": "No se encontraron elementos",
                    "infoFiltered": "(filtrado de un total _MAX_)",
                    "sSearch": "Buscar:"
                },
                
                "lengthMenu": [[-1], ["All"]],
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
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            var amt = parseFloat(subtotal);
                            
            // Update footer
            $( api.row(1).column( 4 ).footer() ).html(
                '$'+amt.toFixed(2)
            );
           
                       
          }
         });
        
        $('.tooltip-demo').tooltip({
             selector: "[data-toggle=tooltip]",
             container: "body"
         });
         
         //boton de ver la factura
          $('#tblfacturaventas').on('click','.buscarfactura',function(){
            idventa=$(this).attr('id');  
              
            $.ajax({
                url: url_buscarfactura,
                data:"id_venta="+idventa,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                  $('#id_venta').val(idventa);
                  
                 $('#nuevoModal').find('#tabla1').html(   
                  '<table width="639" border="0" align="center">'+
                  '<tr>'+
                   ' <td colspan="4" align="center"><strong>FACTURA</strong></td>'+
                  '</tr>'+
                  '<tr>'+
                   ' <td width="107"><strong>Cedula / RUC:</strong></td>'+
                    '<td width="260">'+data['dcliente'][0].cpcedula_cliente+'</td>'+
                   ' <td width="129"><strong>Num Factura:</strong></td>'+
                    '<td width="129">'+data['dcliente'][0].cpnum1_venta+"-"+data['dcliente'][0].cpnum2_venta+'-'+data['dcliente'][0].cpnumero_venta+'</td>'+
                  '</tr>'+
                  '<tr>'+
                   ' <td ><strong>Nombres:</strong></td>'+
                    '<td colspan="3">'+data['dcliente'][0].cprazonsocial_cliente+'</td>'+
                  '</tr>'+
                  '<tr>'+
                   ' <td ><strong>Direccion:</strong></td>'+
                   ' <td colspan="3">'+data['dcliente'][0].cpdireccion_cliente+'</td>'+
                  '</tr>'+
                  '<tr>'+
                   ' <td ><strong>Teléfono:</strong></td>'+
                   ' <td>'+data['dcliente'][0].cptelefono_cliente+'</td>'+
                   ' <td><strong>Fecha:</strong></td>'+
                   ' <td>'+data['dcliente'][0].cpfecha_venta+'</td>'+
                  '</tr>'+
                '</table>');
                 
                 tabla2='<table width="637" border="1" align="center">'+
                 ' <tr>'+
                  '  <td width="83"><strong>Cantidad</strong></td>'+
                   ' <td width="357"><strong>Detalle</strong></td>'+
                    '<td width="92"><strong>Precio U.</strong></td>'+
                    '<td width="87"><strong>Precio T.</strong></td>'+
                  '</tr>';
          
                for(var i=0;i<data['dfactura'].length;i++)
                {
                    tabla2+= '<td>'+data['dfactura'][i].cpcantidad+'</td>'+
                      '<td>'+data['dfactura'][i].cpdetalle+'</td>'+
                      '<td>'+data['dfactura'][i].cpprecio_u+'</td>'+
                       '<td>'+data['dfactura'][i].cppreciototal+'</td>'+
                      '</tr>';
                      //subtotal=subtotal+totalt;

                }
                tabla2+='</table>';    
                
                $('#nuevoModal').find('#tabla2').html(tabla2);
                
                
                tabla3='<table width="645" border="0" align="center">'+
                  '<tr>'+
                    '<td colspan="2" rowspan="3"><strong>OBSERVACION:</strong> '+data['totales'][0].comentario+'</td>'+
                    '<td  align="center"><strong>Subtotal</strong></td>'+
                    '<td  align="center">'+data['totales'][0].cpsubtotal_ventas+'</td>'+
                  '</tr>'+
                  '<tr>'+
                   '<td  align="center"><strong>IVA 12%</strong></td>'+
                    '<td  align="center">'+data['totales'][0].cpiva_ventas+'</td>'+
                  '</tr>'+
                  '<tr>'+
                    '<td width="96"  align="center"><strong>Total</strong></td>'+
                    '<td width="93"  align="center">'+data['totales'][0].cptotal_ventas+'</td>'+
                 ' </tr>'+
                 ' </table>';
                
                $('#nuevoModal').find('#tabla3').html(tabla3);
                
                $('#nuevoModal').find('.modal-title').html('Factura '+data['dcliente'][0].cpnum1_venta+"-"+data['dcliente'][0].cpnum2_venta+'-'+data['dcliente'][0].cpnumero_venta);
                $('#nuevoModal').find('#form_efectuado').css('display','inline');
                $('#nuevoModal').find('#realizarpago').css('display','inline');
                $('#nuevoModal').modal('show');
                }
            });
        });
        
        
         $('#tblfacturaventas').on('click','.imprimirfactura',function(){
             idventa=$(this).attr('id');
             var a = document.createElement("a");
		a.target = "_blank";
		a.href = url_imprimir+"/"+idventa;
		a.click();
         });
         
         
         
         ////boton de ver la factura
          $('#realizarpago').on('click',function(){
              $("#form_efectuado").submit();
        });
        
        
        $("#form_efectuado").validate({
            errorClass: "my-error-class",
            validClass: "my-valid-class",
            // Reglas de validacion
            rules: {
                efectuado: {required: true},
                 numero: {required: true}
                
            },
            // Mensajes de validacion
            messages: {
                efectuado: {required: "Campo Requerido"},
                numero: {required: "Campo Requerido"}
            },
            submitHandler: function(form){
               
                if($('#efectuado').val()=="CHEQUE" || $('#efectuado').val()=="TRANSACCION")
                    $numero=$('#numero').val();
                else
                    $numero="";
                
               $.ajax({
                url: url_pagar,
                data:"pagado="+$('#efectuado').val()+"&id_venta="+$('#id_venta').val()+"&numero="+$numero,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    location.reload();
                }
            });
        }});
    
        $('#efectuado').on('change',function(){
            if($(this).val()=='CHEQUE' || $(this).val()=="TRANSACCION")            
              $("#divnumero").css('display','inline');
          else
              $("#divnumero").css('display','none');
        });
        
     });
