<?php
/**
* Modelo de Inicio de sesión
* */
class musuarios extends CI_Model{ 
    var $table  = "tblusuario";
    
    function __construct()
    {
        parent::__construct();
    }

    public function get_user($user,$password){
        $query ="SELECT usuarios.* FROM usuarios INNER JOIN rol ON usuarios.rol=rol.codigo 
               where usuario= '".strtolower($user)."' and contrasena = '".$password."'";
        $res = $this->db->query($query);
        $usuario= empty($res) ? null : $res->row();
	return $usuario;
    }
    
    public function get_usuarios(){
        $query ="SELECT tblusuario.*,tblrol.cpdescripcion_rol FROM tblusuario INNER JOIN tblrol ON tblusuario.idrol_usuario=tblrol.id_rol";
        $res = $this->db->query($query);
	return array("content"=>$res->result());
    }
    
    public function get_combousuarios(){
        $query ="SELECT tblusuario.* FROM tblusuario";
        $res = $this->db->query($query);
        $usuarios=$res->result();
        return $usuarios;
    }
    
    public function obtenerusuarios($id)
    {
        $result=array();
        $query = $this->db->get_where($this->table,array("id_usuario"=>$id));
        $result['datos']=$query->result();
        $result['us']=$this->obtener_usuariosSub($id);
        return $result;
    }
    
    public function nuevousuarios()
    {
       $resultado=array(); 
       $nombre= $this->input->post('nombre');
       $apellidos= $this->input->post('apellidos');
       $rol= $this->input->post('rol');
       $email= $this->input->post('email');
       $usuario= $this->input->post('usuario');
       $contrasena= $this->input->post('contrasena');
       $color= $this->input->post('color');
        
       $datos=array(
           'nombre'=>$nombre,
           'apellidos'=>$apellidos,
           'email'=>$email,
           'usuario'=>$usuario,
           'contrasenna'=>$contrasena,
           'idrol_usuario'=>$rol,
           'cpcolor_usuario'=>$color
          
       );
       //verifico que el usuarios no este insertado ya
       $query ="SELECT tblusuario.* FROM tblusuario WHERE usuario='".$datos['usuario']."'";
       $res = $this->db->query($query);
       if($res->num_rows() > 0 )
        {
            $resultado['error']=1;
            $resultado['mensaje']="Este nombre de usuario ya ha sido ingresado anteriormente.";
        }
        else
        {
           //inserto en la tabla objetos 
           $this->db->insert($this->table,$datos);
           $id_insertado=$this->db->insert_id();
           $this->logs->log($this->data["sesion"]["id_usuario"].'  INSERT  Usuarios  '.$id_insertado);
           
           $val=$this->input->post('destino[]');
           //recorro los usuarios subordinados si el usuario nuevo es administrador de grupo
           if(($rol=='5' || $rol=='6') && isset($val)){
            foreach ($this->input->post('destino[]') as $llave=>$valor)
            {
              
                 $d=array(
                     'id_usuario'=>$valor,
                     'id_administrador'=>$id_insertado,
                 );  
                 $this->db->insert('usuarios_controlados',$d);
             }
           }
           
           //formo el array con los valores a devolver
           $this->db->select('tblrol.cpdescripcion_rol as n_rol,tblusuario.*');
           $this->db->from($this->table);
           $this->db->join('tblrol', 'tblusuario.idrol_usuario = tblrol.id_rol','INNER');
           $this->db->where('tblusuario.id_usuario', $id_insertado);
           $query = $this->db->get();
           
           $resultado['error']=0;
           $resultado['mensaje']="El usuario <strong>". $datos['nombre']."</strong> ha sido insertado satisfactoriamente.";
           $resultado['datos']= $query->result();
        }
        return $resultado;
    }
    
