<div class="modal fade bs-example-modal-lg" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="icon-users"></span> Nuevo Cliente</h4>
      </div>
        <form class="form-horizontal" id="form_nuevoplanes" method="post" action=""> 
        <div class="modal-body">
             <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tipocuenta" class="col-sm-3 control-label">Tipo de Cuenta</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="tipocuenta" name="tipocuenta">
                                   <?php if(isset($datos)){
                                            foreach ($datos as $dat)
                                                echo '<option value="'.$dat->cpfile.'">'.$dat->cpdescripcion_plancuentas.'</option>';
                                   } 
                                   ?>
                                    
                                </select>
                            </div>
                         </div>  
                    </div>
                     <div class="col-md-12">
                        <div class="form-group">
                            <label for="nivelcuenta" class="col-sm-3 control-label">Nivel de Cuenta</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="nivelcuenta" name="nivelcuenta" style="width:100%">
                                    <option value=""></option>
                                </select>
                            </div>
                         </div>  
                    </div>
                    
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                          </div>
                        </div>
                    </div>
                   
                    
            </div>
           
            <input type="hidden" id="id" name="id" value=""/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
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
        <h4 class="modal-title" id="myModalLabel">Eliminar Plan</h4>
      </div>
        <div class="modal-body">
            <h4>¿Está seguro que desea eliminar este Plan?</h4>
        </div>
        <input type="hidden" id="id_eliminar" name="id_eliminar" value=""/>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="eliminar">Eliminar</button>
      </div>
    </div>
  </div>
</div>