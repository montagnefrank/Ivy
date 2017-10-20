<div id="page-wrapper">
      <div class="row">
      <div class="col-md-12">
          <h3 class="page-header">Listado de Facturas</h3>
      </div>
      
      </div>
      <div class="table-responsive">
          <table class="table table-striped row-border dt-responsive" cellspacing="0" width="100%" id="tblretencion">
              <thead>
                  <tr>
                      
                      <th>Num FAC</th>
                      <th>Cliente</th>
                      <th>Dirección</th>
                      <th>Teléfono</th>
                      <th>Celular</th>
                      <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if(!empty($retenciones))
                        foreach($retenciones as $element):
                ?>
                  <tr id="<?php echo $element->id_venta; ?>">
                        <?php
                            $num_1 = $element->cpnum1_venta;
                            $num_2 = $element->cpnum2_venta;
                            $numero_fac = $element->cpnumero_venta;
                            $fac_n = $element->id_venta;

                            $cedula= $element->cpcedula_cliente; 
                            $nombre= $element->cprazonsocial_cliente;
                            $direccion= $element->cpdireccion_cliente;
                            $telefono = $element->cptelefono_cliente;
                            $celular = $element->cpcelular_cliente;
                            $num_1 = $element->cpnum1_venta;
                            $num_2 = $element->cpnum2_venta;
                            $numero_fac = $element->cpnumero_venta;

                            $nnn=$num_1.$num_2.$numero_fac;
                        echo "<td width='12%'>".$num_1."-".$num_2."-".$numero_fac."</td>";
                        echo "<td>".$nombre."</td>";
                        echo "<td>".$direccion."</td>";
                        echo "<td>".$telefono."</td>";
                        echo "<td>".$celular."</td>";
                        
                    ?>
                <td>
                    <div class="btn-group tooltip-demo" role="group" aria-label="..." style="float: right">
                        <button type="button" class="btn btn-primary buscarRetencion" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Buscar" id="<?php echo $element->id_venta; ?>">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                           
                </div>
                    
                </td>
              </tr>
                 <?php  endforeach; ?>
            </tbody>
          </table>
          
      </div>
    <?php include 'mostrarform.php'; ?>
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
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/admin/retencion.js"></script>


<script type="text/javascript">
   var url_buscarretencion='<?php echo site_url($this->package.'/ventas/buscarRetencion'); ?>';
   var url_hacerretencion='<?php echo site_url($this->package.'/ventas/hacerRetencion'); ?>';
</script>