    public function updateusuarios($data="")
    {
       $resultado=array(); 
       $id= $this->input->post('id');
       $nombre= $this->input->post('nombre');
       $apellidos= $this->input->post('apellidos');
       $rol= $this->input->post('rol');
       $email= $this->input->post('email');
       $usuario= $this->input->post('usuario');
       $contrasena= $this->input->post('contrasena');
       $color= $this->input->post('color');
             
       $datos=array(
           'id_usuario'=>$id,
           'nombre'=>$nombre,
           'apellidos'=>$apellidos,
           'email'=>$email,
           'usuario'=>$usuario,
           'contrasenna'=>$contrasena,
           'idrol_usuario'=>$rol,
           'cpcolor_usuario'=>$color
       );
       
       //verifico que el usuarios no este insertado ya
       $query ="SELECT tblusuario.* FROM tblusuario WHERE usuario='".$datos['usuario']."' AND id_usuario!='".$id."'";
       $res = $this->db->query($query);
       if($res->num_rows() > 0 )
        {
            $resultado['error']=1;
            $resultado['mensaje']="Este nombre de usuario ya ha sido ingresado anteriormente.";
        }
        else
        {
           //inserto en la tabla objetos 
            $this->db->where('id_usuario', $datos['id_usuario']);
            $this->db->update($this->table, $datos);
            $this->logs->log($this->data["sesion"]["id_usuario"].'  UPDATE  Usuarios  '.$datos['id_usuario']);
           
            //recorro los usuarios subordinados si el usuario nuevo es administrador de grupo
           //eliino de los usuarios controlados todo lo que tenga el id del usuario que s eesta editando
           $this->db->delete('usuarios_controlados', array('id_administrador'=>$id)); 
           $val=$this->input->post('destino[]');
           if(($rol=='5' || $rol=='6') && isset($val)){
            
                foreach ($this->input->post('destino[]') as $llave=>$valor)
                {

                     $d=array(
                         'id_usuario'=>$valor,
                         'id_administrador'=>$id,
                     );  
                     $this->db->insert('usuarios_controlados',$d);
                }
           }
            
            
           //formo el array con los valores a devolver
           $this->db->select('tblrol.cpdescripcion_rol as n_rol,tblusuario.*');
           $this->db->from($this->table);
           $this->db->join('tblrol', 'tblusuario.idrol_usuario = tblrol.id_rol','INNER');
           $this->db->where('tblusuario.id_usuario', $datos['id_usuario']);
           $query = $this->db->get();
           
           $resultado['error']=0;
           $resultado['mensaje']="El usuario <strong>". $datos['nombre']."</strong> ha sido actualizado satisfactoriamente.";
           $resultado['datos']= $query->result();
        }
        return $resultado;
    }
    
    public function deleteusuarios($datos)
    {
        $resultado=array(); 
        //obtengo el nombre del objeto
        $query = $this->db->get_where($this->table,array("id_usuario"=>$datos['id_usuario']));
        $resultado['datos']= $query->row_array();
        
        //elimino el ojeto
        $this->db->delete($this->table, $datos);
        $this->logs->log($this->data["sesion"]["id_usuario"].'  DELETE  Usuarios  '.$datos['id_usuario']);
        $resultado['error']=0;
        $resultado['mensaje']="El usuario <strong>". $resultado['datos']['nombre']."</strong> ha sido eliminado satisfactoriamente.";
        return $resultado;
    }
    
    /////////obtener roles//////////
    public function obtener_roles(){
        $query ="SELECT * FROM tblrol";
        $res = $this->db->query($query);
	return $res->result();
    }
    
    public function obtener_usuarionormales()
    {
        $id= $this->input->post('id');
        $rol= $this->input->post('rol');
        if($id!='nuevo')
        {
            //busco el id y el rol del usuario
            $query="SELECT tblusuario.id_usuario,tblusuario.idrol_usuario FROM tblusuario WHERE id_usuario='".$id."'";
            $res = $this->db->query($query);
           
            //busco todos los usuarios que el tenga asignados
            $query ="SELECT tblusuario.* FROM  usuarios_controlados
                INNER JOIN tblusuario ON tblusuario.id_usuario = usuarios_controlados.id_usuario
                WHERE usuarios_controlados.id_administrador='".$id."'";
            $res1 = $this->db->query($query);
           
            //busco en la tabla usuarios los usuarios que puedan ser y que no esten asignados
            $query2 ="SELECT * FROM  tblusuario WHERE tblusuario.idrol_usuario != '1'";
            
            //si es jefe de area solo vera los jefes de grupo y normales
            if($res->row()->idrol_usuario=='6')
               $query2.=" AND tblusuario.idrol_usuario !='6' AND tblusuario.id_usuario !='".$id."'";
            if($res->row()->idrol_usuario=='5')
               $query2.=" AND tblusuario.idrol_usuario !='5' AND tblusuario.idrol_usuario !='6' AND tblusuario.id_usuario !='".$id."'";
            
            foreach ($res1->result() as $val)
            {
                $query2.=" AND tblusuario.id_usuario!='".$val->id_usuario."'";
            }
            
            $res = $this->db->query($query2);
        }
        else
        {
            //si el rol es jefe de area, busco los jefes de grupo y usuarios normales
            if($rol=='6')
            {
              $query2 ="SELECT * FROM tblusuario WHERE tblusuario.idrol_usuario != '1' AND tblusuario.idrol_usuario != '6'";  
            }
            else if($rol=='5')
            {
              $query2 ="SELECT * FROM tblusuario WHERE tblusuario.idrol_usuario != '1' AND tblusuario.idrol_usuario != '5' AND tblusuario.idrol_usuario != '6'";  
            }
            
            //si no esta vacio significa que estoy editando un usuario existente
            $user=$this->input->post('user');
            if($user!=""){
              $query2 .=" AND tblusuario.id_usuario != '".$user."'";
            }
            $res = $this->db->query($query2);
        }
        
	return $res->result();
    }
    
    public function obtener_usuariosSub($id)
    {
        $query ="SELECT tblusuario.* FROM  usuarios_controlados
                INNER JOIN tblusuario ON tblusuario.id_usuario = usuarios_controlados.id_usuario
                WHERE usuarios_controlados.id_administrador='".$id."'";
        $res = $this->db->query($query);
	return $res->result();
    }
}


?>