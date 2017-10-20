<?php
/**
* Modelo de Inicio de sesión
* */
class mpendientes extends CI_Model{ 
    var $table  = "tblpendiente";
    
    function __construct()
    {
        parent::__construct();
    }
    
    public function get_datos_combos()
    {     
      //cargo los locales
      $this->load->model('mtipo_solicitud');
      $datos['tsolicitud'] =$this->mtipo_solicitud->obtenertipo_solicitud();
      return $datos;  
        
    }
        
    public function get_pendientes(){
        $datos=array();
        
        if($this->data["sesion"]["rol"]=='Administrador Grupo' || $this->data["sesion"]["rol"]=='Jefe de Area')
        {
          $i=0;
          //para los pendientes del admin de grupo
           $query1 ="SELECT
                tblpendiente.*,
                tblusuario.usuario,
                tblusuario.cpcolor_usuario
                FROM
                tblpendiente
                INNER JOIN tblusuario ON tblusuario.id_usuario = tblpendiente.cpasignar_usuario
                WHERE tblpendiente.cpasignar_usuario='".$this->data["sesion"]["id_usuario"]."'
                AND tblpendiente.cpestado='PENDIENTE' ORDER BY tblpendiente.cpfecha DESC,tblpendiente.cphora DESC";
             
                $res1 = $this->db->query($query1);
                foreach ($res1->result() as $row1)
                {
                    $filas=array();
                    $filas[0]=$row1->id_pendiente;
                    $filas[1]=$row1->cpdescripcion;
                    $filas[2]=$row1->cpfecha;
                    $filas[3]=$row1->cphora;
                    $filas[4]=$row1->cpestado;
                    $filas[5]=$row1->cpprioridad_pendiente;
                    $filas[6]=$row1->usuario;
                    $filas[7]=$row1->cpcolor_usuario;
                    $datos[$i++]=$filas;
                }
          
                //busco todas las personas que estan bajo el control del admin de grupo
          $query ="SELECT 
                usuarios_controlados.id_usuario
                FROM
                usuarios_controlados
                WHERE
                usuarios_controlados.id_administrador = '".$this->data["sesion"]["id_usuario"]."'";
           $res = $this->db->query($query);
           
           foreach ($res->result() as $row)
           {
              $query1 ="SELECT
                tblpendiente.*,
                tblusuario.usuario,
                tblusuario.cpcolor_usuario
                FROM
                tblpendiente
                INNER JOIN tblusuario ON tblusuario.id_usuario = tblpendiente.cpasignar_usuario
                WHERE tblpendiente.cpasignar_usuario='".$row->id_usuario."'
                AND (tblpendiente.cpestado='REVISAR' OR tblpendiente.cpestado='PENDIENTE') ORDER BY tblpendiente.cpfecha DESC,tblpendiente.cphora DESC";
             
                $res1 = $this->db->query($query1);
                foreach ($res1->result() as $row1)
                {
                    $filas=array();
                    $filas[0]=$row1->id_pendiente;
                    $filas[1]=$row1->cpdescripcion;
                    $filas[2]=$row1->cpfecha;
                    $filas[3]=$row1->cphora;
                    $filas[4]=$row1->cpestado;
                    $filas[5]=$row1->cpprioridad_pendiente;
                    $filas[6]=$row1->usuario;
                    $filas[7]=$row1->cpcolor_usuario;
                    $datos[$i++]=$filas;
                }
           }
           
           
        }
        else{
        
         $i=0;
          //para los pendientes del propio usuario logueado
           $query1 ="SELECT
                tblpendiente.*,
                tblusuario.usuario,
                tblusuario.cpcolor_usuario
                FROM
                tblpendiente
                INNER JOIN tblusuario ON tblusuario.id_usuario = tblpendiente.cpasignar_usuario
                WHERE tblpendiente.cpasignar_usuario='".$this->data["sesion"]["id_usuario"]."'
                AND tblpendiente.cpestado='PENDIENTE' ORDER BY tblpendiente.cpfecha DESC,tblpendiente.cphora DESC";
             
                $res1 = $this->db->query($query1);
                foreach ($res1->result() as $row1)
                {
                    $filas=array();
                    $filas[0]=$row1->id_pendiente;
                    $filas[1]=$row1->cpdescripcion;
                    $filas[2]=$row1->cpfecha;
                    $filas[3]=$row1->cphora;
                    $filas[4]=$row1->cpestado;
                    $filas[5]=$row1->cpprioridad_pendiente;
                    $filas[6]=$row1->usuario;
                    $filas[7]=$row1->cpcolor_usuario;
                    $datos[$i++]=$filas;
                }     
            
                //para los pendientes de los demas usuarios distintos del administrador
                if($this->data["sesion"]["rol"]=='Administrador')
                {
                    $query ="SELECT
                        tblpendiente.id_pendiente,
                        tblpendiente.cpdescripcion,
                        tblpendiente.cpfecha,
                        tblpendiente.cphora,
                        tblpendiente.cpestado,
                        tblpendiente.cpprioridad_pendiente,
                        tblusuario.usuario,
                        tblusuario.cpcolor_usuario
                        FROM
                        tblpendiente
                        INNER JOIN tblusuario ON tblusuario.id_usuario = tblpendiente.cpasignar_usuario
                        WHERE (tblpendiente.cpestado='REVISAR' OR tblpendiente.cpestado='PENDIENTE' OR tblpendiente.cpestado='REVISAR2')
                        AND tblpendiente.cpasignar_usuario!='".$this->data["sesion"]["id_usuario"]."'
                        ORDER BY tblusuario.usuario ASC,tblpendiente.cpfecha DESC,tblpendiente.cphora DESC";
                    $res = $this->db->query($query);
                    foreach ($res->result() as $row)
                    {
                        $filas=array();
                        $filas[0]=$row->id_pendiente;
                        $filas[1]=$row->cpdescripcion;
                        $filas[2]=$row->cpfecha;
                        $filas[3]=$row->cphora;
                        $filas[4]=$row->cpestado;
                        $filas[5]=$row->cpprioridad_pendiente;
                        $filas[6]=$row->usuario;
                        $filas[7]=$row->cpcolor_usuario;
                        $datos[$i++]=$filas;
                    }
                }
        }
        return array("content"=>$datos);
    }
    
