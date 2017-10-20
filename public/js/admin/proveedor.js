$(document).ready(function() {
    //variabe que dice si estoy editando o insertando nuevo
    var accion="";
    
         var oTable = $('#tblproveedor').DataTable({
           
                "language": {
                    "lengthMenu": "Mostrando _MENU_ filas por pág.",
                    "zeroRecords": "No se encontraron elementos",
                    "info": "Página _PAGE_ de _PAGES_ /Total (_MAX_)",
                    "infoEmpty": "No se encontraron elementos",
                    "infoFiltered": "(filtrado de un total _MAX_)",
                    "sSearch": "Buscar:"
                }
         });
        
        //validando formulario de nuevo objeto
        $("#form_nuevoproveedor").validate({
            errorClass: "my-error-class",
            validClass: "my-valid-class",
            // Reglas de validacion
            rules: {
                cpcomercial_proveedor: {required: true},
                cpnombre_proveedor: {required: true},
                cpruc_proveedor: {required: true},
                cpdireccion_proveedor: {required: true},
                cptelefono_proveedor: {required: true}
            },
            // Mensajes de validacion
            messages: {
                cpcomercial_proveedor: {required: "Campo Requerido"},
                cpnombre_proveedor: {required: "Campo Requerido"},
                cpruc_proveedor: {required: "Campo Requerido"},
                cpdireccion_proveedor: {required: "Campo Requerido"},
                cptelefono_proveedor: {required: true}
               
            },
            submitHandler: function(form){
               if(accion=='nuevo')
                 url=url_nuevoproveedor;
               else if(accion=='editar')
                 url=url_editarproveedor;
             
               var formData = new FormData(document.getElementById('form_nuevoproveedor'));
               
               $.ajax({
                url: url,
                data:  formData,
                type:  'post',
                dataType: 'json',
                processData: false,  // tell jQuery not to process the data
                contentType: false ,
                success : function(data) {
                    $('#form_nuevoproveedor').clearForm();
                    //si no hubo error
                    if(data['error']=='0'){
                     //elimino la fila para despues insertarla
                    oTable.row('#'+data['datos'][0].id_proveedor).remove().draw( false );   
                    
                    
                    var fila=oTable.row.add( [
                       data['datos'][0].cpcomercial_proveedor +" "+ data['datos'][0].cpnombre_proveedor,                       
                       data['datos'][0].cpdireccion_proveedor,  
                       data['datos'][0].cpruc_proveedor,
                       data['datos'][0].cptelefono_proveedor,
                       '<div class="btn-group" role="group" aria-label="..." id="'+data['datos'][0].id_proveedor+'">'+
                              '<button type="button" class="btn btn-primary" id="btneditar">'+
                                  '<span class="glyphicon glyphicon-ok-circle"></span>'+
                              '</button>'+
                              '<button type="button" class="btn btn-primary" id="btneliminar">'+
                                  '<span class="glyphicon glyphicon-ban-circle"></span>'+
                              '</button>'+
                          '</div>'
                    ] ).draw( false );
                    //actualizo la fila con su id
                    var row = oTable.row(fila).node();
                    $(row).attr('id',data['datos'][0].id_proveedor);
                    
                    //actualizo el mensaje de insercion satisfactoria
                    alertify.success(data['mensaje']);
                   }
                   else{
                       //actualizo el mensaje de insercion satisfactoria
                        alertify.error(data['mensaje']);
                        
                   }
                   //limpio el formulario 
                   $('#form_nuevoproveedor').clearForm();
                   $('#nuevoModal').modal('hide');
                   
                   
                },
                complete: function() {
                    
                }

                });
            }
        });
        
        //boton de editar objeto
        $('#tblproveedor').on('click','#btneditar',function(){
            accion='editar';
            $('#form_nuevoproveedor').clearForm(); 
            $('.mensaje_error').css('display','none');
            $id=$(this).parent('div').attr('id');
                        
            //consultando datos del objeto a editar
            $.ajax({
                url: url_obtenerproveedor,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    $('#nuevoModal').find('#cuenta').val(data['datos'][0].cpcodigoplan_proveedor);
                    $('#nuevoModal').find('#labelcuenta').html(data['datos'][0].cpcodigoplan_proveedor);
                    $('#nuevoModal').find('#id').val(data['datos'][0].id_proveedor);
                    
                    $('#nuevoModal').find('#cpcelular_proveedor').val(data['datos'][0].cpcelular_proveedor);
                    $('#nuevoModal').find('#cpcodigoplan_proveedor').val(data['datos'][0].cpcodigoplan_proveedor);
                    $('#nuevoModal').find('#cpcomercial_proveedor').val(data['datos'][0].cpcomercial_proveedor);
                    $('#nuevoModal').find('#cpcorreo_proveedor').val(data['datos'][0].cpcorreo_proveedor);
                    $('#nuevoModal').find('#cpdireccion_proveedor').val(data['datos'][0].cpdireccion_proveedor);
                    $('#nuevoModal').find('#cpestado_proveedor').val(data['datos'][0].cpestado_proveedor);
                    $('#nuevoModal').find('#cpnombre_proveedor').val(data['datos'][0].cpnombre_proveedor);
                    $('#nuevoModal').find('#cpruc_proveedor').val(data['datos'][0].cpruc_proveedor);
                    $('#nuevoModal').find('#cptelefono2_proveedor').val(data['datos'][0].cptelefono2_proveedor);
                    $('#nuevoModal').find('#cptelefono_proveedor').val(data['datos'][0].cptelefono_proveedor);
                    $('#nuevoModal').find('.modal-title').html('<span class="icon-user"></span> Editando el Proveedor: '+data['datos'][0].cpcomercial_proveedor);
                    $('#nuevoModal').find('.modal-header').css('background-color','rgba(149, 214, 0, 0.54)');
                    $('#nuevoModal').modal('show');
                }
            });
           
        });
        
        //boton de agregar nuevo
        $('#btnnuevo').on('click',function(){
            accion='nuevo';
            //limpio el formulario
            $('#form_nuevoproveedor').clearForm(); 
            
            $.ajax({
                url: url_codigonuevo,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    $('#nuevoModal').find('#cuenta').val(data);
                    $('#nuevoModal').find('#labelcuenta').html(data);
                    $('#nuevoModal').find('.modal-title').html('<span class="icon-user"></span> Nuevo Proveedor');
                    $('#nuevoModal').find('.modal-header').css('background-color','#337ab7');
                }
            });
            
            
        });
        
        //boton de eliminar proveedor
        $('#tblproveedor').on('click','#btneliminar',function(){
            $id=$(this).parent('div').attr('id');
            $('#eliminarModal').find('#id_eliminar').val($id);
            $('#eliminarModal').modal('show');
            
        });
        
        //boton de eliminar proveedor
        $('#eliminarModal').find('#eliminar').on('click',function(){
            $id=$('#eliminarModal').find('#id_eliminar').val();
            
            //consultando datos del proveedor a editar
            $.ajax({
                url: url_eliminarproveedor,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    //elimino la fila del objeto
                    oTable.row('#'+data['datos'].id_proveedor).remove().draw( false ); 
                    alertify.success(data['mensaje']);  
                    $('#eliminarModal').modal('hide');
                }
            });
        });
     });
