<?php
/**
* Modelo de Inicio de sesión
* */
class mplanes extends CI_Model{ 
    var $table  = "tblplancuentas";
    
    function __construct()
    {
        parent::__construct();
    }

    
    public function get_planes(){
        $query ="SELECT id_plancuentas, cpcodigo_plancuentas, cpdescripcion_plancuentas, cpnivel, cpestado_plancuentas, cpfile FROM tblplancuentas ORDER BY REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( SUBSTRING_INDEX( concat( cpcodigo_plancuentas, '.' ) , '.', 1 ) , 'CM', 'ZZZZ' ) , 'M', 'ZZZZZ' ) , 'CD', 'YYYY' ) , 'D', 'YYYYY' ) , 'XC', 'XXXXXXXXX' ) , 'C', 'XXXXXXXXXX' ) , 'XL', 'XXXX' ) , 'L', 'XXXXX' ) , 'IX', 'VIIII' ) , 'X', 'VIIIII' ), CAST( SUBSTRING_INDEX( SUBSTRING_INDEX( concat( cpcodigo_plancuentas, '.' ) , '.', 2 ) , '.', -1 ) AS UNSIGNED ), CAST( SUBSTRING_INDEX( SUBSTRING_INDEX( concat( cpcodigo_plancuentas, '.' ) , '.', 3 ) , '.', -1 ) AS UNSIGNED ), CAST( SUBSTRING_INDEX( SUBSTRING_INDEX( concat( cpcodigo_plancuentas, '.' ) , '.', 4 ) , '.', -1 ) AS UNSIGNED )";
        $res = $this->db->query($query);
	return array("content"=>$res->result());
    }
    
    
    public function get_tipocuenta()
    {
        $query="select * from tblplancuentas where cpnivel='1'";
        $res = $this->db->query($query);
        $result=array();
        $result['datos']=$res->result();
        return $result;
	
    }
    
    public function obtenercodigo()
    {
        $id_cuenta=$this->input->post('tipocuenta');
        $query="SELECT * FROM tblplancuentas WHERE cpfile='$id_cuenta' order by cpcodigo_plancuentas asc";
        $res = $this->db->query($query);
        return $res->result();
	
    }
    
     public function nuevoplan()
    {
       $descripcion_cuenta= $this->input->post('nombre');
       $idtipo1= $this->input->post('nivelcuenta');
       $idtipo= $this->input->post('tipocuenta');
       
        
        $sqlconsultacuenta="SELECT id_plancuentas, cpcodigo_plancuentas, cpdescripcion_plancuentas, cpnivel, cpestado_plancuentas, cpfile "
                . "FROM  tblplancuentas where cpnivel='$idtipo1' and cpfile='$idtipo' order by id_plancuentas desc limit 1";
        $res = $this->db->query($sqlconsultacuenta);
        foreach($res->result() as $row){
            
            $cod_plan=$row->cpcodigo_plancuentas;
            $cadena = substr($cod_plan, 0, -1); 
            $ultimo = substr($cod_plan, -1);  
            $complemento=$cadena."".($ultimo+1);
           
            $query="INSERT INTO tblplancuentas (cpcodigo_plancuentas, cpdescripcion_plancuentas, cpnivel, cpestado_plancuentas, cpfile) VALUE ('$complemento', '$descripcion_cuenta', '$idtipo1', 'A', '$idtipo')";
            $this->db->query($query);
        }
        return;
    }
    
     public function editarplan()
    {
        $descripcion_cuenta= $this->input->post('nombre');
        $id= $this->input->post('id');
        $sql_update="UPDATE tblplancuentas SET cpdescripcion_plancuentas = '$descripcion_cuenta' WHERE id_plancuentas = '$id'";
        $this->db->query($sql_update);
        return;
    }
    
     public function obtenerplanes($id)
    {
        $query = "SELECT id_plancuentas, cpcodigo_plancuentas, cpdescripcion_plancuentas, cpnivel, cpfile 
                 FROM tblplancuentas where id_plancuentas ='".$id."'";
        $res=$this->db->query($query);
        return $res->result();
    }
    
    
    public function deleteplan($datos)
    {
        $resultado=array(); 
        //obtengo el nombre del objeto
        $query = $this->db->get_where($this->table,array("id_plancuentas"=>$datos['id_plancuentas']));
        $resultado['datos']= $query->row_array();
        
        //elimino el ojeto
        $this->db->delete($this->table, $datos);
        $this->logs->log($this->data["sesion"]["id_usuario"].'  DELETE  tblplanes  '.$datos['id_plancuentas']);
        return;
    }
 
}


?>