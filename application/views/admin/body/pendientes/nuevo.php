<div class="modal fade" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Pendiente</h4>
      </div>
        <form class="form-horizontal" id="form_nuevopendiente" method="post" action=""> 
        <div class="modal-body">
            <div class="col-md-12"><div class="mensaje_error" style="display: none"></div></div>
               
            
            <div class="form-group">
              <label for="nombre" class="col-sm-3 control-label">Nombre:</label>
              <div class="col-sm-9">
                  <textarea type="text" class="form-control" id="nombre" name="nombre" rows="7"></textarea>
              </div>
            </div>
            <div class="form-group">
               <label for="usuario" class="col-sm-3 control-label">Usuario:</label>
               <div class="col-sm-6">
                   <select class="form-control select2-single" dir="ltr" id="usuario" name="usuario" style="width: 100%">
                       <option></option>
                        <?php  
                        foreach ($usuarios as $us)
                           echo '<option value="'.$us->id_usuario.'">'.$us->usuario.'</option>';
                        ?>
                   </select>
               </div>
               
            </div>
            <div class="form-group">
                <label for="fecha" class="col-sm-3 control-label">Fecha:</label>
                <div class="col-sm-6">
                <div class="input-group date" id="datetimepicker1">
                    <input type="text" class="form-control" id="fecha" name="fecha" value="">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                </div>
            </div>

            <div class="form-group">
                <label for="hora" class="col-sm-3 control-label">Hora:</label>
                <div class="col-sm-6">
                <div class="input-group date" id="datetimepicker1">
                    <input type="text" class="form-control" id="hora" name="hora" value="">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                </div>
            </div>
            
            <div class="form-group">
               <label for="prioridad" class="col-sm-3 control-label">Prioridad:</label>
               <div class="col-sm-6">
                   <select class="form-control select2-single" dir="ltr" id="prioridad" name="prioridad" style="width: 100%">
                       <option></option>
                       <option value="NORMAL">NORMAL</option>
                       <option value="URGENTE">URGENTE</option>
                   </select>
               </div>
               
            </div> 
           
            <input type="hidden" id="id" name="id" value=""/>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="btnguardar">Guardar</button>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar Actividad</h4>
      </div>
        <div class="modal-body">
            <h4>¿Está seguro que desea eliminar este Pendiente?</h4>
        </div>
        <input type="hidden" id="id_eliminar" name="id_eliminar" value=""/>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="eliminar">Eliminar</button>
      </div>
    </div>
  </div>
</div>