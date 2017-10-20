$(document).ready(function() {
    //variabe que dice si estoy editando o insertando nuevo
    var accion="";
    
   //cambiar tipo de plan
    $("#tipocuenta").on('change',function () {
        tipocuenta=$("#tipocuenta").val();
        $.ajax({
                url: url_obtenercodigo,
                data:"tipocuenta="+tipocuenta,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    str="";
                    $('#nivelcuenta').html('');
                    for(var i=0;i<data.length;i++)
                    {
                        str+='<option value="'+data[i]['cpnivel']+'">'+data[i]['cpcodigo_plancuentas']+'</option>'
                    }
                    $('#nivelcuenta').append(str);
                }
            });
    
    });
    
    
        $("#nivelcuenta" ).select2( {
		theme: "bootstrap",
		placeholder: "Seleccione..",
                allowClear: true
                
	} );
        
        //validando formulario de nuevo objeto
        $("#form_nuevoplanes").validate({
            errorClass: "my-error-class",
            validClass: "my-valid-class",
            // Reglas de validacion
            rules: {
                nombre: {required: true},
                nivelcuenta: {required: true},
                tipocuenta: {required: true},
                
            },
            // Mensajes de validacion
            messages: {
                nombre: {required: "Campo Requerido"},
                nivelcuenta: {required: "Campo Requerido"},
                tipocuenta: {required: "Campo Requerido"},
                
            },
            submitHandler: function(form){
               if(accion=='nuevo')
                 url=url_nuevoplanes;
               else if(accion=='editar')
                 url=url_editarplanes;
             
               var formData = new FormData(document.getElementById('form_nuevoplanes'));
               
               $.ajax({
                url: url,
                data:  formData,
                type:  'post',
                dataType: 'json',
                processData: false,  // tell jQuery not to process the data
                contentType: false ,
                success : function(data) {
                  location.reload();        
                   
                },
                complete: function() {
                    
                }

                });
            }
        });
        
        //boton de editar objeto
        $('#tblplanes').on('click','#btneditar',function(){
            accion='editar';
            $('#form_nuevoplanes').clearForm(); 
            $id=$(this).parent('div').attr('id');
                        
            //consultando datos del objeto a editar
            $.ajax({
                url: url_obtenerplanes,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    
                    
                    $('#nuevoModal').find('#nivelcuenta > option[value="'+data[0].cpfile+'"]').prop('selected', true);
                                        
                    $('#nuevoModal').find('#id').val(data[0].id_plancuentas);
                    $('#nuevoModal').find('#nombre').val(data[0].cpdescripcion_plancuentas);
                    
                    $('#tipocuenta').val(data[0].cpfile); // Select the option with a value of 'US'
                    $('#tipocuenta').trigger('change');
                    
                    
                    $('#nivelcuenta').val(data[0].cpcodigo_plancuentas); // Select the option with a value of 'US'
                    $('#nivelcuenta').trigger('change');
                                                                                
                    $('#nuevoModal').find('.modal-title').html('<span class="icon-user"></span> Editando el plan: '+data[0].cpdescripcion_plancuentas);
                    $('#nuevoModal').find('.modal-header').css('background-color','rgba(149, 214, 0, 0.54)');
                    $('#nuevoModal').modal('show');
                }
            });
           
        });
        
        //boton de agregar nuevo
        $('#btnnuevo').on('click',function(){
            accion='nuevo';
            //limpio el formulari
            $('#form_nuevoplanes').clearForm(); 
                       
        });
        
        //boton de eliminar planes
        $('#tblplanes').on('click','#btneliminar',function(){
            $id=$(this).parent('div').attr('id');
            $('#eliminarModal').find('#id_eliminar').val($id);
            $('#eliminarModal').modal('show');
            
        });
        
        //boton de eliminar planes
        $('#eliminarModal').find('#eliminar').on('click',function(){
            $id=$('#eliminarModal').find('#id_eliminar').val();
            
            //consultando datos del planes a editar
            $.ajax({
                url: url_eliminarplanes,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    location.reload();       
                }
            });
        });
     });
