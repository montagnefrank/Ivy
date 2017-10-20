$(document).ready(function() {
    //variabe que dice si estoy editando o insertando nuevo
    var accion="";
    
         var oTable = $('#usuarios').DataTable({
           
                "language": {
                    "lengthMenu": "Mostrando _MENU_ filas por pág.",
                    "zeroRecords": "No se encontraron elementos",
                    "info": "Página _PAGE_ de _PAGES_ /Total (_MAX_)",
                    "infoEmpty": "No se encontraron elementos",
                    "infoFiltered": "(filtrado de un total _MAX_)",
                    "sSearch": "Buscar:"
                }
         });
         //para el input del color
          $('input.color').colorPicker();
          
        //validando formulario de nuevo objeto
        $("#form_nuevousuarios").validate({
            errorClass: "my-error-class",
            validClass: "my-valid-class",
            // Reglas de validacion
            rules: {
                nombre: {required: true},
                usuario: {required: true},
                rol: {required: true},
                color: {required: true}
            },
            // Mensajes de validacion
            messages: {
                nombre: {required: "Campo Requerido"},
                usuario: {required: "Campo Requerido"},
                rol: {required: "Campo Requerido"},
                color: {required: "Campo Requerido"}
               
            },
            submitHandler: function(form){
               if(accion=='nuevo')
                 url=url_nuevousuarios;
               else if(accion=='editar')
                 url=url_editarusuarios;
             
               $('#destino option').prop('selected', 'selected');
               var formData = new FormData(document.getElementById('form_nuevousuarios'));
                      
               
               $.ajax({
                url: url,
                data:  formData,
                type:  'post',
                dataType: 'json',
                processData: false,  // tell jQuery not to process the data
                contentType: false ,
                success : function(data) {
                    $('#form_nuevousuarios').clearForm();
                    //si no hubo error
                    if(data['error']=='0'){
                     //elimino la fila para despues insertarla
                    oTable.row('#'+data['datos'][0].id_usuario).remove().draw( false );   
                    
                    
                    var fila=oTable.row.add( [
                       data['datos'][0].id_usuario,                       
                       data['datos'][0].usuario,  
                       data['datos'][0].contrasenna,
                       data['datos'][0].n_rol,
                       '<div style="width: 70%;height: 30px;background:'+data['datos'][0].cpcolor_usuario+'"></div>',  
                       
                       '<div class="btn-group" role="group" aria-label="..." id="'+data['datos'][0].id_usuario+'">'+
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
                    $(row).attr('id',data['datos'][0].id_usuario);
                    
                    //actualizo el mensaje de insercion satisfactoria
                    alertify.success(data['mensaje']);
                   }
                   else{
                       //actualizo el mensaje de insercion satisfactoria
                        alertify.error(data['mensaje']);
                        
                   }
                   //limpio el formulario 
                   $('#form_nuevousuarios').clearForm();
                   $('#nuevoModal').modal('hide');
                   
                   
                },
                complete: function() {
                    
                }

                });
            }
        });
        
        //boton de editar objeto
        $('#usuarios').on('click','#btneditar',function(){
            accion='editar';
            $('#form_nuevousuarios').clearForm(); 
            $('.mensaje_error').css('display','none');
            $id=$(this).parent('div').attr('id');
            $('#nuevoModal').find('#destino').html('');
            $('#nuevoModal').find('#origen').html('');
            
            $.ajax({
                url: url_obtener_posibles_usuariossub,
                type:  'post',
                data: "id="+$id,
                dataType: 'json',
                success : function(data) {
                   for(var i=0;i<data['us'].length;i++)
                    {
                      $('#nuevoModal').find('#origen').append('<option value="'+data['us'][i].id_usuario+'">'+data['us'][i].usuario+'</option>');
                    }
                }
            });
            
            
            //consultando datos del objeto a editar
            $.ajax({
                url: url_obtenerusuarios,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    $('#nuevoModal').find('#id').val(data['datos'][0].id_usuario);
                    $('#nuevoModal').find('#nombre').val(data['datos'][0].nombre);
                    $('#nuevoModal').find('#apellidos').val(data['datos'][0].apellidos);
                    $('#nuevoModal').find('#email').val(data['datos'][0].email);
                    $('#nuevoModal').find('#cargo').val(data['datos'][0].cargo);
                    $('#nuevoModal').find('#usuario').val(data['datos'][0].usuario);
                    $('#nuevoModal').find('#color').val(data['datos'][0].cpcolor_usuario);
                    $('#nuevoModal').find('#color').css('background',data['datos'][0].cpcolor_usuario);
                    $('#nuevoModal').find('#contrasena').val(data['datos'][0].contrasenna);
                    
                    
                    for(var i=0;i<data['us'].length;i++)
                    {
                        $('#nuevoModal').find('#destino').append('<option value="'+data['us'][i].id_usuario+'">'+data['us'][i].usuario+'</option>');
                    }
                    
                    $('#nuevoModal').find('#rol > option[value="'+data['datos'][0].idrol_usuario+'"]').prop('selected', true);
                    if(data['datos'][0].idrol_usuario=='5' || data['datos'][0].idrol_usuario=='6')
                       $('#nuevoModal').find('#usuariosAsub').css('display','inline');
                    else
                        $('#nuevoModal').find('#usuariosAsub').css('display','none');
                    
                    $('#nuevoModal').find('.modal-title').html('<span class="icon-user"></span> Editando el usuario: '+data['datos'][0].usuario);
                    $('#nuevoModal').find('.modal-header').css('background-color','rgba(149, 214, 0, 0.54)');
                    $('#nuevoModal').modal('show');
                }
            });
           
        });
        
        //boton de agregar nuevo
        $('#btnnuevo').on('click',function(){
            accion='nuevo';
            //limpio el formulari
            $('#form_nuevousuarios').clearForm(); 
            $('#nuevoModal').find('#destino').html('');
            $('#nuevoModal').find('#origen').html('');
            
            $('#nuevoModal').find('#usuariosAsub').css('display','none');
            $('.mensaje_error').css('display','none');
            $('#nuevoModal').find('.modal-title').html('<span class="icon-user"></span> Nuevo Usuario');
            $('#nuevoModal').find('.modal-header').css('background-color','#337ab7');
        });
        
        //boton de eliminar usuarios
        $('#usuarios').on('click','#btneliminar',function(){
            $id=$(this).parent('div').attr('id');
            $('#eliminarModal').find('#id_eliminar').val($id);
            $('#eliminarModal').modal('show');
            
        });
        
        //boton de eliminar usuarios
        $('#eliminarModal').find('#eliminar').on('click',function(){
            $id=$('#eliminarModal').find('#id_eliminar').val();
            
            //consultando datos del usuarios a editar
            $.ajax({
                url: url_eliminarusuarios,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    //elimino la fila del objeto
                    oTable.row('#'+data['datos'].id_usuario).remove().draw( false ); 
                    alertify.success(data['mensaje']);  
                    $('#eliminarModal').modal('hide');
                }
            });
        });
        
        //para los usuarios subordinados
        $('.pasar').click(function() { return !$('#origen option:selected').remove().appendTo('#destino'); });  
        $('.quitar').click(function() { return !$('#destino option:selected').remove().appendTo('#origen'); });
        $('.pasartodos').click(function() { $('#origen option').each(function() { $(this).remove().appendTo('#destino'); }); });
        $('.quitartodos').click(function() { $('#destino option').each(function() { $(this).remove().appendTo('#origen'); }); });
        
        //para el chanfge del rol
        $('#nuevoModal').find('#rol').on('change',function(){
            if($(this).val()=='5' || $(this).val()=='6')
            {
                
                $('#nuevoModal').find('#origen').html('');
                $('#nuevoModal').find('#destino').html('');
                
                //agregando posibles usuarios subordinados
                $.ajax({
                    url: url_obtener_posibles_usuariossub,
                    type:  'post',
                    data: "id=nuevo&rol="+$(this).val()+"&user="+$("#id").val(),
                    dataType: 'json',
                    success : function(data) {
                       
                       for(var i=0;i<data['us'].length;i++)
                        {
                          $('#nuevoModal').find('#origen').append('<option value="'+data['us'][i].id_usuario+'">'+data['us'][i].usuario+'</option>');
                        }
                        $('#nuevoModal').find('#usuariosAsub').css('display','inline');
                    }
                });
            }
            else
            {
               $('#nuevoModal').find('#usuariosAsub').css('display','none'); 
            }
        });
        
     });
