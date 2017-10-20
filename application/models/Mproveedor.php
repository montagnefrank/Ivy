<?php
/**
* Modelo de Inicio de sesión
* */
class mproveedor extends CI_Model{ 
    var $table  = "tblproveedor";
    
    function __construct()
    {
        parent::__construct();
    }

    
    public function get_proveedor(){
        $query ="SELECT tblproveedor.* FROM tblproveedor ORDER BY id_proveedor";
        $res = $this->db->query($query);
	return array("content"=>$res->result());
    }
    
       
    public function obtenerproveedor($id)
    {
        $result=array();
        $query = $this->db->get_where($this->table,array("id_proveedor"=>$id));
        $result['datos']=$query->result();
        return $result;
    }
    
    public function codigo_plan(){
        
        $consulta_plan="SELECT cpcodigoplan_proveedor FROM tblproveedor where id_proveedor=(select max(id_proveedor) from tblproveedor)";
        $res = $this->db->query($consulta_plan);
            foreach ($res->result() as $row){
                $planes=$row->cpcodigoplan_proveedor;
                $cadena = substr($planes, 0, -1); 
                $ultimo = substr($planes, -1);  
                $codigo_generado=$cadena."".($ultimo+1);
           }
           return $codigo_generado;


    }
   
    public function nuevoproveedor()
    {
       $resultado=array(); 
       $cpcomercial_proveedor= $this->input->post('cpcomercial_proveedor');
       $cpnombre_proveedor= $this->input->post('cpnombre_proveedor');
       $cpruc_proveedor= $this->input->post('cpruc_proveedor');
       $cpdireccion_proveedor= $this->input->post('cpdireccion_proveedor');
       $cptelefono_proveedor= $this->input->post('cptelefono_proveedor');
       $cptelefono2_proveedor= $this->input->post('cptelefono2_proveedor');
       $cpcelular_proveedor= $this->input->post('cpcelular_proveedor');
       $cpcorreo_proveedor= $this->input->post('cpcorreo_proveedor');
       $cpestado_proveedor= $this->input->post('cpestado_proveedor');
       $cuenta= $this->input->post('cuenta');
        
       $datos=array(
           'cpcomercial_proveedor'=>$cpcomercial_proveedor,
           'cpnombre_proveedor'=>$cpnombre_proveedor,
           'cpruc_proveedor'=>$cpruc_proveedor,
           'cpdireccion_proveedor'=>$cpdireccion_proveedor,
           'cptelefono_proveedor'=>$cptelefono_proveedor,
           'cptelefono2_proveedor'=>$cptelefono2_proveedor,
           'cpcelular_proveedor'=>$cpcelular_proveedor,
           'cpcorreo_proveedor'=>$cpcorreo_proveedor,
           'cpestado_proveedor'=>'ACTIVO',
           'cpcodigoplan_proveedor'=>$cuenta
          
       );
       //verifico que el proveedor no este insertado ya
       $query ="SELECT tblproveedor.* FROM tblproveedor WHERE cpcomercial_proveedor='".$datos['cpcomercial_proveedor']."'";
       $res = $this->db->query($query);
       if($res->num_rows() > 0 )
        {
            $resultado['error']=1;
            $resultado['mensaje']="Este proveedor ya ha sido ingresado anteriormente.";
        }
        else
        {
           //inserto en la tabla objetos 
           $this->db->insert($this->table,$datos);
           $id_insertado=$this->db->insert_id();
           $this->logs->log($this->data["sesion"]["id_usuario"].'  INSERT  proveedor  '.$id_insertado);
           
            $sql="SELECT max(id_plancuentas) as id_plancuentas from tblplancuentas";
            $res = $this->db->query($sql);
            $result=$res->row()->id_plancuentas + 1;
            
           $sql_plan="INSERT INTO tblplancuentas (id_plancuentas, cpcodigo_plancuentas, cpdescripcion_plancuentas, cpnivel, cpestado_plancuentas, cpfile) VALUE ('$result', '$cuenta', '$cpnombre_proveedor', '5', 'P', '2')";
           $res = $this->db->query($sql_plan);
           
           //formo el array con los valores a devolver
           $this->db->select('tblproveedor.*');
           $this->db->from($this->table);
           $this->db->where('tblproveedor.id_proveedor', $id_insertado);
           $query = $this->db->get();
           
           $resultado['error']=0;
           $resultado['mensaje']="El proveedor <strong>". $datos['cpnombre_proveedor']."</strong> ha sido insertado satisfactoriamente.";
           $resultado['datos']= $query->result();
        }
        return $resultado;
    }
    
