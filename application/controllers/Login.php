<?php
require_once  APPPATH.'libraries/admin_controller.php';

class login extends admin_controller{
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


    }