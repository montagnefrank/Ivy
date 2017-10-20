<?php
require_once  APPPATH.'libraries/admin_controller.php';

class Proveedor extends admin_controller{
    var $package="admin";
    var $id="proveedor";
    
    //Siempre se ejecuta cuando se llama a esta clase antes de ejecutarse cualquier funcion
    function __construct(){
        parent::__construct();
        $this->check_login();
        $this->check_setup();
        $this->removeCache();
    }

    function index(){
        $this->data["active_sub_tab"]="listado";
        $this->data["title"] = "Proveedor";
        $this->data["codigo"]=$this->mydata->codigo_plan();
        $this->data = array_merge($this->data,$this->mydata->get_proveedor());
        $this->show_me('listado');
    }
    
    public function listado_proveedor()
    {
        $listado_proveedor=$this->mydata->get_proveedor();
        $this->output->set_content_type('application/json')->set_output(json_encode($listado_proveedor));
    }
    
    public function nuevoproveedor()
    {
        
       $resp=$this->mydata->nuevoproveedor(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function editarproveedor()
    {
       $resp=$this->mydata->updateproveedor(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    //obtengo un proveedor por su id
    public function obtener_proveedor()
    {
        $id= $this->input->post('id');
        $resp=$this->mydata->obtenerproveedor($id);       
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
        
    public function eliminarproveedor()
    {
       $id= $this->input->post('id');
             
       $datos=array(
           'id_proveedor'=>$id
        );
       
       $resp=$this->mydata->deleteproveedor($datos);       
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function codigonuevo()
    {        
       $resp=$this->mydata->codigo_plan(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
}