<?php
require_once  APPPATH.'libraries/admin_controller.php';

class Clientes extends admin_controller{
    var $package="admin";
    var $id="clientes";
    
    //Siempre se ejecuta cuando se llama a esta clase antes de ejecutarse cualquier funcion
    function __construct(){
        parent::__construct();
        $this->check_login();
        $this->check_setup();
        $this->removeCache();
    }

    function index(){
        $this->data["active_sub_tab"]="listado";
        $this->data["title"] = "Clientes";
        $this->data["codigo"]=$this->mydata->codigo_plan();
        $this->data = array_merge($this->data,$this->mydata->get_clientes());
        $this->show_me('listado');
    }
    
    public function listado_clientes()
    {
        $listado_clientes=$this->mydata->get_clientes();
        $this->output->set_content_type('application/json')->set_output(json_encode($listado_clientes));
    }
    
    public function nuevoclientes()
    {
        
       $resp=$this->mydata->nuevoclientes(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function editarclientes()
    {
       $resp=$this->mydata->updateclientes(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    //obtengo un clientes por su id
    public function obtener_clientes()
    {
        $id= $this->input->post('id');
        $resp=$this->mydata->obtenerclientes($id);       
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
   public function buscarclientes()
   {
        $datos= $this->input->get('q');
        $resp=$this->mydata->buscarclientes($datos);       
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
   }
        
    public function eliminarclientes()
    {
       $id= $this->input->post('id');
             
       $datos=array(
           'id_cliente'=>$id
        );
       
       $resp=$this->mydata->deleteclientes($datos);       
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function codigonuevo()
    {        
       $resp=$this->mydata->codigo_plan(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
}