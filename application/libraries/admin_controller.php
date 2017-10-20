<?php
class admin_controller extends CI_Controller{
	var $package; 	
	protected $id;	  
	var $data;
	
	function admin_controller()
	{
            parent::__construct();
            $this->load->helper('form');
            $this->load->helper('date');
            $this->config->load("global");
            $this->config->load($this->package."/general");
            $this->default_url = site_url($this->package.'/'.$this->id);
            if(empty($this->data))
            {
                $this->data = array();
            }

            $this->data= array_merge($this->data,$this->config->item($this->package),$this->config->item("global"));
            $this->data["package_id"]=$this->package;
            $this->data["active_tab"]=$this->id;
     
            $this->data["css"]=array("estilos","alertify.core","alertify.default");

            $this->data["scripts"]=array("jquery.min","script","alertify.min");
            //Carga el modelo correspondiente en mydata.
            $this->load_model();
            
            if(isset($this->session->userdata['logged_in']['id_usuario'])){
                ///buscando las alarmas
                $this->load->model('mpanel');
                $this->data["alarmas"]=  $this->mpanel->buscar_detallesalarmas();
            }
            
	}

        function index()
        {
	  $this->show_me();
	}


    //Carga cualquier modelo dependiendo de su parametro id en mydata
    protected function load_model($id="",$pseudo="mydata")
    {
        $toload=(trim($id)!="")?($id):($this->id);
        $this->load->model("m".$toload,$pseudo);
    }
    
    function show_me($vista=""){
       $this->show_data($this->id,(trim($vista)=="") ? ($this->data["active_sub_tab"]):($vista));
    }

	/**
	* Muestra la interfaz grafica de un controlador cualquiera
	* @param <array> $data Parametros a pasar donde $data["views"] son las vistas y el resto son parametros
	*/
	protected function show_view(){
		$this->load_views($this->id,(trim($vista)=="") ? ($this->data["active_sub_tab"]):($vista));
	}

	//Muestra las vistas correspondientes segun el packete y el segmento activo
	protected function show_data($id,$sub_tab){
//            $this->data["item_name"] = ($sub_tab == "listado"  || empty($this->data["content"]) || is_array($this->data["content"]))? "" : $this->mydata->getDescripcion($this->data["content"]);
//            $title_tpl = $this->data["titles"][$sub_tab];
//            $this->data["title"] = $this->parser->parse_string($title_tpl,array(
//			"elemento"=> $this->data["item_name"]
//		),TRUE);

		$this->load_views($id);
        }
        
    //Carga los archivos de las vistas
	protected function load_views($id){
        
            $this->load->vars($this->data);
            $this->load->view($this->package."/common/inicio");
            $this->load->view($this->package."/common/cabecera");
            $this->load->view($this->package."/body/$id/".$this->data["active_sub_tab"]);
            $this->load->view($this->package."/common/footer");
	}

    //Esta fucnion chequea el archivo de configuracion con los parametros de la DB
	protected function check_setup(){
            if(!$this->load_database()){
                show_error("No se puede realizar una conexión a la base de datos. Pruebe reintentarlo más tarde.",500,"Error de conexión");
            }
	}

        protected function check_login(){
		if($this->session->userdata('logged_in')==FALSE){
			$this->regresar($this->package.'/inicio/sesion','refresh');
		}
		$this->data["sesion"]["usuario"] = $this->session->userdata['logged_in']['usuario'];
                $this->data["sesion"]["id_usuario"] = $this->session->userdata['logged_in']['id_usuario'];
                $this->data["sesion"]["rol"] = $this->session->userdata['logged_in']['rol'];
		
         }
	

    //Carga los parametros de base de datos
    protected function load_database()
    {
        if(isset($this->db))
            $this->db->close();
        
       	$result=$this->load->database();
      	$result = $this->db->db_connect();
        return $result;
    }

    
    
    //Cambia de la ruta actual a la especificada
    function regresar($url){
        $redirect = $this->input->get_post("redirect",TRUE);
        redirect((empty($redirect) ? $url : $redirect),"refresh");
    }

   
    public function removeCache()
    {
        $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
        $this->output->set_header('Pragma: no-cache');
    }    
    
   

}