    public function updateproveedor($data="")
    {
       $id= $this->input->post('id');
       $cpcomercial_proveedor= $this->input->post('cpcomercial_proveedor');
       $cpnombre_proveedor= $this->input->post('cpnombre_proveedor');
       $cpruc_proveedor= $this->input->post('cpruc_proveedor');
       $cpdireccion_proveedor= $this->input->post('cpdireccion_proveedor');
       $cptelefono_proveedor= $this->input->post('cptelefono_proveedor');
       $cptelefono2_proveedor= $this->input->post('cptelefono2_proveedor');
       $cpcelular_proveedor= $this->input->post('cpcelular_proveedor');
       $cpcorreo_proveedor= $this->input->post('cpcorreo_proveedor');
       $cpestado_proveedor= $this->input->post('cpestado_proveedor');
       $cuenta= $this->input->post('cuenta');
        
       $datos=array(
           'id_proveedor'=>$id,
           'cpcomercial_proveedor'=>$cpcomercial_proveedor,
           'cpnombre_proveedor'=>$cpnombre_proveedor,
           'cpruc_proveedor'=>$cpruc_proveedor,
           'cpdireccion_proveedor'=>$cpdireccion_proveedor,
           'cptelefono_proveedor'=>$cptelefono_proveedor,
           'cptelefono2_proveedor'=>$cptelefono2_proveedor,
           'cpcelular_proveedor'=>$cpcelular_proveedor,
           'cpcorreo_proveedor'=>$cpcorreo_proveedor,
           'cpestado_proveedor'=>'ACTIVO',
           'cpcodigoplan_proveedor'=>$cuenta
          
       );
       
       //verifico que el proveedor no este insertado ya
       $query ="SELECT tblproveedor.* FROM tblproveedor WHERE cpcomercial_proveedor='".$datos['cpcomercial_proveedor']."' AND id_proveedor!='".$id."'";
       $res = $this->db->query($query);
       if($res->num_rows() > 0 )
        {
            $resultado['error']=1;
            $resultado['mensaje']="Este Proveedor ya ha sido ingresado anteriormente.";
        }
        else
        {
           //inserto en la tabla objetos 
            $this->db->where('id_proveedor', $datos['id_proveedor']);
            $this->db->update($this->table, $datos);
            $this->logs->log($this->data["sesion"]["id_usuario"].'  UPDATE  Proveedor  '.$datos['id_proveedor']);
                      
            
           //formo el array con los valores a devolver
           $this->db->select('tblproveedor.*');
           $this->db->from($this->table);
           $this->db->where('tblproveedor.id_proveedor', $datos['id_proveedor']);
           $query = $this->db->get();
           
           
           $resultado['error']=0;
           $resultado['mensaje']="El Proveedor <strong>". $datos['cpcomercial_proveedor']."</strong> ha sido actualizado satisfactoriamente.";
           $resultado['datos']= $query->result();
        }
        return $resultado;
    }
    
    public function deleteproveedor($datos)
    {
        $resultado=array(); 
        //obtengo el nombre del objeto
        $query = $this->db->get_where($this->table,array("id_proveedor"=>$datos['id_proveedor']));
        $resultado['datos']= $query->row_array();
        
        //elimino el ojeto
        $this->db->delete($this->table, $datos);
        $this->logs->log($this->data["sesion"]["id_usuario"].'  DELETE  Proveedor  '.$datos['id_proveedor']);
        $resultado['error']=0;
        $resultado['mensaje']="El Proveedor <strong>". $resultado['datos']['cpcomercial_proveedor']."</strong> ha sido eliminado satisfactoriamente.";
        return $resultado;
    }
 
}


?>