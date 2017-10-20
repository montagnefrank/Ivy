<div id="page-wrapper">
     <div class="row" style="padding: 20px;">
          <h3 class="page-header">Inicio</h3>
        </div>
    <div class="row" style="">
        <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check-square-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php if (isset($datos)) echo $datos['num_pend']; ?></div>
                                    <div>Total Pendientes</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url()?>admin/pendientes">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-support fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php if (isset($datos)) echo $datos['pend_venc']; ?></div>
                            <div>Pendientes a Vencerse</div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo base_url()?>admin/pendientes/obtener_todospendiente">
                    <div class="panel-footer">
                        <span class="pull-left">Ver Detalles</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
          <?php if($this->data["sesion"]["rol"]=='Administrador'){ ?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php if (isset($datos)) echo $datos['pend_cobro']; ?></div>
                                    <div>Facturas Pend. De Cobro</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url()?>admin/ventas/pendientes_cobro">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
          <?php } ?>
    </div>
</div>