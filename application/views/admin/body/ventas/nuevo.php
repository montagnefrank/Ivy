<div id="page-wrapper">
      <div class="row">
      <div class="col-md-10">
          <h3 class="page-header">Nueva Venta</h3>
      </div>
      
      </div>
      <form class="form-horizontal" id="form_nuevoventa" method="post" action=""> 
        <div class="modal-body">
                            
                <div class="row">
                    
                    <div class="col-md-4" style="float: right;">
                        <div class="form-group">
                          <label for="factura" class="col-sm-3 control-label">No Factura</label>
                          <div class="col-sm-9">
                              <input type="text" readonly="true" class="form-control" id="factura" name="factura" value="<?php echo $factura;?>">
                          </div>
                        </div>
                    </div>
                </div>
            
                <div class="panel panel-primary">
                        <div class="panel-heading">
                            Datos del Cliente
                            <button type="button" id="limpiarCliente" class="btn btn-warning" >Limpiar Cliente</button>
                        </div>
                        <div class="panel-body">
                            <div class="row">   
                                <div class="col-md-5">
                                    <div class="form-group">
                                      <label for="cliente" class="col-sm-4 control-label">Sr/Sra</label>
                                      <div class="col-sm-8">
                                          <select id="cliente" name="cliente" class="form-control select2-single" dir="ltr">
                                              <option value=""></option>
                                          </select>
                                          
                                      </div>
                                      
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                      <label for="cedula" class="col-sm-4 control-label">Cedula/Ruc</label>
                                      <div class="col-sm-8">
                                          <input type="text" readonly="true" class="form-control" id="cedula" name="cedula" value="<?php if(isset($codigo)) echo $codigo ?>" placeholder="Cédula">

                                      </div>
                                    </div>
                                </div>
                             </div>
                             <div class="row">  
                                <div class="col-md-5">
                                    <div class="form-group">
                                      <label for="direccion" class="col-sm-4 control-label">Dirección</label>
                                      <div class="col-sm-8">
                                          <input type="text" readonly="true" class="form-control" id="direccion" name="direccion" placeholder="Dirección">
                                      </div>
                                    </div>
                                </div>
                                 <div class="col-md-5">  
                                    <div class="form-group">
                                      <label for="telefono" class="col-sm-4 control-label">Teléfono</label>
                                      <div class="col-sm-8">
                                          <input type="text" readonly="true" class="form-control" id="telefono" name="telefono" placeholder="Teléfono">
                                      </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                        
                    </div>
            
            
                 
                
            <div class="col-md-4">
                <div class="row">
                   <div class="col-md-12">
                        <div class="form-group">
                            <label for="formapago" class="col-sm-4 control-label">Forma Pago</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="formapago" name="formapago">
                                    <option value="EFECTIVO">Efectivo</option>
                                    <option value="CHEQUE">Cheque</option>
                                    <option value="TRANSACCION">Transaccion</option>
                                    
                                </select>
                            </div>
                         </div>  
                    </div>
                    
               </div>
                <div class="row">
                    <div class="col-md-12">  
                    <div class="form-group">
                          <label for="femision" class="col-sm-4 control-label">Fecha Emisión*</label>
                          <div class="col-sm-8">
                          <div class="input-group date" id="datetimepicker1">
                              <input type="text" class="form-control" id="femision" name="femision" value="<?php echo date("Y-m-d"); ?>">
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                          </div>
                    </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12">  
                    <div class="form-group">
                          <label for="fpago" class="col-sm-4 control-label">Fecha Pago*</label>
                          <div class="col-sm-8">
                          <div class="input-group date" id="datetimepicker1">
                              <input type="text" class="form-control" id="fpago" name="fpago" value="<?php $fecha_inicio =  date("Y-m-d"); echo $fecha_final= date("Y-m-d", strtotime("$fecha_inicio + 5 days"));?>">
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                          </div>
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="comentario" class="col-sm-4 control-label">Observación</label>
                            <div class="col-sm-8">
                                <textarea rows="3" class="form-control" id="comentario" name="comentario" placeholder="Comentario"></textarea>
                            </div>
                        </div>
                    </div>
                     
                </div>
                <div class="row">
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="cantidad" class="col-sm-4 control-label">Cantidad*</label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad">
                          </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">  
                        <div class="form-group">
                          <label for="detalle" class="col-sm-4 control-label">Detalle*</label>
                          <div class="col-sm-8">
                              <select id="detalle" name="detalle" class="form-control select2-single" dir="ltr">
                                  <?php 
                                   if(isset($productos))
                                   {
                                       echo '<option value=""></option>';
                                       foreach($productos as $prod):
                                           
                                           echo '<option value="'.$prod->id_producto.'">'.$prod->cpnombre_producto.'</option>';
                                       endforeach;
                                   }
                                  
                                  
                                  ?>
                              </select>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="precio" class="col-sm-4 control-label">Precio Unitario*</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="precio" name="precio" placeholder="Precio Unitario">
                            </div>
                        </div>
                    </div>
                     
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cuenta" class="col-sm-4 control-label">Código*</label>
                            <div class="col-sm-8">
                                <input type="text" readonly="true" class="form-control" id="cuenta" name="cuenta" placeholder="Codigo del Producto">
                            </div>
                        </div>
                    </div>
                     
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" id="insertar" style="float: right"><span class="glyphicon glyphicon-floppy-disk"></span> Insertar Datos</button>
                    </div>
                     
                </div>
                <input type="hidden" id="id" name="id" value=""/>
            </div>
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-striped row-border dt-responsive" cellspacing="0" width="100%" id="tblorden">
                        <thead>
                            <tr>
                              <th>Cantidad</th>
                              <th>Descripcion</th>
                              <th>P.Unit</th>
                              <th>P.Total</th>
                              <th>Acciones</th>
                          </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Subtotal</th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>IVA 12%</th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Descuento</th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                          <?php 
                           if(isset($dexistentes))
                           {
                               foreach ($dexistentes as $row):
                                echo '<tr id="'.$row->id_auxc.'">
                                    <td>'.$row->cpcantidad_ax.'</td>
                                    <td>'.$row->cpdet_aux.'</td>
                                    <td>'.$row->cppu_aux.'</td>
                                    <td>'.$row->cppt_aux.'</td>
                                    <td><div class="btn-group" role="group" id="'.$row->id_auxc.'">'.
                                        '<button type="button" class="btn btn-primary" id="btneliminar">'.
                                            '<span class="glyphicon glyphicon-ban-circle"></span>'.
                                        '</button>'.
                                    '</div></td>
                                </tr> ';
                               endforeach;
                           }
                          
                          ?>
                      </tbody>
                    </table>

                </div>
                <div class="btn-group" role="group" aria-label="..." style="float: right">
                    <button type="button" class="btn btn-primary" id="registrar">
                        <span class="glyphicon glyphicon-print"></span> Registrar e Imprimir
                    </button>
                    <button type="button" class="btn btn-primary" id="cancelar">
                        <span class="glyphicon glyphicon-remove-sign"></span> Cancelar
                    </button>
                            
                </div>
                
                  
            </div>
                
      </div>
      
      </form>
</div>
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar Item</h4>
      </div>
        <div class="modal-body">
            <h4>¿Está seguro que desea eliminar este Item?</h4>
        </div>
        <input type="hidden" id="id_eliminar" name="id_eliminar" value=""/>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="eliminar">Eliminar</button>
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
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>public/js/admin/ventas.js"></script>


<script type="text/javascript">
   
    var url_insertar_tabla_temporal='<?php echo site_url($this->package.'/ventas/insertar_tabla_temporal'); ?>';
    var urlobtenerproducto='<?php echo site_url($this->package.'/ventas/obtener_detalle_producto'); ?>';
    var url_nuevoventas='<?php echo site_url($this->package.'/ventas/nuevoventas'); ?>';
    var url_buscarclientes='<?php echo site_url($this->package.'/clientes/buscarclientes'); ?>';
    var url_imprimir='<?php echo site_url($this->package.'/ventas/generar_pdf'); ?>';
     var url_cancelar='<?php echo site_url($this->package.'/ventas/cancelar'); ?>';
</script>