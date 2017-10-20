$(document).ready(function() {
    //variabe que dice si estoy editando o insertando nuevo
    var accion="";
    
         var oTable = $('#tblproductos').DataTable({
           
                "language": {
                    "lengthMenu": "Mostrando _MENU_ filas por pág.",
                    "zeroRecords": "No se encontraron elementos",
                    "info": "Página _PAGE_ de _PAGES_ /Total (_MAX_)",
                    "infoEmpty": "No se encontraron elementos",
                    "infoFiltered": "(filtrado de un total _MAX_)",
                    "sSearch": "Buscar:"
                }
         });
        
        $("#unidad_medida" ).select2( {
		theme: "bootstrap",
		placeholder: "Seleccione la Unidad de medida",
                allowClear: true
                
	} );
        $("#categoria" ).select2( {
		theme: "bootstrap",
		placeholder: "Seleccione la Categoria",
                allowClear: true
                
	} );
        
        $('#categoria').on("change", function (e) {
                $("#unidad_medida" ).html('');
                
               if($(this).val()=='fisico')
                {
                   $("#unidad_medida" ).append('<option value="unidad">Unidad</option><option value="porcion">Porcion</option><option value="gramos">Gramos</option>'); 
                }
                else
                {
                    $("#unidad_medida" ).append('<option value="unidad">Unidad</option>');
                }
                
        });
        
        $("#iva").select2( {
		theme: "bootstrap",
		placeholder: "Seleccione el IVA",
                allowClear: true
                
	} );
        
        
        //validando formulario de nuevo objeto
        $("#form_nuevoproductos").validate({
            errorClass: "my-error-class",
            validClass: "my-valid-class",
            // Reglas de validacion
            rules: {
                nombre: {required: true},
                descripcion: {required: true},
                categoria: {required: true}
              
            },
            // Mensajes de validacion
            messages: {
                nombre: {required: "Campo Requerido"},
                descripcion: {required: "Campo Requerido"},
                categoria: {required: "Campo Requerido"}
                
               
            },
            submitHandler: function(form){
               if(accion=='nuevo')
                 url=url_nuevoproductos;
               else if(accion=='editar')
                 url=url_editarproductos;
             
               var formData = new FormData(document.getElementById('form_nuevoproductos'));
               
               $.ajax({
                url: url,
                data:  formData,
                type:  'post',
                dataType: 'json',
                processData: false,  // tell jQuery not to process the data
                contentType: false ,
                success : function(data) {
                    $('#form_nuevoproductos').clearForm();
                    //si no hubo error
                    if(data['error']=='0'){
                     //elimino la fila para despues insertarla
                    oTable.row('#'+data['datos'][0].id_producto).remove().draw( false );   
                    
                    
                    var fila=oTable.row.add( [
                       data['datos'][0].cpnombre_producto,                       
                       data['datos'][0].cpdescripcion_producto,  
                       data['datos'][0].cpprecioproducto_contado,
                       data['datos'][0].idiva_producto,
                       data['datos'][0].cpstock_producto,
                       '<div class="btn-group" role="group" aria-label="..." id="'+data['datos'][0].id_producto+'">'+
                              '<button type="button" class="btn btn-primary" id="btneditar">'+
                                  '<span class="glyphicon glyphicon-edit"></span>'+
                              '</button>'+
                              '<button type="button" class="btn btn-primary" id="btneliminar">'+
                                  '<span class="glyphicon glyphicon-remove-sign"></span>'+
                              '</button>'+
                          '</div>'
                    ] ).draw( false );
                    //actualizo la fila con su id
                    var row = oTable.row(fila).node();
                    $(row).attr('id',data['datos'][0].id_producto);
                    
                    //actualizo el mensaje de insercion satisfactoria
                    alertify.success(data['mensaje']);
                   }
                   else{
                       //actualizo el mensaje de insercion satisfactoria
                        alertify.error(data['mensaje']);
                        
                   }
                   //limpio el formulario 
                   $('#form_nuevoproductos').clearForm();
                   $('#nuevoModal').modal('hide');
                   
                   
                },
                complete: function() {
                    
                }

                });
            }
        });
        
        //boton de editar objeto
        $('#tblproductos').on('click','#btneditar',function(){
            accion='editar';
            $('#form_nuevoproductos').clearForm(); 
            $id=$(this).parent('div').attr('id');
                        
            //consultando datos del objeto a editar
            $.ajax({
                url: url_obtenerproductos,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    $('#nuevoModal').find('#id').val(data['datos'][0].id_producto);
                    $('#nuevoModal').find('#nombre').val(data['datos'][0].cpnombre_producto);
                    $('#nuevoModal').find('#descripcion').val(data['datos'][0].cpdescripcion_producto);
                    $('#nuevoModal').find('#precioUnicontado').val(data['datos'][0].cpprecioproducto_contado);
                    $('#nuevoModal').find('#precioUniCredito').val(data['datos'][0].cppreciocredito_producto);
                    $('#nuevoModal').find('#stock').val(data['datos'][0].cpstock_producto);
                    $('#nuevoModal').find('#cantmin').val(data['datos'][0].cpcantidadminima_producto);
                    $('#nuevoModal').find('#cantmax').val(data['datos'][0].cpcantidadmaxima_producto);
                    $('#nuevoModal').find('#preciocompra').val(data['datos'][0].cppreciocompra_producto);
                    
                    $('#nuevoModal').find('#categoria').val(data['datos'][0].cpcategoria_producto); // Select the option with a value of 'US'
                    $('#nuevoModal').find('#categoria').trigger('change');
                    
                    $('#nuevoModal').find('#unidad_medida').val(data['datos'][0].cpunidadmedida_producto); // Select the option with a value of 'US'
                    $('#nuevoModal').find('#unidad_medida').trigger('change');
                    
                    $('#nuevoModal').find('#iva').val(data['datos'][0].idiva_producto); // Select the option with a value of 'US'
                    $('#nuevoModal').find('#iva').trigger('change');
                                        
                    $('#nuevoModal').find('.modal-title').html('<span class="icon-user"></span> Editando el Producto: '+data['datos'][0].cpnombre_producto);
                    $('#nuevoModal').find('.modal-header').css('background-color','rgba(149, 214, 0, 0.54)');
                    $('#nuevoModal').modal('show');
                }
            });
           
        });
        
        //boton de agregar nuevo
        $('#btnnuevo').on('click',function(){
            accion='nuevo';
            //limpio el formulari
            $('#form_nuevoproductos').clearForm(); 
            $('#nuevoModal').find('.modal-title').html('<span class="icon-user"></span> Nuevo Producto');
            $('#nuevoModal').find('.modal-header').css('background-color','#337ab7');
            
        });
        
        //boton de eliminar productos
        $('#tblproductos').on('click','#btneliminar',function(){
            $id=$(this).parent('div').attr('id');
            $('#eliminarModal').find('#id_eliminar').val($id);
            $('#eliminarModal').modal('show');
            
        });
        
        //boton de eliminar productos
        $('#eliminarModal').find('#eliminar').on('click',function(){
            $id=$('#eliminarModal').find('#id_eliminar').val();
            
            //consultando datos del productos a editar
            $.ajax({
                url: url_eliminarproductos,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    //elimino la fila del objeto
                    oTable.row('#'+data['datos'].id_producto).remove().draw( false ); 
                    alertify.success(data['mensaje']);  
                    $('#eliminarModal').modal('hide');
                }
            });
        });
     });
