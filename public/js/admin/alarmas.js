$(document).ready(function() {
    
        //boton de editar TIPO SOLICITUD
        $('.btn-success').on('click',function(){
           
            $id=$(this).attr('id');
            //consultando datos del objeto a editar
            $.ajax({
                url: url_aprobarpendiente,
                data: "id="+$id,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    location.href=url_redirect;
                }
            });
        });
        
        
     });
