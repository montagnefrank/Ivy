<div class="modal fade bs-example-modal-lg" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="icon-users"></span> Nuevo Proveedor</h4>
      </div>
        <form class="form-horizontal" id="form_nuevoproveedor" method="post" action=""> 
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
                          <label for="cpcomercial_proveedor" class="col-sm-3 control-label">Nombre Empresa Comercial*</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="cpcomercial_proveedor" name="cpcomercial_proveedor" placeholder="Nombre Empresa Comercial">
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="cpnombre_proveedor" class="col-sm-3 control-label">Nombre Empresa*</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="cpnombre_proveedor" name="cpnombre_proveedor" placeholder="Nombre Empresa">
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="cpruc_proveedor" class="col-sm-3 control-label">Cedula/Ruc*</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="cpruc_proveedor" name="cpruc_proveedor" placeholder="Cedula/Ruc">
                          </div>
                        </div>
                    </div>
                
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="cpdireccion_proveedor" class="col-sm-3 control-label">Dirección*</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="cpdireccion_proveedor" name="cpdireccion_proveedor" placeholder="Dirección">
                          </div>
                        </div>
                    </div>
                  
                
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="cptelefono_proveedor" class="col-sm-3 control-label">Teléfono*</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="cptelefono_proveedor" name="cptelefono_proveedor" placeholder="Teléfono">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="cptelefono2_proveedor" class="col-sm-3 control-label">Teléfono de Contacto</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="cptelefono2_proveedor" name="cptelefono2_proveedor" placeholder="Teléfono de Contacto">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="cpcelular_proveedor" class="col-sm-3 control-label">Movil</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="cpcelular_proveedor" name="cpcelular_proveedor" placeholder="Movil">
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cpcorreo_proveedor" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="cpcorreo_proveedor" name="cpcorreo_proveedor" placeholder="Email">
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
        <h4 class="modal-title" id="myModalLabel">Eliminar Proveedor</h4>
      </div>
        <div class="modal-body">
            <h4>¿Está seguro que desea eliminar este Proveedor?</h4>
        </div>
        <input type="hidden" id="id_eliminar" name="id_eliminar" value=""/>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="eliminar">Eliminar</button>
      </div>
    </div>
  </div>
</div>