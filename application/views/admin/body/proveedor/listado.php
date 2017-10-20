<div id="page-wrapper">
      <div class="row">
      <div class="col-md-10">
          <h3 class="page-header">Listado de Proveedor</h3>
      </div>
      <div class="col-md-2">
          <button type="button" class="btn btn-primary navbar-btn" data-toggle="modal" data-target="#nuevoModal" id="btnnuevo">
               <span class="glyphicon glyphicon-plus"></span> Nuevo Proveedor
           </button>
      </div>
      </div>
      <div class="table-responsive">
          <table class="table table-striped row-border dt-responsive" cellspacing="0" width="100%" id="tblproveedor">
              <thead>
                  <tr>
                   
                    <th>Proveedor</th>
                    <th>Direccion</th>
                    <th>Cedula/Ruc</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if(!empty($content))
                        foreach($content as $element):
                ?>
                  <tr id="<?php echo $element->id_proveedor; ?>">
                      <td><?php echo $element->cpcomercial_proveedor ." ". $element->cpnombre_proveedor?></td>
                      <td><?php echo $element->cpdireccion_proveedor; ?>   </td>
                      <td><?php echo $element->cpruc_proveedor; ?>   </td>
                      <td><?php echo $element->cptelefono_proveedor; ?>   </td>
                      <td>
                          <div class="btn-group" role="group" aria-label="..." id="<?php echo $element->id_proveedor; ?>">
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
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/admin/proveedor.js"></script>


<script type="text/javascript">
    var url_nuevoproveedor='<?php echo site_url($this->package.'/proveedor/nuevoproveedor'); ?>';
    var url_obtenerproveedor='<?php echo site_url($this->package.'/proveedor/obtener_proveedor'); ?>';
    var url_editarproveedor='<?php echo site_url($this->package.'/proveedor/editarproveedor'); ?>';
    var url_eliminarproveedor='<?php echo site_url($this->package.'/proveedor/eliminarproveedor'); ?>';
    var url_codigonuevo='<?php echo site_url($this->package.'/proveedor/codigonuevo'); ?>';
</script>