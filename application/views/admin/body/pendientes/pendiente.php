<div id="page-wrapper">
  <div class="row">
    <style>
    .page-header {
          margin: 15px;
     }
     .pre1{
         background-color: #f5f5f5;
         border: 1px solid #ccc;
         border-radius: 4px;
         padding: 10px;
     }
    </style>
    
        <div class="row" style="padding: 15px;">
            <div class="col-md-10">
                <h3 class="page-header">Listado de Todas las Alarmas</h3>
            </div>
        </div>
        <?php 

        if(isset($pend))
        {
            foreach($pend as $pen)
            {
        ?>
            <h2 class="page-header" style="color: red;font-style: italic;font-family: serif;">Pendiente # <?php echo $pen->id_pendiente; ?></h2>
            <div class="row" style="padding: 25px;">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="page-header" style="font-weight: 900;float: left;">Contenido</h4>
                            <button style="float: right;" type="button" class="btn btn-success btn-circle btn-lg" id="<?php echo $pen->id_pendiente; ?>"><i class="fa fa-check"></i></button>
                        </div>
                    
                    </div>
                    <p class="pre1"><?php echo $pen->cpdescripcion; ?> </p>  
                   <h4 class="page-header" style="font-weight: 900;">Fecha y Hora</h4>
                   <p><?php echo $pen->cpfecha."  ". $pen->cphora; ?> </p>
                   <h4 class="page-header" style="font-weight: 900;">Prioridad</h4>
                   <p><?php echo $pen->cpprioridad_pendiente; ?></p>
                 </div>
            </div>
            </div>
        <?php
            }
        }
       
        if(count($pend)==0)
        {
            echo '<div class="alert alert-info">
                     No existen alarmas para mostrar.
            </div>';
        }
        ?>
   
    </div>
</div>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/admin/alarmas.js"></script>
<script type="text/javascript">
   var url_aprobarpendiente='<?php echo site_url($this->package.'/pendientes/aprobar_pendiente'); ?>';
   var url_redirect='<?php echo site_url($this->package.'/pendientes'); ?>';
</script>
