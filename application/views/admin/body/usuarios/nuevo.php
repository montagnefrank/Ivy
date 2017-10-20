<div class="modal fade bs-example-modal-lg" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="icon-users"></span> Nuevo Usuario</h4>
      </div>
        <form class="form-horizontal" id="form_nuevousuarios" method="post" action=""> 
        <div class="modal-body">
            <div class="col-md-13"><div class="mensaje_error" style="display: none"></div></div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="apellidos" class="col-sm-3 control-label">Apellidos</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos">
                          </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="email" class="col-sm-3 control-label">Email</label>
                          <div class="col-sm-9">
                              <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                          </div>
                        </div>
                    </div>
                   <div class="col-md-6">
                        <div class="form-group">
                            <label for="rol" class="col-sm-3 control-label">Rol</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="rol" name="rol">
                                    <option value=""></option>
                                    <?php if(isset($roles))
                                    {
                                      
                                      foreach ($roles as $rol):
                                     ?> 
                                       <option value="<?php echo $rol->id_rol ?>"><?php echo $rol->cpdescripcion_rol ?></option>
                                        
                                     <?php   endforeach;
                                    }
                                    ?>
                                </select>
                            </div>
                         </div>  
                    </div>
                    
                    
                </div>
               
                <div class="row">
                    <div class="col-md-6">  
                        <div class="form-group">
                          <label for="usuario" class="col-sm-3 control-label">Usuario</label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
                          </div>
                        </div>
                    </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contrasena" class="col-sm-3 control-label">Contraseña</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                    <div class="col-md-6" divcolor>  
                        <div class="form-group">
                          <label for="color" class="col-sm-3 control-label">Color</label>
                          <div class="col-sm-9">
                              <input type="text" class="color form-control" value="rgb(34, 34, 34)" readonly="" style="width: 200px;color: rgb(34, 34, 34);" id="color" name="color">
                           
                          </div>
                        </div>
                    </div>
            </div>
            
               
            <div class="row" id="usuariosAsub" style="display: none">
                <div class="row">
                <div class="col-md-12">  
                   <h4 class="page-header">Usuarios Subordinados</h4>
                </div>
            </div>
                <div class="col-md-3">
                    <select name="origen[]" id="origen" multiple="multiple" size="8" class="form-control">
                      <?php if(isset($usuariosSub))
                            {

                              foreach ($usuariosSub as $us):
                             ?> 
                               <option value="<?php echo $us->id_usuario ?>"><?php echo $us->usuario ?></option>

                             <?php   endforeach;
                            }
                            ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="btn-group-vertical" role="group" aria-label="...">
                        <input type="button" class="btn btn-primary pasar izq" value="Pasar »">
                        <input type="button" class="btn btn-primary quitar der" value="« Quitar">
                        <input type="button" class="btn btn-primary pasartodos izq" value="Todos »">
                        <input type="button" class="btn btn-primary quitartodos der" value="« Todos">
                    </div>
                </div>
                <div class="col-md-3" >
                    <select name="destino[]" id="destino" multiple="multiple" size="8" class="form-control">
                       
                    </select>
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
        <h4 class="modal-title" id="myModalLabel">Eliminar Objeto</h4>
      </div>
        <div class="modal-body">
            <h4>¿Está seguro que desea eliminar este objeto?</h4>
        </div>
        <input type="hidden" id="id_eliminar" name="id_eliminar" value=""/>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="eliminar">Eliminar</button>
      </div>
    </div>
  </div>
</div>