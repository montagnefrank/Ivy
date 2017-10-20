<div id="page-wrapper">
    
    <div class="row" style="padding: 15px;">
      <div class="col-md-10">
          <h3 class="page-header">Listado de Pendientes</h3>
      </div>
      <div class="col-md-2">
          <button type="button" class="btn btn-outline btn-primary" data-toggle="modal" id="btnnuevo">
               <span class="glyphicon glyphicon-plus"></span> Agregar pendiente
           </button>
      </div>
      </div>
      <div class="table-responsive">
          
          <table class="table table-hover row-border dt-responsive" width="100%" id="tblpendiente">
              <thead style="background: #337ab7;color: #FFF;">
                  <tr>
                    <th style="width: 1%"></th>
                    <th style="width: 50%">Pendiente</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if(!empty($content))
                        $usuario="";
                        foreach($content as $element):
                            
                            if($element[6] !=$usuario){
                                echo '<tr style="background-color:black;color:white" id="'.$element[6].'"><td></td><td>'.$element[6].'</td><td></td><td></td><td></td><td></td></tr>';
                                $usuario=$element[6];
                            }
                            
                ?>
                  
                  <tr id="<?php echo $element[0]; ?>" style="background-color:<?php echo $element[7] ?> ">
                      <td>
                        <?php echo $element[5]=='URGENTE' ?  '<button type="button" class="btn btn-danger btn-circle"><span class="glyphicon glyphicon-alert"></span></button>' : ''
                        ?>  
                        
                      </td>
                      <td><?php echo $element[1]; ?>   </td>
                      <td><?php echo $element[2]; ?>   </td>
                      <td><?php echo $element[3]; ?>   </td>
                      <td><?php if($element[4]=='REVISAR') 
                          echo '<button type="button" disabled="true" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="left" title="" data-original-title="Revisar"><span class="glyphicon glyphicon-alert"></span>
                            </button>';
                        else if($element[4]=='PENDIENTE')
                           echo '<button type="button" disabled="true" class="btn btn-primary btn-circle" data-toggle="tooltip" data-placement="left" title="" data-original-title="Pendiente"><span class="glyphicon glyphicon-paperclip"></span>
                            </button>';
                        else if($element[4]=='REVISAR2')
                           echo '<button type="button" disabled="true" class="btn btn-success btn-circle" data-toggle="tooltip" data-placement="left" title="" data-original-title="Pendiente"><i class="fa fa-flag"></i>
                            </button>';
                      
                      ?></td>
                      <td>
                          <div class="btn-group" role="group" aria-label="..." id="<?php echo $element[0]; ?>">
                              <button type="button" class="btn btn-primary" id="btnok">
                                  <span class="glyphicon glyphicon-ok"></span>
                              </button>
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
</div>

<?php include 'nuevo.php'; ?>

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
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/admin/pendientes.js"></script>

<script type="text/javascript">
    var url_nuevopendiente='<?php echo site_url($this->package.'/pendientes/nuevopendiente'); ?>';
    var url_obtenerpendiente='<?php echo site_url($this->package.'/pendientes/obtener_pendiente'); ?>';
    var url_editarpendiente='<?php echo site_url($this->package.'/pendientes/editarpendiente'); ?>';
    var url_eliminarpendiente='<?php echo site_url($this->package.'/pendientes/eliminarpendiente'); ?>';
    var urlusuarios='<?php echo site_url($this->package.'/usuarios/listado_usuarios'); ?>';
    var url_aprobarpendiente='<?php echo site_url($this->package.'/pendientes/aprobar_pendiente'); ?>';
    var url_obteneralarmas='<?php echo site_url($this->package.'/panel/buscar_alarmas'); ?>';
</script>