    //obtiene un tipo de solictud con sus usuarios en dependencia del id de la solicitud
    public function get_pendientes_byID($id){
        $query ="SELECT
                tblpendiente.*,tblusuario.usuario
                FROM
                tblpendiente
                INNER JOIN tblusuario ON tblusuario.id_usuario = tblpendiente.cpasignar_usuario
                WHERE tblpendiente.id_pendiente ='".$id."'";
        $res = $this->db->query($query);
        $i=0;
        $filas=array();
        foreach ($res->result() as $row)
        {
            
            $filas[0]=$row->id_pendiente;
            $filas[1]= preg_replace('/\<br(\s*)?\/?\>/i', '', $row->cpdescripcion);
            $filas[2]=$row->cpfecha;
            $filas[3]=$row->cphora;
            $filas[4]=$row->cpestado;
            $filas[5]=$row->usuario;
            $filas[6]=$row->cpprioridad_pendiente;
            $filas[7]=$row->cpasignar_usuario;
        }
        
        return $filas;
    }
    
    public function get_pendientes_byID2($id){
        $query ="SELECT
                tblpendiente.*,tblusuario.usuario
                FROM
                tblpendiente
                INNER JOIN tblusuario ON tblusuario.id_usuario = tblpendiente.cpasignar_usuario
                WHERE tblpendiente.id_pendiente ='".$id."'";
        $res = $this->db->query($query);
        return $res->result();
        
    }   
    public function get_todospendientes(){
        $query ="SELECT tblpendiente.* FROM tblpendiente "
                . "INNER JOIN tblusuario ON tblusuario.id_usuario = tblpendiente.cpasignar_usuario "
                . "WHERE (tblpendiente.cpfecha <= DATE_ADD(CURDATE(), INTERVAL 3 DAY) AND tblpendiente.cpfecha >= CURDATE())"
                . " AND tblusuario.id_usuario='".$this->session->userdata['logged_in']['id_usuario']."'"
                . " AND tblpendiente.cpestado = 'PENDIENTE' ORDER BY tblpendiente.cpfecha ASC,tblpendiente.cphora ASC";
        $res = $this->db->query($query);
        return $res->result();
        
    }     
    
