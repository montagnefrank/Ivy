<?php
require_once  APPPATH.'libraries/admin_controller.php';

class Planes extends admin_controller{
    var $package="admin";
    var $id="planes";
    
    //Siempre se ejecuta cuando se llama a esta clase antes de ejecutarse cualquier funcion
    function __construct(){
        parent::__construct();
        $this->check_login();
        $this->check_setup();
        $this->removeCache();
    }

    function index(){
        $this->data["active_sub_tab"]="listado";
        $this->data["title"] = "Planes";
        $this->data = array_merge($this->data,$this->mydata->get_tipocuenta(),$this->mydata->get_planes());
        $this->show_me('listado');
    }
    
    public function obtenercodigo()
    {
        $resp=$this->mydata->obtenercodigo();
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
     public function nuevoplan()
    {
        
       $resp=$this->mydata->nuevoplan(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    public function editarplan()
    {
       $resp=$this->mydata->editarplan(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
     //obtengo un clientes por su id
    public function obtener_planes()
    {
        $id= $this->input->post('id');
        $resp=$this->mydata->obtenerplanes($id);       
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function eliminarplan()
    {
       $id= $this->input->post('id');
             
       $datos=array(
           'id_plancuentas'=>$id
        );
       
       $resp=$this->mydata->deleteplan($datos);       
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
}