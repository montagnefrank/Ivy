<?php
/**
* Modelo de Inicio de sesión
* */
class mclientes extends CI_Model{ 
    var $table  = "tblcliente";
    
    function __construct()
    {
        parent::__construct();
    }

    
    public function get_clientes(){
        $query ="SELECT tblcliente.* FROM tblcliente where cpestado_cliente='ACTIVO' ORDER BY id_cliente";
        $res = $this->db->query($query);
	return array("content"=>$res->result());
    }
    
       
    public function obtenerclientes($id)
    {
        $result=array();
        $query = $this->db->get_where($this->table,array("id_cliente"=>$id));
        $result['datos']=$query->result();
        return $result;
    }
    
    //busco un cliente por su nombre
    public function buscarclientes($datos)
    {
        $query = "SELECT * FROM tblcliente WHERE cprazonsocial_cliente LIKE '%".$datos."%'";
       
        $res = $this->db->query($query);
	foreach($res->result() as $row)
        {
            $data[] = array('text' => $row->cprazonsocial_cliente, 'id' => $row->id_cliente, 'cedula'=>$row->cpcedula_cliente,'direccion'=>$row->cpdireccion_cliente,'telefono'=>$row->cptelefono_cliente);
        }
        if(count($data)==0) 
            $data[] = array('text' =>'', 'id' => '', 'cedula'=>'','direccion'=>'','telefono'=>'');
        return $data;
    }
    
     public function codigo_plan(){
        
        $consulta_plan="SELECT cpcodigoplan_cliente FROM tblcliente where id_cliente=(select max(id_cliente) from tblcliente)";
        $res = $this->db->query($consulta_plan);
            foreach ($res->result() as $row){
                $planes=$row->cpcodigoplan_cliente;
                $cadena = substr($planes, 0, -1); 
                $ultimo = substr($planes, -1);  
                $codigo_generado=$cadena."".($ultimo+1);
           }
           return $codigo_generado;


        }
    
    public function nuevoclientes()
    {
       $resultado=array(); 
       $cedula= $this->input->post('cedula');
       $razon_social= $this->input->post('razon_social');
       $direccion= $this->input->post('direccion');
       $telefono= $this->input->post('telefono');
       $telefonoc= $this->input->post('telefonoc');
       $movil= $this->input->post('movil');
       $movilc= $this->input->post('movilc');
       $email= $this->input->post('email');
       $obligado= $this->input->post('obligado');
       $cuenta= $this->input->post('cuenta');
        
       $datos=array(
           'cpcedula_cliente'=>$cedula,
           'cprazonsocial_cliente'=>$razon_social,
           'cpdireccion_cliente'=>$direccion,
           'cptelefono_cliente'=>$telefono,
           'cptelefono2_cliente'=>$telefonoc,
           'cpcelular_cliente'=>$movil,
           'cpcelular2_cliente'=>$movilc,
           'cpcorreo_cliente'=>$email,
           'cpestado_cliente'=>'ACTIVO',
           'cpretenciones_contabilidad'=>$obligado,
           'cpcodigoplan_cliente'=>$cuenta,
          
       );
       //verifico que el clientes no este insertado ya
       $query ="SELECT tblcliente.* FROM tblcliente WHERE cpcedula_cliente='".$datos['cpcedula_cliente']."'";
       $res = $this->db->query($query);
       if($res->num_rows() > 0 )
        {
            $resultado['error']=1;
            $resultado['mensaje']="Este cliente ya ha sido ingresado anteriormente.";
        }
        else
        {
           //inserto en la tabla objetos 
           $this->db->insert($this->table,$datos);
           $id_insertado=$this->db->insert_id();
           $this->logs->log($this->data["sesion"]["id_usuario"].'  INSERT  clientes  '.$id_insertado);
           
            $sql="select max(id_plancuentas) as id_plancuentas from tblplancuentas ";
            $res = $this->db->query($sql);
            $result=$res->row()->id_plancuentas + 1;
            
           $sql_plan="INSERT INTO tblplancuentas (id_plancuentas, cpcodigo_plancuentas, cpdescripcion_plancuentas, cpnivel, cpestado_plancuentas, cpfile)
                      VALUE ('$result', '$cuenta', 'cprazonsocial_cliente', '5', 'A', '1');";
           $res = $this->db->query($sql_plan);
           
           //formo el array con los valores a devolver
           $this->db->select('tblcliente.*');
           $this->db->from($this->table);
           $this->db->where('tblcliente.id_cliente', $id_insertado);
           $query = $this->db->get();
           
           $resultado['error']=0;
           $resultado['mensaje']="El cliente <strong>". $datos['cprazonsocial_cliente']."</strong> ha sido insertado satisfactoriamente.";
           $resultado['datos']= $query->result();
        }
        return $resultado;
    }
    
