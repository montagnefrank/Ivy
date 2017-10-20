<div id="page-wrapper">
      <div class="row">
      <div class="col-md-10">
          <h3 class="page-header">Listado de Usuarios</h3>
      </div>
      <div class="col-md-2">
          <button type="button" class="btn btn-primary navbar-btn" data-toggle="modal" data-target="#nuevoModal" id="btnnuevo">
               <span class="glyphicon glyphicon-plus"></span> Nuevo Usuario
           </button>
      </div>
      </div>
      <div class="table-responsive">
          <table class="table table-striped row-border dt-responsive" cellspacing="0" width="100%" id="usuarios">
              <thead>
                  <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Color</th>
                    <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if(!empty($content))
                        foreach($content as $element):
                ?>
                  <tr id="<?php echo $element->id_usuario; ?>">
                      <td><?php echo $element->id_usuario?>   </td>
                      <td><?php echo $element->usuario?>   </td>
                      <td><?php echo $element->contrasenna; ?>   </td>
                      <td><?php echo $element->cpdescripcion_rol; ?>   </td>
                      <td><div style="width: 70%;height: 30px;background:<?php echo $element->cpcolor_usuario; ?>"></div></td>
                      
                      <td>
                          <div class="btn-group" role="group" aria-label="..." id="<?php echo $element->id_usuario; ?>">
                              <button type="button" class="btn btn-primary" id="btneditar">
                                  <span class="glyphicon glyphicon-edit"></span>
                              </button>
                              <button type="button" class="btn btn-primary" id="btneliminar">
                                  <span class="glyphicon glyphicon-remove-sign"></span>
                              </button>
                            
                          </div> 
                      </td>
                  </tr>
                 <?php  endforeach; ?>
            </tbody>
          </table>
          
      </div>

   <?php include 'nuevo.php'; ?>
</div>



<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/css/bootstrap-datetimepicker.min.css"  media="all"  />
<link href="<?php echo base_url()?>public/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/css/select2-bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/css/responsive.bootstrap.min.css">

<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/dataTables.bootstrap.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/dataTables.responsive.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/responsive.jqueryui.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url()?>public/js/moment.js"></script>
<script src="<?php echo base_url()?>public/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url()?>public/js/select2.full.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/colorPicker/colors.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/colorPicker/colorPicker.data.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/colorPicker/colorPicker.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/colorPicker/jQuery_implementation/jqColor.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/admin/usuarios.js"></script>


<script type="text/javascript">
    var url_nuevousuarios='<?php echo site_url($this->package.'/usuarios/nuevousuarios'); ?>';
    var url_obtenerusuarios='<?php echo site_url($this->package.'/usuarios/obtener_usuarios'); ?>';
    var url_obtener_posibles_usuariossub='<?php echo site_url($this->package.'/usuarios/url_obtener_posibles_usuariossub'); ?>';
    var url_editarusuarios='<?php echo site_url($this->package.'/usuarios/editarusuarios'); ?>';
    var url_eliminarusuarios='<?php echo site_url($this->package.'/usuarios/eliminarusuarios'); ?>';
    var url_roles='<?php echo site_url($this->package.'/usuarios/obtener_roles'); ?>';
</script>