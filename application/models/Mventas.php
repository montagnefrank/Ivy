<?php
/**
* Modelo de Inicio de sesión
* */
class mventas extends CI_Model{ 
    var $table  = "tblcliente";
    
    function __construct()
    {
        parent::__construct();
    }

    
    public function get_ventas(){
        $query ="SELECT tblcliente.* FROM tblcliente where cpestado_cliente='ACTIVO' ORDER BY id_cliente";
        $res = $this->db->query($query);
	return array("content"=>$res->result());
    }
    
       
    public function obtenerventas($id)
    {
        $result=array();
        $query = $this->db->get_where($this->table,array("id_cliente"=>$id));
        $result['datos']=$query->result();
        return $result;
    }
    
   //esta funcion agrega en tabla temporal datos de la nueva venta
     public function insertar_tabla_temporal(){
        
        $cantidad=$this->input->post('cantidad');
        $id_producto=$this->input->post('detalle');
        $unitario=$this->input->post('precio');
        $total= $cantidad*$unitario;

        $query="select cpdescripcion_producto,cpcodigo_producto from tblproducto where id_producto='$id_producto';";
        $res = $this->db->query($query);
        $descripcion_producto=$res->row()->cpdescripcion_producto;
        $cuenta=$res->row()->cpcodigo_producto;
                
        $query="INSERT INTO tbaux_ven(cpcantidad_ax, cpdet_aux,  cppu_aux, cppt_aux, cpdescripcion_cuenta)VALUE ('$cantidad',  '$descripcion_producto',  '$unitario', '$total' , '$cuenta');";
	$res = $this->db->query($query);
	$id_insertado=$this->db->insert_id();
        
	//formo el array con los valores a devolver
        $this->db->select('tbaux_ven.*');
        $this->db->from('tbaux_ven');
        $this->db->where('tbaux_ven.id_auxc', $id_insertado);
        $query = $this->db->get();

        return $query->result();
    }
    
    public function nuevoventas()
    {
       $resultado=array(); 
       
        
        $iva=$this->input->post('iva');
        $total=$this->input->post('tgeneral');
        $subtotal=$this->input->post('subtotal');
        $comentario=$this->input->post('comentario'); 
	 
        $sql_u="select max(id_venta) as id_venta from tblfactura_venta";
        $res = $this->db->query($sql_u);	
        $facven_id=$res->row()->id_venta +1;
	
        
        $fecha_actual=$this->input->post('femision');
        $fecha_pago=$this->input->post('fpago');
        $vendedor="BURTON TECH - 3050254329001";
        $descuento="0";
        $estado="PENDIENTE";
        $pago=$this->input->post('formapago');
        
//        $num111=explode('-',$this->input->post('factura'));
//        $num222=explode('-',$this->input->post('factura'));
//        $numfacturero=explode('-',$this->input->post('factura'));
        
        $num111=explode('-',$this->input->post('factura'));
        $num111= $num111[0];
        $num222=explode('-',$this->input->post('factura'));
        $num222= $num222[1];
        $numfacturero=explode('-',$this->input->post('factura'));
        $numfacturero= $numfacturero[2];
	
        $cedula=$this->input->post('cedula');
        $sqlconsulta="SELECT id_cliente, cpcedula_cliente, cprazonsocial_cliente, cpdireccion_cliente , cptelefono_cliente FROM tblcliente WHERE cpcedula_cliente='".$cedula."'";
	$res=$this->db->query($sqlconsulta);
        $id_cliente=$res->row()->id_cliente;
	 
	 #Ingresar en la tabla factura
	$sql_fac="INSERT INTO tblfactura_venta(id_venta, cpnum1_venta, cpnum2_venta, cpnumero_venta, cpfecha_venta, cpfechapag_venta, cpvendedor_venta,
                  cpformpag_venta, cpsubtotal_ventas, cpiva_ventas, cpdescuento_ventas, cptotal_ventas, idcliente_venta, cpestado_factura,comentario) 
                  VALUE ('$facven_id', '$num111', '$num222', '$numfacturero', '$fecha_actual', '$fecha_pago', '$vendedor', '$pago', '$subtotal',
                  '$iva', '$descuento', '$total', '$id_cliente', '$estado', '$comentario');";
	
