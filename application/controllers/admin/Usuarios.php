<?php
require_once  APPPATH.'libraries/admin_controller.php';

class Usuarios extends admin_controller{
    var $package="admin";
    var $id="usuarios";
    
    //Siempre se ejecuta cuando se llama a esta clase antes de ejecutarse cualquier funcion
    function __construct(){
        parent::__construct();
        $this->check_login();
        $this->check_setup();
        $this->removeCache();
    }

    function index(){
        $this->data["active_sub_tab"]="listado";
        $this->data["title"] = "Usuarios";
        $this->data["roles"]=$this->mydata->obtener_roles();
//        $this->data["usuariosSub"]=$this->mydata->obtener_usuarionormales();
//        $this->data["usuariosSub2"]=$this->mydata->obtener_usuariosSub();
        
        $this->data = array_merge($this->data,$this->mydata->get_usuarios());
        $this->show_me('listado');
    }
    
    public function listado_usuarios()
    {
        $listado_usuarios=$this->mydata->get_usuarios();
        $this->output->set_content_type('application/json')->set_output(json_encode($listado_usuarios));
    }
    
    public function nuevousuarios()
    {
        
       $resp=$this->mydata->nuevousuarios(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function editarusuarios()
    {
       $resp=$this->mydata->updateusuarios(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    //obtengo un usuario por su id
    public function obtener_usuarios()
    {
        $id= $this->input->post('id');
        $resp=$this->mydata->obtenerusuarios($id);       
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    //obtengo los usuarios que pueden ser subordinados
    public function url_obtener_posibles_usuariossub()
    {
        
        $resp['us']=$this->mydata->obtener_usuarionormales();       
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
     public function obtener_roles()
    {
        $resp=$this->mydata->obtener_roles();       
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
        
    public function eliminarusuarios()
    {
       $id= $this->input->post('id');
             
       $datos=array(
           'id_usuario'=>$id
        );
       
       $resp=$this->mydata->deleteusuarios($datos);       
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
}