//Para limpiar todos los campos del formulario
$.fn.clearForm = function() {
    return this.each(function() {
      var type = this.type, tag = this.tagName.toLowerCase();
      if (tag == 'form')
        return $(':input',this).clearForm();
      if (type == 'text' || type == 'password' || tag == 'textarea')
        this.value = '';
      else if (type == 'checkbox' || type == 'radio')
        this.checked = false;
      else if (tag == 'select')
        this.selectedIndex = -1;
      else if(tag='img')
          this.src='';
    });
    
  };
  
  $(document).ready(function() {
    //funcion que se ejecuta cada tres minutos buscando pendientes proximos a vencerse
    var relojito = setInterval(function(){
          obtenerAlarmas();
    }, 1200000);
  
  function obtenerAlarmas()
  {
      
      $.ajax({
                url: url_obteneralarmas,
                type:  'post',
                dataType: 'json',
                success : function(data) {
                    if(data!=0)
                    {
                         alertify.error('Tiene '+ data+ " pendientes próximos a vencerse.");
                         return; 
                    }
                }
            });
  }
  
  });