        $eje_correc=$this->db->query($sql_fac);
        
       
        $tblfac="select * from tbaux_ven";
        $res=$this->db->query($tblfac);
        
        foreach($res->result() as $row) {
            $cant=$row->cpcantidad_ax;
            $deta=$row->cpdet_aux;
            $prec=$row->cppu_aux;
            $descipcuenta=$row->cpdescripcion_cuenta;
            $tota=$row->cppt_aux;
            
            $sql_insert="INSERT INTO tbldetalleventas( cpcantidad, cpdetalle, cpprecio_u,cppreciototal,idventa_detalles, cpplancuentas)
                         VALUE ( '$cant', '$deta', '$prec', '$tota', ' $facven_id', '$descipcuenta');";
            $this->db->query($sql_insert);

            #consultar producto
            $sql_consultar_producto="SELECT cpstock_producto FROM tblproducto where cpcodigo_producto='$descipcuenta';";
            $ejecutar_producto=$this->db->query($sql_consultar_producto);
            $disponible=$ejecutar_producto->row()->cpstock_producto;
         

            $residuo=$disponible-$cant;
            #actualizar datos de productos
            $sql_actualizar="UPDATE tblproducto SET cpstock_producto = '$residuo' WHERE cpcodigo_producto = '$descipcuenta';";
            $this->db->query($sql_actualizar);

        }


        $deletable="truncate table tbaux_ven";
        $res1=$this->db->query($deletable);
        
