<div class="modal fade bs-example-modal-lg" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
        <form class="form-horizontal" id="form_retencion" method="post" action=""> 
        <div class="modal-body">
         
          <div class="table-responsive">
              <input id="id_venta" type="hidden" value="" />
           
              <form id="form1" name="form1" method="post" action="">
                 <div class="panel panel-default">
                     <div class="panel-body" id="panel1">
                        <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                              <label for="direccion" class="col-sm-4 control-label">Base</label>
                              <div class="col-sm-8">
                                  <input type="text" readonly="true" class="form-control" id="base" name="base" value="">
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                              <label for="direccion" class="col-sm-4 control-label">IVA</label>
                              <div class="col-sm-8">
                                  <input type="text" readonly="true" class="form-control" id="iva" name="iva" value="">
                              </div>
                            </div>
                       </div>
                         <div class="col-md-3"> 
                            <div class="form-group">
                              <label for="telefono" class="col-sm-5 control-label">Porcentaje</label>
                              <div class="col-sm-6">
                                 <select name="porcentaje" id="porcentaje" class="form-control">
                                         <option value="1" selected="selected">1</option>
                                         <option value="2">2</option>
                                         <option value="8">8</option>
                                         <option value="10">10</option>
                                         <option value="30">30</option>
                                         <option value="70">70</option>
                                         <option value="100">100</option>
                                         <option value="otro">Otro</option>
                                  </select>
                                  <input type="text" class="form-control" id="otro" name="otro" value="" style="display: none;">
                              </div>
                           </div>
                       </div>
                       <div class="col-md-3">
                         <input type="button" class="btn btn-primary" name="btnanadir" id="btnanadir" value="Añadir" />
                       </div>
                     </div>
                    </div>
                 </div>
               
                  <div id="tabla2" class="table-responsive">
                      <table class="table table-hover" id="tt" width="100%">
                        
                        <thead>
                          <th>Base</th>
                          <th>Impuesto</th>
                          <th>Retencion %</th>
                          <th>Valor Retenido</th>
                          <th>Quitar</th>
                       </thead>
                        <tbody>
                        </tbody>
                      </table>
                      
                  </div>
                
                  <div id="tabla3" style="margin-top:10px;" >
                      <div class="panel panel-default">
                     <div class="panel-body" id="panel1">
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="direccion" class="col-sm-4 control-label">Referencia (Num Fact)</label>
                              <div class="col-sm-8">
                                  <label class="col-sm-4 control-label" id="lnumfactura"></label>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="direccion" class="col-sm-4 control-label">Fecha Factura:</label>
                              <div class="col-sm-8">
                                  <label class="col-sm-4 control-label" id="lfechafactura"></label>
                              </div>
                            </div>
                       </div>
                         <div class="col-md-12"> 
                            <div class="form-group">
                              <label for="telefono" class="col-sm-4 control-label">No. Comprobate</label>
                              <div class="col-sm-3">
                                <input type="text" class="form-control" id="comp" name="comp">
                              </div>
                           </div>
                       </div>
                          
                       
                          
                      </div>
                    </div>
                      
                  </div>
                
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" id="btnfinalizar" class="btn btn-primary" >Finalizar Retención</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
     </div>
     </form>
  </div>
</div>