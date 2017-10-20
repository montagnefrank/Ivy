<div id="page-wrapper">
    
    <div class="row" style="padding: 15px;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong> Datos de búsqueda</strong>
        </div>
        <div class="panel-body">
            <form class="" id="form_porCliente" method="post" action="<?php echo site_url($this->package.'/ventas/porCliente/buscar'); ?>"> 
             <div class="row">
                    <div class="col-md-3">  
                    <div class="form-group">
                          <label for="finicio" class="col-sm-8 control-label">Fecha Inicio</label>
                          <div class="col-sm-12">
                          <div class="input-group date" id="datetimepicker1">
                              <input type="text" class="form-control" id="finicio" name="finicio">
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                          </div>
                    </div>
                    </div>
                
                    <div class="col-md-3">  
                    <div class="form-group">
                          <label for="ffin" class="col-sm-8 control-label">Fecha Fin</label>
                          <div class="col-sm-12">
                          <div class="input-group date" id="datetimepicker1">
                              <input type="text" class="form-control" id="ffin" name="ffin" value="">
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                          </div>
                    </div>
                    </div>
                 <div class="col-md-3">  
                        <div class="form-group">
                          <label for="detalle" class="col-sm-8 control-label">Plan de Cuentas</label>
                          <div class="col-sm-12">
                              <select id="plan" name="plan" class="form-control select2-single" dir="ltr">
                                  <?php 
                                   if(isset($plan))
                                   {
                                       echo '<option value=""></option>';
                                       foreach($plan as $p):
                                           
                                           echo '<option value="'.$p->cpcodigo_plancuentas.'">'.$p->cpdescripcion_plancuentas.'</option>';
                                       endforeach;
                                   }
                                  
                                  
                                  ?>
                              </select>
                          </div>
                        </div>
                    </div>
                 <div class="col-md-3" style="padding-top: 25px;"> 
                     <button type="submit" class="btn btn-primary" id="buscar" >
                                <span class="glyphicon glyphicon-search"></span> Buscar
                            </button> 
                 </div>
        </div>
            </form>
    </div>    
    </div>
    </div>
    <?php if(isset($reporte)) { ?>  
      <div class="row">
      <div class="col-md-12">
          <h3 class="page-header">Reporte Ventas por Cliente</h3>
      </div>
      
      </div>
      <div class="table-responsive">
          <table class="table table-striped row-border dt-responsive" cellspacing="0" width="100%" id="tblReporteporFactura">
              <thead>
                  <tr>
                      <th><strong>Num Factura</strong></th>
                      <th><strong>Fecha</strong></th>
                      <th><strong>Cliente</strong></th>
                      <th><strong>Subtotal</strong></th>
                      <th><strong>Iva</strong></th>
                      <th><strong>Valor Total</strong></th>
                </tr>
              </thead>
              <tfoot>
                  <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th>Total</th>
                      <th></th>
                </tr>
              </tfoot>
              <tbody>
                <?php 
                    for($i=0;$i< count($reporte);$i++){
                ?>
                        <tr>
                              <?php
                                
                              echo "<td>".$reporte[$i][0]."</td>";
                              echo "<td>".$reporte[$i][1]."</td>";
                              echo "<td>".$reporte[$i][2]."</td>";
                              echo "<td>".$reporte[$i][3]."</td>";
                              echo "<td>".$reporte[$i][4]."</td>";
                              echo "<td>".$reporte[$i][5]."</td>";
                              

                          ?>

                    </tr>
                    <?php  } ?>
            </tbody>
          </table>
          
      </div>
    <?php } ?>
</div>



<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/css/bootstrap-datetimepicker.min.css"  media="all"  />
<link href="<?php echo base_url()?>public/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/css/select2-bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css"  media="all"  />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/css/buttons.dataTables.min.css"  media="all"  />

<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/dataTables.bootstrap.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/dataTables.responsive.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/responsive.jqueryui.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url()?>public/js/moment.js"></script>
<script src="<?php echo base_url()?>public/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/buttons.colVis.min.js"></script>

<script src="<?php echo base_url()?>public/js/select2.full.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/admin/ReporteporFactura.js"></script>