        return $facven_id;
    }
    
    //elimino las ventas en la tabla tbaux_ven
    public function cancelarventas()
    {
        $id=$this->input->post('id');
        
        if($id!='todos'){
            $deletable="DELETE FROM tbaux_ven WHERE id_auxc='".$id."'";
            $res1=$this->db->query($deletable);
        }
        else if($id=='todos'){
            $deletable="DELETE FROM tbaux_ven";
            $res1=$this->db->query($deletable);
            $deletable="truncate table tbaux_ven";
            $res1=$this->db->query($deletable);
        }
      
        return;
    }
 
    //buscar listado de todos los productos
    public function buscar_productos()
    {
        $query = 'SELECT  tblproducto.*  FROM tblproducto ';
        $res = $this->db->query($query);
        return $res->result();
    }
    
    //obtener detalles de un producto por su id
    public function obtener_detalle_producto($id)
    {
        $this->db->select('tblproducto.*');
        $this->db->from('tblproducto');
        $this->db->where('tblproducto.id_producto', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    //obtener 
    public function datosExistentes()
    {
        $query = 'SELECT tbaux_ven.*  FROM tbaux_ven ';
        $res = $this->db->query($query);
        return $res->result();
    }
    
    public function numerofactura()
    {
        $sql1="SELECT id_venta, cpnum1_venta, cpnum2_venta, cpnumero_venta FROM tblfactura_venta ORDER BY id_venta DESC limit 1;";
        $res = $this->db->query($sql1);
        
        $id_num=$res->row()->id_venta;
        $num1=$res->row()->cpnum1_venta;
        $num2=$res->row()->cpnum2_venta;
        $numfac=$res->row()->cpnumero_venta;
		
	$num11=(int)$num1;
	$num22=(int)$num2;
	$num33=(int)$numfac+1;
	
	$num11=1;
	if($num2<1)
	$num22=1;
	
	if($num11>=0 && $num11<10)
		$num111="00".$num11;
	if($num11>=10 && $num11<100)
		$num111="0".$num11;
	if($num11>=100 && $num11<1000)
		$num111=$num11;
        
	if($num22>=0 && $num22<10)
		$num222="00".$num22;
	if($num22>=10 && $num22<100)
		$num222="0".$num22;
	if($num22>=100 && $num22<1000)
		$num222=$num22;
		
	if($num33>0 && $num33<10)
		$num333="000000".$num33;
	if($num33>=10 && $num33<100)
		$num333="00000".$num33;
	if($num33>=100 && $num33<1000)
		$num333="0000".$num33;
	if($num33>=1000 && $num33<10000)
		$num333="000".$num33;
	if($num33>=10000 && $num33<100000)
		$num333="00".$num33;
	if($num33>=100000 && $num33<1000000)
		$num333="0".$num33;
	if($num33>=1000000 && $num33<10000000)
		$num333="".$num33;
        
        
        return $num111."-".$num222."-".$num333;
    }
    
    public function obtenerDatosFactura($id)
    {
        $resultado=array();
        //obteniendo datos del cliente
        //selecciono la ultima factura insertada
        $query = "SELECT
                tbldetalleventas.cpcantidad,
                tbldetalleventas.cpdetalle,
                tbldetalleventas.cpprecio_u,
                tbldetalleventas.cppreciototal,
                tblfactura_venta.idcliente_venta,
                tblfactura_venta.cpfecha_venta,
                tblfactura_venta.cpfechapag_venta,
                tblfactura_venta.cpsubtotal_ventas,
                tblfactura_venta.cpiva_ventas,
                tblfactura_venta.cptotal_ventas,
                tblfactura_venta.comentario
                FROM
                tblfactura_venta
                INNER JOIN tbldetalleventas ON tbldetalleventas.idventa_detalles = tblfactura_venta.id_venta
                where cpestado_factura='PENDIENTE' 
                ";
        if($id!="")
        {
          $query.=" AND tblfactura_venta.id_venta='".$id."'";  
        }
        else
        {
           $query.=" and tblfactura_venta.id_venta=(SELECT MAX(tblfactura_venta.id_venta) FROM tblfactura_venta)";
        }
        $res = $this->db->query($query);
        return $res->result();
        
        
    }
    
    public function obtenerDatosClienteFactura($id)
    {
        $query = "SELECT
                tblcliente.cpcedula_cliente,
                tblcliente.cprazonsocial_cliente,
                tblcliente.cpdireccion_cliente,
                tblcliente.cptelefono_cliente,
                tblcliente.cpcelular_cliente
                FROM
                tblfactura_venta
                INNER JOIN tblcliente ON tblcliente.id_cliente = tblfactura_venta.idcliente_venta";
        if($id!="")
        {
          $query.=" where tblfactura_venta.id_venta='".$id."'";  
        }
        else
        {
           $query.=" where tblfactura_venta.id_venta=(SELECT MAX(tblfactura_venta.id_venta) FROM tblfactura_venta)";
        }
        $res = $this->db->query($query);
        return $res->result();
    }
    
    
    ////////////////////////////
    ////REPORTES DE FACTURAS////
    //REPORTE DE FACTURA VENTAS
    public function factura_ventas()
    {
        $query = "Select id_venta, cpcedula_cliente, cprazonsocial_cliente, cpdireccion_cliente, cptelefono_cliente,
                 cpcelular_cliente, cpnum1_venta, cpnum2_venta, cpnumero_venta
                 FROM tblfactura_venta, tblcliente where idcliente_venta=id_cliente
                 order by(concat(cpnum1_venta,cpnum2_venta, cpnumero_venta))";
        $res = $this->db->query($query);
        return $res->result();
    }
    
    public function buscarfactura()
    {
        $resultado=array();
        $id_venta=$this->input->post('id_venta');
        $query = "SELECT
                tblcliente.cpcedula_cliente,
                tblcliente.cprazonsocial_cliente,
                tblcliente.cpdireccion_cliente,
                tblcliente.cptelefono_cliente,
                tblfactura_venta.cpnum1_venta,
                tblfactura_venta.cpnum2_venta,
                tblfactura_venta.cpnumero_venta,
                tblfactura_venta.cpfecha_venta
                FROM
                tblfactura_venta
                INNER JOIN tblcliente ON tblcliente.id_cliente = tblfactura_venta.idcliente_venta
                WHERE
                tblfactura_venta.id_venta='$id_venta'";
        $res = $this->db->query($query);
        $resultado['dcliente']=$res->result();
        
        $query = "SELECT cpcantidad,  cpdetalle,  cpprecio_u,  cppreciototal,  idcliente_venta FROM tbldetalleventas, tblfactura_venta, tblcliente
                    where  idventa_detalles = id_venta and idcliente_venta = id_cliente and id_venta='$id_venta'";
        $res = $this->db->query($query);
        $resultado['dfactura']=$res->result();
    
        $query = "SELECT
                tblfactura_venta.cpsubtotal_ventas,
                tblfactura_venta.cpiva_ventas,
                tblfactura_venta.cptotal_ventas,
                tblfactura_venta.comentario
                FROM
                tblfactura_venta
                WHERE
                tblfactura_venta.id_venta ='$id_venta'";
        $res = $this->db->query($query);
        $resultado['totales']=$res->result();
        
        return $resultado;
    }
    
     public function anularfactura()
    {
        $id_venta=$this->input->post('id_venta');
        $query = "UPDATE tblfactura_venta SET tblfactura_venta.cpsubtotal_ventas='0',
                        tblfactura_venta.cpiva_ventas='0',
                        tblfactura_venta.cpdescuento_ventas='0',
                        tblfactura_venta.cptotal_ventas='0',
                        tblfactura_venta.idcliente_venta = '14',
                        tblfactura_venta.cpestado_factura='ANULADO',
                        tblfactura_venta.cpretencion_factura='ANULADO'
                WHERE
                tblfactura_venta.id_venta='$id_venta'";
        
        $res = $this->db->query($query);
        return;
    }
    
    public function obtenerPendientesCobro()
    {
        $resultado=array();
        $datos=array();
        $i=0;
        $query = "Select id_venta, cprazonsocial_cliente, cpdireccion_cliente, cptelefono_cliente, cpnum1_venta, cpnum2_venta, cpnumero_venta, cptotal_ventas, cpretencion_factura
                FROM tblfactura_venta, tblcliente
                WHERE  idcliente_venta=id_cliente and  cpestado_factura='PENDIENTE'";
        $res = $this->db->query($query);
        foreach($res->result() as $row)
        {
            $ventas = $row->cptotal_ventas;
            $retencion = $row->cpretencion_factura;
            
            if($retencion !="SIN RETENCION"){
                $consultar="SELECT d.id_retencion, base_retencion,Impuesto_retencion,porcentaje_retencion,cpvalor_retencion,idretencion_detalle
                         FROM tbldetalle_retencion d, tblretencion r, tblfactura_venta v
                         WHERE r.id_retencion=d.idretencion_detalle and idfactura_retencion =id_venta and id_venta = '".$row->id_venta."'";
                $res1 = $this->db->query($consultar);
                foreach($res1->result() as $row1)
                {
                        $iva=$row1->cpvalor_retencion;
                        $renta=$row1->cpvalor_retencion;
                }
                $ventas=$ventas-($iva+$renta);
            }
            
            $resultado[0]=$row->id_venta;
            $resultado[1]=$row->cpnum1_venta."-".$row->cpnum2_venta."-".$row->cpnumero_venta;
            $resultado[2]=$row->cprazonsocial_cliente;
            $resultado[3]=$row->cpdireccion_cliente;
            $resultado[4]=$row->cptelefono_cliente;
            $resultado[5]=$row->cptotal_ventas;
            $resultado[6]=$ventas;
            $datos[$i++]=$resultado;
        }
        return $datos;
    }
    
    public function pagarfactura()
    {
        $id=$this->input->post('id_venta');
        $pagado=$this->input->post('pagado');
        $numero=$this->input->post('numero');
        
        $query = "UPDATE tblfactura_venta  SET  cpestado_factura = 'PAGADO', efectuado_con='".$pagado."',numero_cheque='".$numero."' WHERE id_venta = '$id'";
        $res = $this->db->query($query);
        return;
    }
       
    public function plandecuentas()
    {
        $query="select * from tblplancuentas WHERE cpcodigo_plancuentas LIKE '%1.1.2.1.%'";
        $res = $this->db->query($query);
        return $res->result();
    }
    
    public function ReporteporFactura()
    {
        $fecha_inicio=$this->input->post('finicio');
        $fecha_fin=$this->input->post('ffin');
        $plan=$this->input->post('plan');
        
        $datos=array();
        $resultado=array();
        $i=0;
        $sql_factura="SELECT id_venta, cpnum1_venta, cpnum2_venta, cpnumero_venta, cpfecha_venta, cpsubtotal_ventas, cpiva_ventas, cptotal_ventas "
                . "FROM tblfactura_venta WHERE cpfecha_venta order by (cpnumero_venta)";
        
        $res = $this->db->query($sql_factura);
        foreach ($res->result() as $row){
            
                $fecha_venta=$row->cpfecha_venta;
               
                $idventas=$row->id_venta;
                $nuemrofcaturero=$row->cpnum1_venta."-".$row->cpnum2_venta."-".$row->cpnumero_venta;
                
                
                
                
                $segundos=strtotime($fecha_venta) - strtotime($fecha_inicio);
                $fechas_empiezo=intval($segundos/60/60/24);
                
                $segundos=strtotime($fecha_venta) - strtotime($fecha_fin);
                $fechas_terminar=intval($segundos/60/60/24);
                
                
                
               
                if($fechas_empiezo>=0 && $fechas_terminar<=0) {

                    $sql_consulta="SELECT id_ventas, cpcantidad, cpdetalle, cpprecio_u, cppreciototal, idventa_detalles, cpplancuentas FROM tbldetalleventas where id_ventas='$idventas'";
                    
                    if($plan !="")
                    {
                        $sql_consulta.= " AND cpplancuentas='$plan'"; 
                    }
                    
                    $res1 = $this->db->query($sql_consulta);
                    
                    foreach ($res1->result() as $fila){

                        $cpdetalle=$fila->cpdetalle;
                        $cpprecio=$fila->cpprecio_u;
                        $cpcantidad=$fila->cpcantidad;
                        $cppreciot=$fila->cppreciototal;
                                                
                        $datos[0]=$nuemrofcaturero;
                        $datos[1]=$fecha_venta;
                        $datos[2]=$cpdetalle;
                        $datos[3]=$cpcantidad;
                        $datos[4]=$cpprecio;
                        $datos[5]=$cppreciot;
                        $resultado[$i++]=$datos;
                    }
                }
        }
        
        return $resultado;
    }
    
   public function ReportePorCliente()
    {
        $fecha_inicio=$this->input->post('finicio');
        $fecha_fin=$this->input->post('ffin');
        $plan=$this->input->post('plan');
        
        $datos=array();
        $resultado=array();
        $i=0;
        $sql_factura="SELECT cpnum1_venta, cpnum2_venta, cpnumero_venta, cprazonsocial_cliente,  cpfecha_venta, cpsubtotal_ventas, cpiva_ventas, cptotal_ventas,  cpestado_factura, cpretencion_factura"
                . " FROM tblfactura_venta, tblcliente where id_cliente = idcliente_venta and cpcodigoplan_cliente='".$plan."'";
        
        $res = $this->db->query($sql_factura);
        foreach ($res->result() as $row){
            
                $fecha_venta=$row->cpfecha_venta;
                $nuemrofcaturero=$row->cpnum1_venta."-".$row->cpnum2_venta."-".$row->cpnumero_venta;
                $segundos=strtotime($fecha_venta) - strtotime($fecha_inicio);
                $fechas_empiezo=intval($segundos/60/60/24);
                $segundos=strtotime($fecha_venta) - strtotime($fecha_fin);
                $fechas_terminar=intval($segundos/60/60/24);
                
                if($fechas_empiezo>=0 && $fechas_terminar<=0) {	
                    $cliente=$row->cprazonsocial_cliente;
                    $cpsubtotal=$row->cpsubtotal_ventas;
                    $cpiva=$row->cpiva_ventas;
                    $cppreciot=$row->cptotal_ventas;

                    $datos[0]=$nuemrofcaturero;
                    $datos[1]=$cliente;
                    $datos[2]=$fecha_venta;
                    $datos[3]=$cpsubtotal;
                    $datos[4]=$cpiva;
                    $datos[5]=$cppreciot;

                    $resultado[$i++]=$datos;
                }
        }
        return $resultado;
    }
   
   public function ReporteGeneral()
   {
        $fecha_inicio=$this->input->post('finicio');
        $fecha_fin=$this->input->post('ffin');
        
        $datos=array();
        $resultado=array();
        $final=array();
        
        $i=0;
        //datos de las compras
        $sql_factura="SELECT id_compra, cpnumfac_compra, cpfecha_compra, idproveedor_compra, cpsubtotal_compra, cpiva_compra, cpdescuento_compra, cptotal_compra, cpnombre_proveedor FROM tblfactura_compra, tblproveedor where idproveedor_compra=id_proveedor";
        
        $res = $this->db->query($sql_factura);
        foreach ($res->result() as $row){
            
                $fecha_compra=$row->cpfecha_compra;
                $nuemrofcaturero=$row->cpnum1_venta."-".$row->cpnum2_venta."-".$row->cpnumero_venta;
                
                $segundos=strtotime($fecha_compra) - strtotime($fecha_inicio);
                $fechas_empiezo=intval($segundos/60/60/24);
                $segundos=strtotime($fecha_compra) - strtotime($fecha_fin);
                $fechas_terminar=intval($segundos/60/60/24);
                
                if($fechas_empiezo>=0 && $fechas_terminar<=0) {	
                    $numfac=$row->cpnumfac_compra;
                    $prov=$row->cpnombre_proveedor;
                    $subto=$row->cpsubtotal_compra;
                    $cerr=$row->cpdescuento_compra;
                    $ivai=$row->cpiva_compra;
                    $toatli=$row->cptotal_compra;
                    
                    $datos[0]=$numfac;
                    $datos[1]=$fecha_compra;
                    $datos[2]=$prov;
                    $datos[3]=$subto;
                    $datos[4]=$cerr;
                    $datos[5]=$ivai;
                    $datos[6]=$toatli;

                    $resultado[$i++]=$datos;
                }
        }
        $final[0]=$resultado;
        
        
        //Datos de las ventas
        $datos=array();
        $resultado=array();
        $i=0;
        $sql_factura="Select id_venta, cpcedula_cliente, cprazonsocial_cliente, cpdireccion_cliente, cptelefono_cliente, cpcelular_cliente, cpnum1_venta, cpnum2_venta, cpnumero_venta, cpsubtotal_ventas, cpiva_ventas, cptotal_ventas,cpfecha_venta, cpestado_factura, cpretenciones_contabilidad, cpretencion_factura
                    FROM
                    tblfactura_venta
                    INNER JOIN tblcliente ON tblcliente.id_cliente = tblfactura_venta.idcliente_venta
                    where cpfecha_venta>='".$fecha_inicio."' AND cpfecha_venta<='".$fecha_fin."'
                    order by cpnumero_venta";
        
        $res = $this->db->query($sql_factura);
        foreach ($res->result() as $row){
            $venta=$row->cpfecha_venta;
            $estado_fac=$row->cpestado_factura;
            $retencion = $row->cpretenciones_contabilidad;
            $retencion_hecha=$row->cpretencion_factura;
            $idid= $row->id_venta;
            $nombre= $row->cprazonsocial_cliente;
            
            $num_1 = $row->cpnum1_venta;
            $num_2 = $row->cpnum2_venta;
            $numero_fac = $row->cpnumero_venta;
            $nuemrofcaturero=$num_1."-".$num_2."-".$numero_fac;
            $subt = $row->cpsubtotal_ventas;
            $iva =$row->cpiva_ventas;
            $total = $row->cptotal_ventas;
                        
            $datos[0]=$nuemrofcaturero;
            $datos[1]=$venta;
            $datos[2]=$nombre;
            $datos[3]=$subt;
            $datos[4]=$iva;
            $datos[5]=$total;
           
            
            if($estado_fac=="ANULADO"){
                $datos[6]=$estado_fac;
                $datos[7]='';
                $datos[8]='';
                $datos[9]=$estado_fac;
                $datos[10]='';
                $datos[11]='';
			
            }
            else if($retencion=="NO"){
                $contabilidad="NO CONT";
                $datos[6]=$contabilidad;
                $datos[7]='';
                $datos[8]='';
                $datos[9]=$contabilidad;
                $datos[10]='';
                $datos[11]='';
            }
            else if($retencion_hecha=="SIN RETENCION"){
                $datos[6]='';
                $datos[7]='';
                $datos[8]='';
                $datos[9]='';
                $datos[10]='';
                $datos[11]='';
               
            }

            else if($retencion!="NO" && $estado_fac!="ANULADO" && $retencion_hecha!="SIN RETENCION" ){
                $retencionq="SELECT re.id_retencion, base_retencion,  Impuesto_retencion, porcentaje_retencion, cpvalor_retencion, idretencion_detalle, cpnum1_venta, cpnum2_venta, cpnumero_venta FROM tbldetalle_retencion de, tblretencion re, tblfactura_venta  where idretencion_detalle=re.id_retencion  and id_venta=idfactura_retencion and id_venta=".$idid;
                $res1 = $this->db->query($retencionq);
                foreach ($res1->result() as $row1)
   		{
			$impx=$row1->Impuesto_retencion;
			$porx=$row1->porcentaje_retencion;
			$valx=$row1->cpvalor_retencion;
			
			
			if($impx=="RENTA"){
                            $impuestorenta=$impx;
                            $porcentajerenta=$porx;
                            $valorrenta=$valx;
                            //$sumando_rentas+=$valorrenta;
			}
			if($impx=="IVA"){
                            $impuestoiva=$impx;
                            $porcentajeiva=$porx;
                            $valoriva=$valx;
                            //$sumando_iva+=$valoriva;
			}
			
	
		}
                $datos[6]=$impuestorenta;
                $datos[7]=$porcentajerenta;
                $datos[8]=$valorrenta;
                $datos[9]=$impuestoiva;
                $datos[10]=$porcentajeiva;
                $datos[11]=$valoriva;
            }
            
            
            if($estado_fac=="ANULADO"){
                $color="#F01313";
                $bcolor="#FFF";
            }
            else{
                $bcolor="#000";
                $color="#FEFCFC";
            }
             $datos[12]=$color;
             $datos[13]=$bcolor;
            
            $resultado[$i++]=$datos;
            
        }
        
        $final[1]=$resultado;
        
        return $final;
    }
    
    
    public function retenciones()
    {
        $sql_pendientes="Select cpcedula_cliente, cprazonsocial_cliente,  cpdireccion_cliente, cptelefono_cliente, cpcelular_cliente, id_venta, cpnum1_venta, cpnum2_venta, cpnumero_venta, id_venta  from tblfactura_venta, tblcliente where idcliente_venta=id_cliente and  cpretencion_factura='SIN RETENCION' and cpestado_factura!='ANULADO' and cpretenciones_contabilidad ='SI' order by cpnumero_venta asc";
        $res = $this->db->query($sql_pendientes);
        return $res->result();
        
    }
    
    public function buscarRetencion()
    {
        $id_venta=  $this->input->post('id_venta');
        $sql_consultar_det="SELECT id_venta,  cpfecha_venta,  cpfechapag_venta,  cpvendedor_venta,  cpformpag_venta,  cpsubtotal_ventas,  cpiva_ventas,  cpdescuento_ventas,  cptotal_ventas,  idcliente_venta,  cpestado_factura,  cpretencion_factura, cpnum1_venta, cpnum2_venta, cpnumero_venta
                            FROM
                            tblfactura_venta
                            INNER JOIN tblcliente ON tblcliente.id_cliente = tblfactura_venta.idcliente_venta
                            where idcliente_venta= id_cliente and id_venta='".$id_venta."'";
	$res = $this->db->query($sql_consultar_det);
        
        return $res->result();
        
    }
    
    public function hacerRetencion()
    {
        $id_venta=  $this->input->post('id_venta');
        $num_co= $this->input->post('codigo');
        
        //busco el max id de retencion
        $sql_u="select max(id_retencion) as id_retencion from tblretencion";
        $resp=$this->db->query($sql_u);
        $idret=$resp->row()->id_retencion +1;
	
	
	$sqli="INSERT INTO tblretencion ( id_retencion, idpropietario_retencion, idfactura_retencion, cpcodigo_retencion) VALUE ( '$idret', '1', '$id_venta', '$num_co');";
	$resp1=$this->db->query($sqli);
	
       
        $base=$this->input->post('base');
        $impuest=$this->input->post('impuesto');
        $reten=$this->input->post('retencion');
        $valore=$this->input->post('valor');
        $sqlp="INSERT INTO tbldetalle_retencion ( base_retencion, Impuesto_retencion,  porcentaje_retencion, cpvalor_retencion,  idretencion_detalle) VALUE ( '$base',  '$impuest', '$reten',  '$valore',  '$idret')";
        $resp2=$this->db->query($sqlp);
	
	 
        $sqlac_f="UPDATE tblfactura_venta  SET  cpretencion_factura = 'CON RETENCION' WHERE id_venta = '".$id_venta."';";
        $resp3=$this->db->query($sqlac_f);
        return;
    }
    
}


?>