<?php
/**
* Modelo de Inicio de sesión
* */
class minicio extends CI_Model{ 
    
    function __construct()
    {
        parent::__construct();
    }

    public function get_user($data){
        $query ="SELECT tblusuario.*,tblrol.* FROM tblusuario INNER JOIN tblrol ON tblusuario.idrol_usuario=tblrol.id_rol 
               WHERE usuario= '".strtolower($data['username'])."' AND contrasenna = '".$data['password']."'";
        
        $res = $this->db->query($query);
        $usuario= empty($res) ? null : $res->row();
	return $usuario;
    }
    
    // Read data from database to show data in admin page
    public function read_user_information($username)
    {
        $query ="SELECT tblusuario.*,tblrol.cpdescripcion_rol FROM tblusuario
            INNER JOIN tblrol ON tblusuario.idrol_usuario=tblrol.id_rol
            WHERE usuario= '".$username."' limit 1";
        $res = $this->db->query($query);
                
        if ($res->num_rows() == 1) {
            return $res->result();
        } else {
            return false;
        }
    }
    
    
}


?>