    //obtiene un tipo de solictud con sus usuarios en dependencia del id de la solicitud
    public function get_actividadByTipo($id){
        $query ="SELECT id,nombre FROM actividades WHERE actividades.tipo_solicitud='".$id."'";
        $res = $this->db->query($query);
        return $res->result();
    }
    
    
    public function nuevopendiente($datos)
    {
       $resultado=array(); 
       //verifico que el pendiente no este insertado ya
       $query ="SELECT cpdescripcion FROM tblpendiente WHERE cpdescripcion='".$datos['nombre']."' and cpfecha='".$datos['fecha']."' and cphora='".$datos['hora']."'";
       $res = $this->db->query($query);
       if($res->num_rows() > 0 )
        {
            $resultado['error']=1;
            $resultado['mensaje']="Ya existe un Pendiente con ese nombre.";
        }
        else
        {
           //inserto en la tabla actividades
           $query ="INSERT INTO tblpendiente (cpdescripcion,cpfecha,cphora,cpestado,cpasignar_usuario,cpprioridad_pendiente) VALUES ('".$datos['nombre']."','".$datos['fecha']."','".$datos['hora']."','PENDIENTE','".$datos['usuario']."','".$datos['prioridad']."')";
           $res = $this->db->query($query);
           $id_insertado=$this->db->insert_id();
           $this->logs->log($this->data["sesion"]["id_usuario"].'  INSERCION  pendiente  '.$id_insertado);
           
           //formo el array con los valores a devolver
           $query = $this->get_pendientes_byID($id_insertado);
           
           $resultado['error']=0;
           $resultado['mensaje']="El pendiente <strong>". $datos['nombre']."</strong> ha sido insertada satisfactoriamente.";
           $resultado['datos']= $query;
        }
        return $resultado;
    }
    
    public function updatependiente($datos){
        $resultado=array(); 
       //verifico que la atividad no este insertada ya
       $query ="SELECT cpdescripcion FROM tblpendiente WHERE cpdescripcion='".$datos['cpdescripcion']."' and cpfecha='".$datos['cpfecha']."' and cphora='".$datos['cphora']."' AND id_pendiente!='".$datos['id_pendiente']."'";
       $res = $this->db->query($query);
       if($res->num_rows() > 0 )
        {
            $resultado['error']=1;
            $resultado['mensaje']="Ya existe una Actividad con ese nombre.";
        }
        else
        {
           
            $this->db->where('id_pendiente', $datos['id_pendiente']);
            $this->db->update('tblpendiente', $datos);
            $this->logs->log($this->data["sesion"]["id_usuario"].'  UPDATE  Pendiente  '.$datos['id_pendiente']);
            
                    
            //formo el array con los valores a devolver
           $query = $this->get_pendientes_byID($datos['id_pendiente']);
           
           $resultado['error']=0;
           $resultado['mensaje']="El pendiente <strong>". $datos['cpdescripcion']."</strong> ha sido actualizada satisfactoriamente.";
           $resultado['datos']= $query;
        }
        return $resultado;
    }
    
    public function updatependienterealizado(){
        $resultado=array(); 
        $id= $this->input->post('id');
       
//         $query ="SELECT
//                    tblrol.cpdescripcion_rol
//                    FROM
//                    tblpendiente
//                    INNER JOIN tblusuario ON tblusuario.id_usuario = tblpendiente.cpasignar_usuario
//                    INNER JOIN tblrol ON tblusuario.idrol_usuario = tblrol.id_rol
//                    WHERE
//                    tblpendiente.id_pendiente ='".$id."'";
//        $res = $this->db->query($query);
//        $estado='';
//        foreach ($res->result() as $row){
            if($this->data["sesion"]["rol"] =='Administrador')
            {
              $estado='REALIZADO';  
            }
            
            else if($this->data["sesion"]["rol"] =='Administrador Grupo')
            {
              $estado='REVISAR2';  
            }
            else 
            {
               $estado='REVISAR';  
            }
       
        $datos=array(
           'id_pendiente'=>$id,
           'cpestado'=>$estado
        );
       
        
        $this->db->where('id_pendiente', $datos['id_pendiente']);
        $this->db->update('tblpendiente', $datos);
        $this->logs->log($this->data["sesion"]["id_usuario"].'  UPDATE  Pendiente  '.$datos['id_pendiente']);


        //formo el array con los valores a devolver
        $query = $this->get_pendientes_byID($datos['id_pendiente']);

        $resultado['error']=0;
        $resultado['datos']= $query;
        
        return $resultado;
    }
    
    public function deletependiente($datos)
    {
        $resultado=array(); 
        //obtengo el nombre del objeto
        $query = $this->db->get_where($this->table,array("id_pendiente"=>$datos['id_pendiente']));
        $this->logs->log($this->data["sesion"]["id_usuario"].'  DELETE  Pendiente  '.$datos['id_pendiente']);
        $resultado['datos']= $query->row_array();
        
        //elimino el ojeto
        $this->db->delete($this->table, $datos);
        $resultado['error']=0;
        $resultado['mensaje']="El Pendiente <strong>". $resultado['datos']['cpdescripcion']."</strong> ha sido eliminado satisfactoriamente.";
        return $resultado;
    }
      
    
}
?>