<?php
/**
* Modelo de Inicio de sesión
* */
class mpanel extends CI_Model{ 
    
    function __construct()
    {
        parent::__construct();
    }
    public function buscar_alarmas()
    {
        $query ="SELECT COUNT(id_pendiente) as cant FROM tblpendiente "
                . "INNER JOIN tblusuario ON tblusuario.id_usuario = tblpendiente.cpasignar_usuario "
                . "WHERE (tblpendiente.cpfecha <= DATE_ADD(CURDATE(), INTERVAL 3 DAY) AND tblpendiente.cpfecha >= CURDATE())"
                . " AND tblusuario.id_usuario='".$this->data["sesion"]["id_usuario"]."'"
                . " AND tblpendiente.cpestado = 'PENDIENTE' ORDER BY tblpendiente.cpfecha ASC,tblpendiente.cphora ASC";
        $res = $this->db->query($query);
        return $res->row()->cant;
    }
    
    //busca los detalles de las alarmas
    public function buscar_detallesalarmas()
    {
        $query ="SELECT tblpendiente.* FROM tblpendiente "
                . "INNER JOIN tblusuario ON tblusuario.id_usuario = tblpendiente.cpasignar_usuario "
                . "WHERE (tblpendiente.cpfecha <= DATE_ADD(CURDATE(), INTERVAL 3 DAY) AND tblpendiente.cpfecha >= CURDATE())"
                . " AND tblusuario.id_usuario='".$this->session->userdata['logged_in']['id_usuario']."'"
                . " AND tblpendiente.cpestado = 'PENDIENTE' ORDER BY tblpendiente.cpfecha ASC,tblpendiente.cphora ASC";
        $this->load->database();
      	$result = $this->db->db_connect();
        $res = $this->db->query($query);
        return $res->result();
    }
    
    public function obtenerAlarmas()
    {
        $datos=array();
      $query ="SELECT COUNT(tblpendiente.id_pendiente) as cant FROM tblpendiente WHERE tblpendiente.cpasignar_usuario='".$this->data["sesion"]["id_usuario"]."' AND tblpendiente.cpestado='PENDIENTE'";  
      $res = $this->db->query($query);
      $datos['num_pend']=$res->row()->cant;
      
      $query ="SELECT count(tblpendiente.id_pendiente) as cant FROM tblpendiente 
        WHERE (tblpendiente.cpfecha <= DATE_ADD(CURDATE(), INTERVAL 3 DAY) AND tblpendiente.cpfecha >= CURDATE())
        AND tblpendiente.cpasignar_usuario ='".$this->data["sesion"]["id_usuario"]."'
        AND tblpendiente.cpestado = 'PENDIENTE' ORDER BY tblpendiente.cpfecha ASC,tblpendiente.cphora ASC";
      $res = $this->db->query($query);
      $datos['pend_venc']=$res->row()->cant;
      
      
      $query="Select COUNT(id_venta) as cant FROM tblfactura_venta, tblcliente WHERE  idcliente_venta=id_cliente and  cpestado_factura='PENDIENTE'";
      $res = $this->db->query($query);
      $datos['pend_cobro']=$res->row()->cant;
      
      return $datos;
    }
}   



?>