$(document).ready(function() {
    //variabe que dice si estoy editando o insertando nuevo
    var accion="";
    
         var oTable = $('#tblclientes').DataTable({
           
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
        $("#form_nuevocliente").validate({
            errorClass: "my-error-class",
            validClass: "my-valid-class",
            // Reglas de validacion
            rules: {
                cedula: {required: true},
                razon_social: {required: true},
                direccion: {required: true},
                telefono: {required: true}
            },
            // Mensajes de validacion
            messages: {
                cedula: {required: "Campo Requerido"},
                razon_social: {required: "Campo Requerido"},
                direccion: {required: "Campo Requerido"},
                telefono: {required: "Campo Requerido"}
               
            },
            submitHandler: function(form){
               if(accion=='nuevo')
                 url=url_nuevoclientes;
               else if(accion=='editar')
                 url=url_editarclientes;
             
               var formData = new FormData(document.getElementById('form_nuevocliente'));
               
               $.ajax({
                url: url,
                data:  formData,
                type:  'post',
                dataType: 'json',
                processData: false,  // tell jQuery not to process the data
                contentType: false ,
                success : function(data) {
                    $('#form_nuevocliente').clearForm();
                    //si no hubo error
                    if(data['error']=='0'){
                     //elimino la fila para despues insertarla
                    oTable.row('#'+data['datos'][0].id_cliente).remove().draw( false );   
                    
                    
                    var fila=oTable.row.add( [
                       data['datos'][0].cpcedula_cliente,                       
                       data['datos'][0].cprazonsocial_cliente,  
                       data['datos'][0].cpdireccion_cliente,
                       data['datos'][0].cptelefono_cliente,
                       '<div class="btn-group" role="group" aria-label="..." id="'+data['datos'][0].id_cliente+'">'+
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
                    $(row).attr('id',data['datos'][0].id_cliente);
                    
                    //actualizo el mensaje de insercion satisfactoria
                    alertify.success(data['mensaje']);
                   }
                   else{
                       //actualizo el mensaje de insercion satisfactoria
                        alertify.error(data['mensaje']);
                        
                   }
                   //limpio el formulario 
                   $('#form_nuevocliente').clearForm();
                   $('#nuevoModal').modal('hide');
                   
                   
                },
                complete: function() {
                    
                }

                });
            }
        });
        
        //boton de editar objeto
        $('#tblclientes').on('click','#btneditar',function(){
            accion='editar';
            $('#form_nuevocliente').clearForm(); 
            $('.mensaje_error').css('display','none');
            $id=$(this).parent('div').attr('id');
                        
            //consultando datos del objeto a editar
            $.ajax({
                url: url_obtenerclientes,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    $('#nuevoModal').find('#cuenta').val(data['datos'][0].cpcodigoplan_cliente);
                    $('#nuevoModal').find('#labelcuenta').html(data['datos'][0].cpcodigoplan_cliente);
                    $('#nuevoModal').find('#id').val(data['datos'][0].id_cliente);
                    $('#nuevoModal').find('#cedula').val(data['datos'][0].cpcedula_cliente);
                    $('#nuevoModal').find('#razon_social').val(data['datos'][0].cprazonsocial_cliente);
                    $('#nuevoModal').find('#direccion').val(data['datos'][0].cpdireccion_cliente);
                    $('#nuevoModal').find('#email').val(data['datos'][0].cpcorreo_cliente);
                    $('#nuevoModal').find('#telefono').val(data['datos'][0].cptelefono_cliente);
                    $('#nuevoModal').find('#telefonoc').val(data['datos'][0].cptelefono2_cliente);
                    $('#nuevoModal').find('#movil').val(data['datos'][0].cpcelular_cliente);
                    $('#nuevoModal').find('#movilc').val(data['datos'][0].cpcelular2_cliente);
                    $('#nuevoModal').find('#obligado > option[value="'+data['datos'][0].cpretenciones_contabilidad+'"]').prop('selected', true);
                                        
                    $('#nuevoModal').find('.modal-title').html('<span class="icon-user"></span> Editando el cliente: '+data['datos'][0].cprazonsocial_cliente);
                    $('#nuevoModal').find('.modal-header').css('background-color','rgba(149, 214, 0, 0.54)');
                    $('#nuevoModal').modal('show');
                }
            });
           
        });
        
        //boton de agregar nuevo
        $('#btnnuevo').on('click',function(){
            accion='nuevo';
            //limpio el formulari
            $('#form_nuevocliente').clearForm(); 
            $.ajax({
                url: url_codigonuevo,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    $('#nuevoModal').find('#cuenta').val(data);
                    $('#nuevoModal').find('#labelcuenta').html(data);
                    $('#nuevoModal').find('.modal-title').html('<span class="icon-user"></span> Nuevo Cliente');
                    $('#nuevoModal').find('.modal-header').css('background-color','#337ab7');
                }
            });
            
        });
        
        //boton de eliminar clientes
        $('#tblclientes').on('click','#btneliminar',function(){
            $id=$(this).parent('div').attr('id');
            $('#eliminarModal').find('#id_eliminar').val($id);
            $('#eliminarModal').modal('show');
            
        });
        
        //boton de eliminar clientes
        $('#eliminarModal').find('#eliminar').on('click',function(){
            $id=$('#eliminarModal').find('#id_eliminar').val();
            
            //consultando datos del clientes a editar
            $.ajax({
                url: url_eliminarclientes,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    //elimino la fila del objeto
                    oTable.row('#'+data['datos'].id_cliente).remove().draw( false ); 
                    alertify.success(data['mensaje']);  
                    $('#eliminarModal').modal('hide');
                }
            });
        });
     });
