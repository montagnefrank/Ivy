<?php
require_once  APPPATH.'libraries/admin_controller.php';

class Pendientes extends admin_controller{
    var $package="admin";
    var $id="pendientes";
    
    //Siempre se ejecuta cuando se llama a esta clase antes de ejecutarse cualquier funcion
    function __construct(){
        parent::__construct();
        $this->check_login();
        $this->check_setup();
        $this->removeCache();
    }

    function index(){
        $this->data["active_sub_tab"]="listado";
        $this->data["title"] = "Listado de Pendientes";
        $this->load->model('musuarios');
        $this->data['usuarios']=$this->musuarios->get_combousuarios();
        $this->data = array_merge($this->data,$this->mydata->get_pendientes());
        $this->show_me('listado');
    }
    
    public function nuevopendiente()
    {
       $nombre= nl2br($this->input->post('nombre'));
       
       $usuario= $this->input->post('usuario');
       $prioridad=$this->input->post('prioridad');
       $fecha= $this->input->post('fecha');
       $hora=$this->input->post('hora');
       
       
       $datos=array(
           'nombre'=>$nombre,
           'usuario'=>$usuario,
           'fecha'=>$fecha,
           'hora'=>$hora,
           'prioridad'=>$prioridad
        );
       
       $resp=$this->mydata->nuevopendiente($datos);

       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function editarpendiente()
    {
       $id= $this->input->post('id');
       $nombre= nl2br($this->input->post('nombre'));
       $usuario= $this->input->post('usuario');
       $prioridad=$this->input->post('prioridad');
       $fecha= $this->input->post('fecha');
       $hora=$this->input->post('hora');
       
       
       $datos=array(
           'id_pendiente'=>$id,
           'cpdescripcion'=>$nombre,
           'cpasignar_usuario'=>$usuario,
           'cpfecha'=>$fecha,
           'cphora'=>$hora,
           'cpprioridad_pendiente'=>$prioridad
        );
       
       $resp=$this->mydata->updatependiente($datos);       
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function aprobar_pendiente()
    {
       $resp=$this->mydata->updatependienterealizado();
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function eliminarpendiente()
    {
       $id= $this->input->post('id');
             
        $datos=array(
           'id_pendiente'=>$id
        );
       
       $resp=$this->mydata->deletependiente($datos);       
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function obtener_pendiente()
    {
        $id= $this->input->post('id');
        $resp=$this->mydata->get_pendientes_byID($id);       
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function obtener_pendiente1($id)
    {
        //$id= $this->input->post('id');
        $this->data["active_sub_tab"]="pendiente";
        $this->data["title"] = "Listado de Pendientes";
        $this->data["pend"]=$this->mydata->get_pendientes_byID2($id);
        $this->show_me();
    }
    
    public function obtener_todospendiente()
    {
        $this->data["active_sub_tab"]="pendiente";
        $this->data["title"] = "Listado de Pendientes";
        $this->data["pend"]=$this->mydata->get_todospendientes();
        $this->show_me();
    }
    
    
}