    public function updateclientes($data="")
    {
       $id= $this->input->post('id');
       $cedula= $this->input->post('cedula');
       $razon_social= $this->input->post('razon_social');
       $direccion= $this->input->post('direccion');
       $telefono= $this->input->post('telefono');
       $telefonoc= $this->input->post('telefonoc');
       $movil= $this->input->post('movil');
       $movilc= $this->input->post('movilc');
       $email= $this->input->post('email');
       $obligado= $this->input->post('obligado');
       $cuenta= $this->input->post('cuenta');
        
       $datos=array(
           'id_cliente'=>$id,
           'cpcedula_cliente'=>$cedula,
           'cprazonsocial_cliente'=>$razon_social,
           'cpdireccion_cliente'=>$direccion,
           'cptelefono_cliente'=>$telefono,
           'cptelefono2_cliente'=>$telefonoc,
           'cpcelular_cliente'=>$movil,
           'cpcelular2_cliente'=>$movilc,
           'cpcorreo_cliente'=>$email,
           'cpestado_cliente'=>'ACTIVO',
           'cpretenciones_contabilidad'=>$obligado,
           'cpcodigoplan_cliente'=>$cuenta,
          
       );
       
       //verifico que el clientes no este insertado ya
       $query ="SELECT tblcliente.* FROM tblcliente WHERE cpcedula_cliente='".$datos['cpcedula_cliente']."' AND id_cliente!='".$id."'";
       $res = $this->db->query($query);
       if($res->num_rows() > 0 )
        {
            $resultado['error']=1;
            $resultado['mensaje']="Este cliente ya ha sido ingresado anteriormente.";
        }
        else
        {
           //inserto en la tabla objetos 
            $this->db->where('id_cliente', $datos['id_cliente']);
            $this->db->update($this->table, $datos);
            $this->logs->log($this->data["sesion"]["id_usuario"].'  UPDATE  Usuarios  '.$datos['id_cliente']);
                      
            
           //formo el array con los valores a devolver
           $this->db->select('tblcliente.*');
           $this->db->from($this->table);
           $this->db->where('tblcliente.id_cliente', $datos['id_cliente']);
           $query = $this->db->get();
           
           
           $resultado['error']=0;
           $resultado['mensaje']="El cliente <strong>". $datos['cprazonsocial_cliente']."</strong> ha sido actualizado satisfactoriamente.";
           $resultado['datos']= $query->result();
        }
        return $resultado;
    }
    
    public function deleteclientes($datos)
    {
        $resultado=array(); 
        //obtengo el nombre del objeto
        $query = $this->db->get_where($this->table,array("id_cliente"=>$datos['id_cliente']));
        $resultado['datos']= $query->row_array();
        
        //elimino el ojeto
        $this->db->delete($this->table, $datos);
        $this->logs->log($this->data["sesion"]["id_usuario"].'  DELETE  Clientes  '.$datos['id_cliente']);
        $resultado['error']=0;
        $resultado['mensaje']="El usuario <strong>". $resultado['datos']['cprazonsocial_cliente']."</strong> ha sido eliminado satisfactoriamente.";
        return $resultado;
    }
 
}


?>