<?php
/**
* Modelo de Inicio de sesión
* */
class mproductos extends CI_Model{ 
    var $table  = "tblproducto";
    
    function __construct()
    {
        parent::__construct();
    }

    
    public function get_productos(){
        $query ="SELECT tblproducto.* FROM tblproducto ORDER BY id_producto";
        $res = $this->db->query($query);
	return array("content"=>$res->result());
    }
   
    public function obtenerproductos($id)
    {
        $result=array();
        $query = $this->db->get_where($this->table,array("id_producto"=>$id));
        $result['datos']=$query->result();
        return $result;
    }
    
    function codigo_plan(){
        $query="select max(id_producto) as id_producto from tblproducto";
        $res = $this->db->query($query);
        $valor_ultimo=$res->row()->id_producto;

        $consulta_plan="SELECT cpcodigo_producto FROM tblproducto where id_producto='$valor_ultimo'";
        $res1 = $this->db->query($consulta_plan);
        
            $planes=$res1->row()->cpcodigo_producto;
            $cadena = substr($planes, 0, -1); 
            $ultimo = substr($planes, -1);  
            $codigo_generado=$cadena."".($ultimo+1);
       
       return $codigo_generado;
    }
    
    public function nuevoproductos()
    {
       $resultado=array(); 
       $nombre= $this->input->post('nombre');
       $descripcion= $this->input->post('descripcion');
       $unidad_medida= $this->input->post('unidad_medida');
       $categoria= $this->input->post('categoria');
       $precioUnicontado= $this->input->post('precioUnicontado');
       $precioUniCredito= $this->input->post('precioUniCredito');
       $stock= $this->input->post('stock');
       $cantmin= $this->input->post('cantmin');
       $cantmax= $this->input->post('cantmax');
       $preciocompra= $this->input->post('preciocompra');
       $iva= $this->input->post('iva');
       $codigo_ultimo=  $this->codigo_plan();
       
       $datos=array(
           'cpcodigo_producto'=>$codigo_ultimo,
           'cpnombre_producto'=>$nombre,
           'cpdescripcion_producto'=>$descripcion,
           'cpunidadmedida_producto'=>$unidad_medida,
           'cppreciocredito_producto'=>$precioUniCredito,
           'cpprecioproducto_contado'=>$precioUnicontado,
           'cpcategoria_producto'=>$categoria,
           'cpstock_producto'=>$stock,
           'cpcantidadminima_producto'=>$cantmin,
           'cpcantidadmaxima_producto'=>$cantmax,
           'cppreciocompra_producto'=>$preciocompra,
           'idiva_producto'=>$iva,
           'cpestado_producto'=>'ACTIVO'
          
       );
       //verifico que el clientes no este insertado ya
       $query ="SELECT tblproducto.* FROM tblproducto WHERE cpnombre_producto='".$datos['cpnombre_producto']."'";
       $res = $this->db->query($query);
       if($res->num_rows() > 0 )
        {
            $resultado['error']=1;
            $resultado['mensaje']="Este producto ya ha sido ingresado anteriormente.";
        }
        else
        {
           //inserto en la tabla objetos 
           $this->db->insert($this->table,$datos);
           $id_insertado=$this->db->insert_id();
           $this->logs->log($this->data["sesion"]["id_usuario"].'  INSERT  productos  '.$id_insertado);
           
           
           //formo el array con los valores a devolver
           $this->db->select('tblproducto.*');
           $this->db->from($this->table);
           $this->db->where('tblproducto.id_producto', $id_insertado);
           $query = $this->db->get();
           
           $resultado['error']=0;
           $resultado['mensaje']="El producto <strong>". $datos['cpnombre_producto']."</strong> ha sido insertado satisfactoriamente.";
           $resultado['datos']= $query->result();
        }
        return $resultado;
    }
    
    public function updateproductos($data="")
    {
       $id= $this->input->post('id');
       $nombre= $this->input->post('nombre');
       $descripcion= $this->input->post('descripcion');
       $unidad_medida= $this->input->post('unidad_medida');
       $categoria= $this->input->post('categoria');
       $precioUnicontado= $this->input->post('precioUnicontado');
       $precioUniCredito= $this->input->post('precioUniCredito');
       $stock= $this->input->post('stock');
       $cantmin= $this->input->post('cantmin');
       $cantmax= $this->input->post('cantmax');
       $preciocompra= $this->input->post('preciocompra');
       $iva= $this->input->post('iva');
       $codigo_ultimo=  $this->codigo_plan();
       
       $datos=array(
           
           'cpcodigo_producto'=>$codigo_ultimo,
           'cpnombre_producto'=>$nombre,
           'cpdescripcion_producto'=>$descripcion,
           'cpunidadmedida_producto'=>$unidad_medida,
           'cppreciocredito_producto'=>$precioUniCredito,
           'cpprecioproducto_contado'=>$precioUnicontado,
           'cpcategoria_producto'=>$categoria,
           'cpstock_producto'=>$stock,
           'cpcantidadminima_producto'=>$cantmin,
           'cpcantidadmaxima_producto'=>$cantmax,
           'cppreciocompra_producto'=>$preciocompra,
           'idiva_producto'=>$iva,
           'cpestado_producto'=>'ACTIVO'
          
       );
       //verifico que el clientes no este insertado ya
       $query ="SELECT tblproducto.* FROM tblproducto WHERE cpnombre_producto='".$datos['cpnombre_producto']."' AND id_producto!='".$id."'";
       $res = $this->db->query($query);
       if($res->num_rows() > 0 )
        {
            $resultado['error']=1;
            $resultado['mensaje']="Este producto ya ha sido ingresado anteriormente.";
        }
        else
        {
           //inserto en la tabla objetos 
            $this->db->where('id_producto', $id);
            $this->db->update($this->table, $datos);
            $this->logs->log($this->data["sesion"]["id_usuario"].'  UPDATE  productos  '.$id);
                      
            
           //formo el array con los valores a devolver
           //formo el array con los valores a devolver
           $this->db->select('tblproducto.*');
           $this->db->from($this->table);
           $this->db->where('tblproducto.id_producto', $id);
           $query = $this->db->get();
           
           
           $resultado['error']=0;
           $resultado['mensaje']="El producto <strong>". $datos['cpnombre_producto']."</strong> ha sido actualizado satisfactoriamente.";
           $resultado['datos']= $query->result();
        }
        return $resultado;
    }
    
    public function deleteproductos($datos)
    {
        $resultado=array(); 
        //obtengo el nombre del objeto
        $query = $this->db->get_where($this->table,array("id_producto"=>$datos['id_producto']));
        $resultado['datos']= $query->row_array();
        
        //elimino el ojeto
        $this->db->delete($this->table, $datos);
        $this->logs->log($this->data["sesion"]["id_usuario"].'  DELETE  Clientes  '.$datos['id_producto']);
        $resultado['error']=0;
        $resultado['mensaje']="El Producto <strong>". $resultado['datos']['cpnombre_producto']."</strong> ha sido eliminado satisfactoriamente.";
        return $resultado;
    }
 
}


?>