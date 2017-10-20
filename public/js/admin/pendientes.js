$(document).ready(function() {
    //variabe que dice si estoy editando o insertando nuevo
    var accion="";
    
         // tooltip demo
        $('.tooltip-demo').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });
        $('#fecha').datetimepicker({
                format: 'YYYY-MM-DD',
                showTodayButton:true
            });

        //horas
        $('#hora').datetimepicker({
                format: 'HH:mm'
        });
       
       $( "#usuario" ).select2( {
            theme: "bootstrap",
            placeholder: "Seleccione el usuario",
            allowClear: true
                
	} );
        $( "#prioridad" ).select2( {
            theme: "bootstrap",
            placeholder: "Seleccione la prioridad",
            allowClear: true
                
	} );
        
         var oTable = $('#tblpendiente').DataTable({
              "language": {
                  "zeroRecords": "No se encontraron elementos"
                },
                "paging":   false,
                "ordering": false,
                "info":     false
         });
         
        
        //boton de editar TIPO SOLICITUD
        $('#tblpendiente').on('click','#btneditar',function(){
            accion='editar';
            $('#form_nuevopendiente').clearForm(); 
            $('.mensaje_error').css('display','none');
            $id=$(this).parent('div').attr('id');
            //consultando datos del objeto a editar
            $.ajax({
                url: url_obtenerpendiente,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    $('#nuevoModal').find('#id').val(data[0]);
                    $('#nuevoModal').find('#nombre').val(data[1]);
                    $('#nuevoModal').find("#usuario").val(data[7]);
                    $('#nuevoModal').find("#usuario").trigger('change.select2');
                    
                    $('#nuevoModal').find("#prioridad").val(data[6]);
                    $('#nuevoModal').find("#prioridad").trigger('change.select2');
                    
                    
                    $('#nuevoModal').find('#fecha').val(data[2]);
                    $('#nuevoModal').find('#hora').val(data[3]);
                    $('#nuevoModal').find('.modal-title').html('Editando Pendiente');
                    $('#nuevoModal').find('.modal-header').css('background-color','rgba(149, 214, 0, 0.54)');
                    $('#nuevoModal').modal('show');
                }
            });
        });
        
        //boton de agregar nuevo pendiente
        $('#btnnuevo').on('click',function(){
            accion='nuevo';
            //limpio el formulari
            $('#form_nuevopendiente').clearForm();
            //limpio todas las filas de la tabla restricciones
            $('#nuevoModal').find('.modal-title').html('Nuevo Pendiente');
            $('#nuevoModal').find('.modal-header').css('background-color','#337ab7');
            $('#nuevoModal').modal('show');
        });
        
        //validando formulario de nuevo pendiente
        $("#form_nuevopendiente").validate({
            errorClass: "my-error-class",
            validClass: "my-valid-class",
            // Reglas de validacion
            rules: {
                nombre: {required: true},
                usuario:{required: true},
                prioridad:{required: true},
                fecha:{required: true},
                hora:{required: true}
            },
            // Mensajes de validacion
            messages: {
               nombre: {required: "Campo Requerido"},
               usuario:{required: "Campo Requerido"},
               prioridad:{required: "Campo Requerido"},
                fecha:{required: "Campo Requerido"},
                hora:{required: "Campo Requerido"}
            },
            submitHandler: function(form){
               if(accion=='nuevo')
                 url=url_nuevopendiente;
               else if(accion=='editar')
                 url=url_editarpendiente;
             
               var formData = new FormData(document.getElementById('form_nuevopendiente'));
               $.ajax({
                url: url,
                data:  formData,
                type:  'post',
                dataType: 'json',
                processData: false,  // tell jQuery not to process the data
                contentType: false ,
                success : function(data) {
                    location.reload();
//                    //si no hubo error
//                    if(data['error']=='0'){
//                        //elimino la fila para despues insertarla
//                       oTable.row('#'+data['datos'][0]).remove().draw( false );   
//                       
//                       var e;
//                       if(data['datos'][4]=="REVISAR")
//                          e='<button type="button" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="left" title="" data-original-title="Revisar"><span class="glyphicon glyphicon-warning-sign"></span></button>';
//                       else if(data['datos'][4]=='PENDIENTE')
//                          e='<button type="button" class="btn btn-primary btn-circle" data-toggle="tooltip" data-placement="left" title="" data-original-title="Pendiente"><span class="glyphicon glyphicon-edit"></span></button>';
//                      
//                       //actualizo la tabla con los nuevos valores
//                       var fila=oTable.row.add( [
//                          data['datos'][1],
//                          data['datos'][2],
//                          data['datos'][3],
//                          e,               
//                          '<div class="btn-group" role="group" aria-label="..." id="'+data['datos'][0]+'">'+
//                                 '<button type="button" class="btn btn-primary" id="btneditar">'+
//                                     '<span class="glyphicon glyphicon-ok-circle"></span>'+
//                                 '</button>'+
//                                 '<button type="button" class="btn btn-primary" id="btneliminar">'+
//                                     '<span class="glyphicon glyphicon-ban-circle"></span>'+
//                                 '</button>'+
//                             '</div>'
//                       ]).draw();
//                       
//                       //move added row to desired index (here the row we clicked on)
//                        var index = oTable.row($('tr#'+data['datos'][5]).next('tr')).index(),
//                            rowCount = oTable.data().length-1,
//                            insertedRow = oTable.row(rowCount).data(),
//                            tempRow;
//
//                        for (var i=rowCount;i>index;i--) {
//                            tempRow = oTable.row(i-1).data();
//                            oTable.row(i).data(tempRow);
//                            oTable.row(i-1).data(insertedRow);
//                        }
//                       var currentPage = oTable.page();
//                       oTable.page(currentPage).draw(false);
//                        
//                       //actualizo la fila con su id
//                       var row = oTable.row(fila).node();
//                       $(row).attr('id',data['datos'][0]);
//
//                       //actualizo el mensaje de insercion satisfactoria
//                       alertify.success(data['mensaje']);
//                   }
//                   else{
//                       //actualizo el mensaje de insercion satisfactoria
//                        alertify.error(data['mensaje']);
//                        return;
//                   }
//                   //limpio el formulario
//                   $('#form_nuevorestricciones').clearForm(); 
//                   $('.mensaje_error').css('display','none');
//                   $('#nuevoModal').modal('hide');
                },
                complete: function() {
                    
                }

                });
            }
        });
        
        //boton de eliminar pendiente
        $('#tblpendiente').on('click','#btneliminar',function(){
            $id=$(this).parent('div').attr('id');
            $('#eliminarModal').find('#id_eliminar').val($id);
            $('#eliminarModal').modal('show');
            
        });
        
        //boton de eliminar objeto
        $('#eliminarModal').find('#eliminar').on('click',function(){
            $id=$('#eliminarModal').find('#id_eliminar').val();
            
            //consultando datos del objeto a editar
            $.ajax({
                url: url_eliminarpendiente,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    //elimino la fila del objeto
                    oTable.row('#'+data['datos'].id_pendiente).remove().draw( false ); 
                    alertify.success(data['mensaje']);
                    $('#eliminarModal').modal('hide');
                }
            });
        });
        
        //boton de eliminar objeto
        $('#tblpendiente').on('click','#btnok',function(){
            $id=$(this).parent('div').attr('id');
            //consultando datos del objeto a editar
            $.ajax({
                url: url_aprobarpendiente,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                     location.reload();
                }
            });
        });
     });
