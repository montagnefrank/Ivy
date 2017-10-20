<div class="modal fade bs-example-modal-lg" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="icon-users"></span> Nuevo Cliente</h4>
      </div>
        <form class="form-horizontal" id="form_nuevoproductos" method="post" action=""> 
        <div class="modal-body">
            <div class="col-md-13"><div class="mensaje_error" style="display: none"></div></div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="nombre" name="nombre" value="">
                             
                          </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="descripcion" class="col-sm-3 control-label">Descripcion</label>
                          <div class="col-sm-9">
                              <textarea rows="3" class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion"></textarea>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="categoria" class="col-sm-3 control-label">Categoria</label>
                          <div class="col-sm-9">
                              <select name="categoria" class="form-control"  id="categoria" style="width: auto">
                                        <option value=""></option>
                                        <option value="fisico">Fisico</option>
                                        <option value="servicio">Servicio</option>
                                </select>
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="unidad_medida" class="col-sm-3 control-label">Unidad de Medida</label>
                          <div class="col-sm-9">
                             <select name="unidad_medida" id="unidad_medida" class="form-control" style="width: auto" >
                                    <option value=""></option>
                                    
                            </select>
                          </div>
                        </div>
                    </div>
                    
                    
                    
                    
                    
                    
                
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="precioUnicontado" class="col-sm-3 control-label">Precio U(Contado)</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="precioUnicontado" name="precioUnicontado" placeholder="Precio U al Contado">
                          </div>
                        </div>
                    </div>
                  
                
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="precioUniCredito" class="col-sm-3 control-label">Precio U(Credito)</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="precioUniCredito" name="precioUniCredito" placeholder="Precio U Credito">
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="stock" class="col-sm-3 control-label">Stock (Existencia)</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="stock" name="stock" placeholder="Stock (Existencia)">
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="cantmin" class="col-sm-3 control-label">Cantidad Min</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="cantmin" name="cantmin" placeholder="Canitdad Mínima">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="cantmax" class="col-sm-3 control-label">Cantidad Max</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="cantmax" name="cantmax" placeholder="Cantidad Máxima">
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="preciocompra" class="col-sm-3 control-label">Precio Compra</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="preciocompra" name="preciocompra" placeholder="Precio Compra">
                            </div>
                        </div>
                    </div>
                    
                     <div class="col-md-12">
                        <div class="form-group">
                            <label for="iva" class="col-sm-3 control-label">IVA</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="iva" name="iva" style="width: auto">
                                    <option value=""></option>
                                    <option value="1">NO</option>
                                    <option value="2">SI</option>
                                    
                                </select>
                            </div>
                         </div>  
                    </div>
            </div>
           
            <input type="hidden" id="id" name="id" value="" />
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
        <h4 class="modal-title" id="myModalLabel">Eliminar Producto</h4>
      </div>
        <div class="modal-body">
            <h4>¿Está seguro que desea eliminar este Producto?</h4>
        </div>
        <input type="hidden" id="id_eliminar" name="id_eliminar" value=""/>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="eliminar">Eliminar</button>
      </div>
    </div>
  </div>
</div>