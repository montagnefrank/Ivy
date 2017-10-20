<div class="modal fade bs-example-modal-lg" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="icon-users"></span> Nuevo Cliente</h4>
      </div>
        <form class="form-horizontal" id="form_nuevocliente" method="post" action=""> 
        <div class="modal-body">
            <div class="col-md-13"><div class="mensaje_error" style="display: none"></div></div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="cuenta" class="col-sm-3 control-label">Cuenta Asignada</label>
                          <div class="col-sm-9">
                              <label class="control-label" id="labelcuenta"><?php if(isset($codigo)) echo $codigo ?></label>
                              <input type="hidden" class="form-control" id="cuenta" name="cuenta" value="<?php if(isset($codigo)) echo $codigo ?>">
                             
                          </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="cedula" class="col-sm-3 control-label">Cedula/Ruc*</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cedula/Ruc">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="razon_social" class="col-sm-3 control-label">Razon Social*</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Razón Social">
                          </div>
                        </div>
                    </div>
                
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="direccion" class="col-sm-3 control-label">Dirección*</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección">
                          </div>
                        </div>
                    </div>
                  
                
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="telefono" class="col-sm-3 control-label">Teléfono*</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="telefonoc" class="col-sm-3 control-label">Teléfono de Contacto</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="telefonoc" name="telefonoc" placeholder="Teléfono de Contacto">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="movil" class="col-sm-3 control-label">Movil</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="movil" name="movil" placeholder="Movil">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="movilc" class="col-sm-3 control-label">Movil de Contacto</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="movilc" name="movilc" placeholder="Movil de Contacto">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                        </div>
                    </div>
                     <div class="col-md-12">
                        <div class="form-group">
                            <label for="obligado" class="col-sm-3 control-label">Obligado/ Contabilidad</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="obligado" name="obligado">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    
                                </select>
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
        <h4 class="modal-title" id="myModalLabel">Eliminar Cliente</h4>
      </div>
        <div class="modal-body">
            <h4>¿Está seguro que desea eliminar este Cliente?</h4>
        </div>
        <input type="hidden" id="id_eliminar" name="id_eliminar" value=""/>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="eliminar">Eliminar</button>
      </div>
    </div>
  </div>
</div>