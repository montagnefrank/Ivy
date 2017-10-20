<div class="modal fade bs-example-modal-lg" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
        <form class="form-horizontal" id="form_nuevocliente" method="post" action=""> 
        <div class="modal-body">
         
          <div class="table-responsive">
              <input id="id_venta" type="hidden" value="" />
           
              <form id="form1" name="form1" method="post" action="">
                <div id="tabla1"></div>
                </br>
                </br>
                
                <div id="tabla2"></div>
                </br>
                <div id="tabla3"></div>
              
              </form>
              </br>
              </br>
              
              <form class="form-horizontal" id="form_efectuado" method="post" action="" style="display: none"> 
              <div class="panel panel-default">
                        <div class="panel-heading">
                            Datos del pago
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label for="efectuado" class="col-sm-4 control-label">EFECTUADO CON </label>
                                  <div class="col-sm-4">
                                      <select id="efectuado" name="efectuado" class="form-control select2-single" dir="ltr">
                                          <option value=""></option>
                                          <option value="EFECTIVO">EFECTIVO</option>
                                          <option value="CHEQUE">CHEQUE</option>
                                          <option value="TRANSACCION">TRANSACCION</option>
                                      </select>
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="divnumero" style="display: none;">
                                <div class="form-group">
                                  <label for="numero" class="col-sm-4 control-label">No. </label>
                                  <div class="col-sm-4">
                                      <input type="text" class="form-control" id="numero" name="numero" value="" placeholder="Número">
                                  </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
             </form>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="realizarpago" style="display: none">Realizar Pago</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </form>
    </div>
  </div>
</div>