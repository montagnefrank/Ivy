<?php
require_once  APPPATH.'libraries/admin_controller.php';

class Productos extends admin_controller{
    var $package="admin";
    var $id="productos";
    
    //Siempre se ejecuta cuando se llama a esta clase antes de ejecutarse cualquier funcion
    function __construct(){
        parent::__construct();
        $this->check_login();
        $this->check_setup();
        $this->removeCache();
    }

    function index(){
        $this->data["active_sub_tab"]="listado";
        $this->data["title"] = "Productos";
        $this->data = array_merge($this->data,$this->mydata->get_productos());
        $this->show_me('listado');
    }
    
    public function listado_productos()
    {
        $listado_productos=$this->mydata->get_productos();
        $this->output->set_content_type('application/json')->set_output(json_encode($listado_productos));
    }
    
    public function nuevoproductos()
    {
        
       $resp=$this->mydata->nuevoproductos(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function editarproductos()
    {
       $resp=$this->mydata->updateproductos(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    //obtengo un productos por su id
    public function obtener_productos()
    {
        $id= $this->input->post('id');
        $resp=$this->mydata->obtenerproductos($id);       
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
   public function buscarproductos()
   {
        $datos= $this->input->get('q');
        $resp=$this->mydata->buscarproductos($datos);       
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
   }
        
    public function eliminarproductos()
    {
       $id= $this->input->post('id');
             
       $datos=array(
           'id_producto'=>$id
        );
       
       $resp=$this->mydata->deleteproductos($datos);       
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function codigonuevo()
    {        
       $resp=$this->mydata->codigo_plan(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
}