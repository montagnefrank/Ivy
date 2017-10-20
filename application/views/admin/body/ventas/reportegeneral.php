<div id="page-wrapper">
    <div class="row" style="padding: 15px;">
    <div class="panel panel-default">
        <div class="panel-heading">
          <strong> Datos de búsqueda</strong>
        </div>
        <div class="panel-body">
            <form class="" id="form_general" method="post" action="<?php echo site_url($this->package.'/ventas/reporteGeneral/buscar'); ?>"> 
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
        <a class="btn btn-primary botonExcel" href="#" role="button" style="float:right"><span class="fa fa-file-excel-o"></span> Descargar Excel</a>
    </div>
        
    <form action="<?php echo base_url()?>admin/ventas/descargarexcell" method="post" target="_blank" id="FormularioExportacion">
      <div class="row">
        <div class="col-md-12">
            <h3 class="page-header">Reporte Compras</h3>
        </div>
      </div>
      <div class="table-responsive">
          <table class="table table-striped row-border dt-responsive" cellspacing="0" width="100%" id="tblcompras">
              <thead>
                  <tr>
                      <th><strong>Num Factura</strong></th>
                      <th><strong>Fecha</strong></th>
                      <th><strong>Cliente</strong></th>
                      <th><strong>Subtotal</strong></th>
                      <th><strong>Iva 0%</strong></th>
                      <th><strong>Iva 12%</strong></th>
                      <th><strong>Valor Total</strong></th>
                </tr>
              </thead>
              
              
              <tbody>
                <?php  
                    for($i=0;$i< count($reporte[0]);$i++){
                ?>
                        <tr>
                              <?php
                                
                              echo "<td>".$reporte[0][$i][0]."</td>";
                              echo "<td>".$reporte[0][$i][1]."</td>";
                              echo "<td>".$reporte[0][$i][2]."</td>";
                              echo "<td>".$reporte[0][$i][3]."</td>";
                              echo "<td>".$reporte[0][$i][4]."</td>";
                              echo "<td>".$reporte[0][$i][5]."</td>";
                              echo "<td>".$reporte[0][$i][6]."</td>";
                         ?>

                    </tr>
                    <?php  } ?>
            </tbody>
          </table>
          
      </div>
    
      <div class="row">
        <div class="col-md-12">
            <h3 class="page-header">Reporte Ventas</h3>
        </div>
      
      </div>
      <div class="table-responsive">
          <table class="table table-striped row-border dt-responsive" cellspacing="0" width="100%" id="tblventas">
              <thead>
                  <tr>
                      <th>Num Factura</th>
                      <th style="width: 8%">Fecha</th>
                      <th>Cliente</th>
                      <th>Subtotal</th>
                      <th>Iva</th>
                      <th>Total</th>
                      <th>Impuesto</th>
                      <th>Porcentaje</th>
                      <th>Valor</th>
                      <th>Impuesto</th>
                      <th>Porcentaje</th>
                      <th>Valor</th>
                </tr>
              </thead>
              <tfoot>
                  <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                </tr>
              </tfoot>
              <tbody>
                <?php 
                    for($i=0;$i< count($reporte[1]);$i++){
                ?>
                        <tr>
                              <?php
                                
                              echo "<td bgcolor='".$reporte[1][$i][12]."' style='color:".$reporte[1][$i][13]."'>".$reporte[1][$i][0]."</td>";
                              echo "<td bgcolor='".$reporte[1][$i][12]."' style='color:".$reporte[1][$i][13]."'>".$reporte[1][$i][1]."</td>";
                              echo "<td bgcolor='".$reporte[1][$i][12]."' style='color:".$reporte[1][$i][13]."'>".$reporte[1][$i][2]."</td>";
                              echo "<td bgcolor='".$reporte[1][$i][12]."' style='color:".$reporte[1][$i][13]."'>".$reporte[1][$i][3]."</td>";
                              echo "<td bgcolor='".$reporte[1][$i][12]."' style='color:".$reporte[1][$i][13]."'>".$reporte[1][$i][4]."</td>";
                              echo "<td bgcolor='".$reporte[1][$i][12]."' style='color:".$reporte[1][$i][13]."'>".$reporte[1][$i][5]."</td>";
                              echo "<td bgcolor='".$reporte[1][$i][12]."' style='color:".$reporte[1][$i][13]."'>".$reporte[1][$i][6]."</td>";
                              echo "<td bgcolor='".$reporte[1][$i][12]."' style='color:".$reporte[1][$i][13]."'>".$reporte[1][$i][7]."</td>";
                              echo "<td bgcolor='".$reporte[1][$i][12]."' style='color:".$reporte[1][$i][13]."'>".$reporte[1][$i][8]."</td>";
                              echo "<td bgcolor='".$reporte[1][$i][12]."' style='color:".$reporte[1][$i][13]."'>".$reporte[1][$i][9]."</td>";
                              echo "<td bgcolor='".$reporte[1][$i][12]."' style='color:".$reporte[1][$i][13]."'>".$reporte[1][$i][10]."</td>";
                              echo "<td bgcolor='".$reporte[1][$i][12]."' style='color:".$reporte[1][$i][13]."'>".$reporte[1][$i][11]."</td>";
                             
                         ?>

                    </tr>
                    <?php  } ?>
            </tbody>
          </table>
          
      </div>
        <input type="hidden" id="finicio" name="finicio" value="<?php if(isset($finicio)) echo $finicio  ?>"/>
        <input type="hidden" id="ffin" name="ffin" value="<?php if(isset($ffin)) echo $ffin   ?>"/>
    </form>
    
    <?php } ?>
</div>



<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/css/bootstrap-datetimepicker.min.css"  media="all"  />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css"  media="all"  />

<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/dataTables.bootstrap.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/dataTables.responsive.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/responsive.jqueryui.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url()?>public/js/moment.js"></script>
<script src="<?php echo base_url()?>public/js/bootstrap-datetimepicker.min.js"></script>


<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/admin/ReporteGeneral.js"></script>