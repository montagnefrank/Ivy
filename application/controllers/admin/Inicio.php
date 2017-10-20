<?php
require_once  APPPATH.'libraries/admin_controller.php';

class Inicio extends admin_controller{
    var $package="admin";
    var $id="inicio";
    var $sesion;
   
    //Siempre se ejecuta cuando se llama a esta clase antes de ejecutarse cualquier funcion
    function __construct(){
        //Se llama al controlador padre personalizado, hace casi todo el W.
        parent::admin_controller();
       
        // Load session library
        $this->check_setup();
        $this->removeCache();
    }

    function index(){
        parent::check_login();	//Porque este no tiene que ver con la sesion
        $this->data["active_sub_tab"]="inicio";
        $this->data["title"] = "Autentificación";
        $this->show_view();
    }


	//Muestra el cartel de inicio de sesion
	function sesion($accion=""){
            $this->data["active_sub_tab"]="sesion";
            $this->data["title"] = "Inicio de Sesion";
            switch($accion){
                case "cerrar":
                        $this->close_session();
                        $this->session->set_flashdata('message','¡Se cerró la sesión con éxito!');
                        $this->regresar($this->package.'/inicio/sesion');
                        break;
                case "iniciar":
                        $this->cuenta();
                        break;
                default:
                       $this->show_view();
            }
	}
                
        
        // Check for user login process
        public function cuenta() {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('usuario', 'Username', 'trim|required');
            $this->form_validation->set_rules('contrasena', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                if(isset($this->session->userdata['logged_in'])){
                   $this->show_view("panel");
                   
                }else{
                   $this->show_view();
                }
            }
            else
            {
                $data = array(
                    'username' => $this->input->post('usuario'),
                    'password' => $this->input->post('contrasena')
                );
                $this->data["sesion"]["usuario"] = $this->mydata->get_user($data);
                if(!empty($this->data["sesion"]["usuario"]))	//Si el login es valido
                {
                    $username = $this->input->post('usuario');
                    $result = $this->mydata->read_user_information($username);
                   
                    if ($result != false) {
                        $session_data = array(
                            'usuario' => $result[0]->usuario,
                            'id_usuario' => $result[0]->id_usuario,
                            'rol' => $result[0]->cpdescripcion_rol
                        );
                        //Update shopping cart session data
                        $this->session->set_userdata( 'logged_in', $session_data );
                        
                        
                        $this->logs->log($result[0]->usuario."  INICIO SESION");
                        $this->data['id']='panel';
                        redirect(base_url().'admin/panel','refresh');
                        
                    }
                } else {
                    $this->data['error_message']= 'Usuario o Contraseña Incorrectos';
                    $this->show_view();
                }
            }
        }
        
        // Logout from admin page
        public function logout()
        {
            $this->data["title"] = "Cierre de Sesión Satisfactorio";
            // Removing session data
            $sess_array = array(
                'usuario' => ''
            );
            $this->session->unset_userdata('logged_in', $sess_array);
            $this->data['message_display'] = 'Cierre de Sesión Satisfactorio';
            $this->show_view();
        }
        
        
        
        
	/**
	* Muestra la interfaz grafica de un controlador cualquiera
	* @param <array> $data Parametros a pasar donde $data["views"] son las vistas y el resto son parametros
	*/
	 function show_view($tipo=""){
             if($tipo==""){
                $this->data['id']='inicio';
		$this->load->vars($this->data);
		$this->load->view($this->package."/common/inicio");
                $this->load->view($this->package."/body/inicio/inicio");
		$this->load->view($this->package."/common/footer");
             }
             else if($tipo=="panel")
             {
                $this->data['id']='panel';
                $this->load->vars($this->data);
		$this->load->view($this->package."/common/inicio");
                $this->load->view($this->package."/common/cabecera");
                $this->load->view($this->package."/body/panel/panel");
		$this->load->view($this->package."/common/footer");
             }
	}
    }