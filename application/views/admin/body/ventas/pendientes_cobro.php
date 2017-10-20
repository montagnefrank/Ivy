<div id="page-wrapper">
      <div class="row">
      <div class="col-md-12">
          <h3 class="page-header">Listado de Facturas</h3>
      </div>
      
      </div>
      <div class="table-responsive">
          <table class="table table-striped row-border dt-responsive" cellspacing="0" width="100%" id="tblfacturaventas">
              <thead>
                  <tr>
                      <th>Num FAC</th>
                      <th>Cliente</th>
                      <th>Dirección</th>
                      <th>Teléfono</th>
                      <th>Valor</th>
                      <th style="width: 12%">Acciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color:red;color: #FFF">Total</th>
                    <th style="background-color:red;color: #FFF"></th>
                    <th></th>
                </tr>
              </tfoot>
              <tbody>
                <?php
                    if(!empty($dfactura))
                        foreach($dfactura as $element):
                ?>
                  <tr id="<?php echo $element[0]; ?>">
                        <?php
                            
                            $nombre= $element[2];
                            $direccion= $element[3];
                            $telefono = $element[4];
                            $numero_fac = $element[1];
                            $valor = $element[6];

                        echo "<td width='12%'>".$numero_fac."</td>";
                        echo "<td>".$nombre."</td>";
                        echo "<td>".$direccion."</td>";
                        echo "<td>".$telefono."</td>";
                        echo "<td>".$valor."</td>";
                    ?>
                <td>
                    <div class="btn-group tooltip-demo" role="group" aria-label="..." style="float: right">
                        <button type="button" class="btn btn-primary buscarfactura" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Buscar" id="<?php echo $element[0]; ?>">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    <button type="button" class="btn btn-primary imprimirfactura" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir" id="<?php echo $element[0]; ?>">
                        <span class="glyphicon glyphicon-print"></span>
                    </button>                         
                </div>
                    
                </td>
              </tr>
                 <?php  endforeach; ?>
            </tbody>
          </table>
          
      </div>
    <?php include 'mostrarfactura.php'; ?>
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
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/admin/pendientecobro.js"></script>


<script type="text/javascript">
    var url_imprimir='<?php echo site_url($this->package.'/ventas/generar_pdf'); ?>';
    var url_buscarfactura='<?php echo site_url($this->package.'/ventas/buscarfactura'); ?>';
    var url_anularfactura='<?php echo site_url($this->package.'/ventas/anularfactura'); ?>';
    var url_pagar='<?php echo site_url($this->package.'/ventas/pagarfactura'); ?>';
</script>