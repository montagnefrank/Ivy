<div id="page-wrapper">
      <div class="row">
      <div class="col-md-12">
          <h3 class="page-header">Listado de Facturas</h3>
      </div>
      
      </div>
      <div class="table-responsive" style="height: ">
          <table class="table table-striped row-border dt-responsive" cellspacing="0" width="100%" id="tblfacturaventas">
              <thead>
                  <tr>
                      <th>Num FAC</th>
                      <th>Cliente</th>
                      <th>Dirección</th>
                      <th>Teléfono</th>
                      <th style="width: 12%">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if(!empty($factura_ventas))
                        foreach($factura_ventas as $element):
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
                        
                    ?>
                <td>
                    
                        <div class="btn-group tooltip-demo" role="group" aria-label="..." style="float: right">
                            <button type="button" class="btn btn-primary buscarfactura" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Buscar" id="<?php echo $element->id_venta; ?>">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                        <button type="button" class="btn btn-primary imprimirfactura" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir" id="<?php echo $element->id_venta; ?>">
                            <span class="glyphicon glyphicon-print"></span>
                        </button>
                        <button type="button" class="btn btn-primary anularfactura" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Anular" id="<?php echo $element->id_venta; ?>">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>    
                    </div>
                    
                    </div >
                    
                </td>
              </tr>
                 <?php  endforeach; ?>
            </tbody>
          </table>
          
      </div>
    <?php include 'mostrarfactura.php'; ?>
</div>
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Anular Factura</h4>
      </div>
        <div class="modal-body">
            <h4>¿Está seguro que desea anular esta factura?</h4>
        </div>
        <input type="hidden" id="id_eliminar" name="id_eliminar" value=""/>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="eliminar">Anular</button>
      </div>
    </div>
  </div>
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
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/admin/reporte_ventas.js"></script>


<script type="text/javascript">
    var url_imprimir='<?php echo site_url($this->package.'/ventas/generar_pdf'); ?>';
    var url_buscarfactura='<?php echo site_url($this->package.'/ventas/buscarfactura'); ?>';
    var url_anularfactura='<?php echo site_url($this->package.'/ventas/anularfactura'); ?>';
</script>