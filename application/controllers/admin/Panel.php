<?php
require_once  APPPATH.'libraries/admin_controller.php';

class Panel extends admin_controller{
   var $package="admin";
   var $id="panel";
   
    
//Siempre se ejecuta cuando se llama a esta clase antes de ejecutarse cualquier funcion
    function __construct(){
        parent::__construct();
        $this->check_login();
        $this->check_setup();
    }
    
    function index(){
        $this->data["active_sub_tab"]="panel";
        $this->data["title"] = "Sistema de Gestión de Burton Tech";
        $this->load->model('mpanel');
        $this->data['datos'] = $this->mpanel->obtenerAlarmas();
        $this->show_me();
    }

    public function buscar_alarmas()
    {
        $resp=$this->mydata->buscar_alarmas();
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    /**
    * Muestra la interfaz grafica de un controlador cualquiera
    * @param <array> $data Parametros a pasar donde $data["views"] son las vistas y el resto son parametros
    */
     function show_view(){ 
        $this->load->vars($this->data);
        $this->load->view($this->package."/common/inicio");
        $this->load->view($this->package."/common/cabecera");
        $this->load->view($this->package."/body/panel/panel");
        $this->load->view($this->package."/common/footer"); 
    }
}