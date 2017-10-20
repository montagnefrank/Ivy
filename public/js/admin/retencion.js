$(document).ready(function() {

         var oTable = $('#tt').DataTable({
           
                "language": {
                    "lengthMenu": "Mostrando _MENU_ filas por pág.",
                    "zeroRecords": "No se encontraron elementos",
                    "info": "Página _PAGE_ de _PAGES_ /Total (_MAX_)",
                    "infoEmpty": "No se encontraron elementos",
                    "infoFiltered": "(filtrado de un total _MAX_)",
                    "sSearch": "Buscar:"
                },
                "dom": 'rt'
         });
        
        $('.tooltip-demo').tooltip({
             selector: "[data-toggle=tooltip]",
             container: "body"
         });
         
         //boton de ver la factura
          $('#tblretencion').on('click','.buscarRetencion',function(){
            idventa=$(this).attr('id');  
              
            $.ajax({
                url: url_buscarretencion,
                data:"id_venta="+idventa,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                 $('#form_retencion').clearForm();
                 $('#tt tbody').html(''); 
                  
                 $('#nuevoModal').find('#base').val(data[0].cpsubtotal_ventas);
                 $('#nuevoModal').find('#iva').val(data[0].cpiva_ventas);   
                 $('#nuevoModal').find('#lnumfactura').html(data[0].cpnum1_venta+"-"+data[0].cpnum2_venta+"-"+data[0].cpnumero_venta);   
                 $('#nuevoModal').find('#lfechafactura').html(data[0].cpfecha_venta);  
                 $('#nuevoModal').find('#id_venta').val(idventa);
                         
                 
//                $('#nuevoModal').find('.modal-title').html('Factura '+data['dcliente'][0].cpnum1_venta+"-"+data['dcliente'][0].cpnum2_venta+'-'+data['dcliente'][0].cpnumero_venta);
                $('#nuevoModal').modal('show');
                }
            });
        });
        
               
         var j=0;
         ////boton de ver la factura
          $('#btnanadir').on('click',function(){
            if($('#porcentaje').val()=='otro' && $('#otro').val()=="")
            {
              alertify.error('Inserte el porcentaje de la retención');
              return;  
            }
            
            porc_r=$('#porcentaje').val();
		
            if(porc_r >0 && porc_r<=10){
                tipo_r="RENTA";
                imp=$('#base').val();
            }
            else if(porc_r >9 && porc_r<=100){
                $tipo_r="IVA";
                imp=$('#iva').val();
            }
            valor=imp*(porc_r/100);
            tt=Math.round(valor * 100) / 100;
            
            if(j==0){
                var fila=oTable.row.add( [
                       imp,                    
                       tipo_r,
                       porc_r,
                       tt,
                       '<div class="btn-group" role="group" aria-label="..." id="1">'+
                              '<button type="button" class="btn btn-primary" id="btneliminar">'+
                                  '<span class="glyphicon glyphicon-ban-circle"></span>'+
                              '</button>'+
                          '</div>'
                    ] ).draw( false );
                    //actualizo la fila con su id
                    var row = oTable.row(fila).node();
                    $(row).attr('id','1');
                j++;
            }
            else
            {
                alertify.error('Solo Inserte una Fila');
            }
        });
        
        $('#tt').on('click','#btneliminar',function(){
            oTable.row('#1').remove().draw( false );
            j=0;
        });
        
        //boton finalizar retencion
        $('#btnfinalizar').on('click',function(){
            
            dato=new Array();
            //recorro la fila de la tabla
            $('#tt tbody tr td').each(function(index){
                dato[index]=$(this).html();
                
            });
            
            //verifico que se inserto en la tabla y esta puesto el codigo
            if($('#comp').val()==0 || dato.length==0)
            {
                alertify.error('Faltan Datos por Introducir');
                return;
            }
            
            if($('#porcentaje').val()=='otro' && $('#otro').val()=="")
            {
              alertify.error('Inserte el porcentaje de la retención');
              return;  
            }
            
            $.ajax({
                url: url_hacerretencion,
                data:"id_venta="+$('#id_venta').val()+"&codigo="+$('#comp').val()+"&base="+dato[0]+"&impuesto="+dato[1]+"&retencion="+dato[2]+"&valor="+dato[3],
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    alertify.success('Retencion Satisfactoria');
                    $('#form_retencion').clearForm();
                    $('#tt tbody').html('');
                    $('#nuevoModal').modal('hide');
                }
            });
        });
        
       $('#porcentaje').on('change',function(){
           if($(this).val()=='otro')
           {
                $('#otro').css('display','inline');
           }
           else
               $('#otro').css('display','none');
        });
        
     });
