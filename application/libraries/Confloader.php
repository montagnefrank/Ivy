<?php
/***
*@author EliuX 2010
*@descrip Cargador de datos persistentes simples-no-relacionales
***/

class confloader{
	var $ci_ptr;
	var $file_name;	//Indica el nombre del ultimo archivo cargado
	var $file_path;
	var $format="json";
	var $subfolder="config";
	var $demons=array("json"=>array("decode"=>"json_decode","encode"=>"json_encode"));
	var $data=array();

	function __construct()
	{
		$this->ci_ptr=& get_instance();
	}

	function set_filename($nombre){
		$this->file_name=$nombre.".".$this->format;
		$this->file_path=APPPATH.$this->subfolder."/".$this->file_name;
	}

	function load_config(){
		//Si no se ha cargado lo cargo
		if(!$this->exist($this->file_name)){
			$converted=file_get_contents($this->file_path);
			$func=$this->demons[$this->format]["decode"];
			$this->data[$this->file_name]= $func($converted);
		}
		return $this->data[$this->file_name];
	}

	//Devuelve el arreglo de los ultimos datos guardados
	function get_data($index=""){
		return $this->data[(($this->exist($index)))?($index):($this->file_name)];
	}
	
	
	function set_data($valor,$property,$index=""){
		$this->data[(($this->exist($index)))?($index):($this->file_name)]->$property=$valor;
	}

	//Dice si un elemento ya fue cargado
	function exist($index=""){
		return (array_key_exists(trim($index),$this->data));
	}


	/**
	* @param array $data Arreglo con los datos a guardar
	* @param string $file_name Nombre unico del archivo (sin la extension)
	* @param string $format Formato en que sera codificado
	* @return object Datos convertidos en formato Object
	*/
	function put_config(){ 
		$func=$this->demons[$this->format]["encode"];
		$converted= $func($this->get_data());
		file_put_contents($this->file_path,$converted);
		return $converted;
	}

	/**
	* Funcion que permite agregar o actualizar los datos de los datos.
	* @param undefined $new_data
	* @return Devuelve la combinacion de ambos arreglos
	*/
	function update($new_data){
		$this->load_config();
		$datos = $this->get_data();
		foreach($new_data as $key=>$value){  
			$this->set_data($value,$key);
		}
		$this->put_config(); 
		return $this->get_data();
	}

	/**
	*  Devuelve los datos de este objeto
	*/
	function __toString()
	{
		$buffer="";
		foreach($this->data as $key=>$value){
			$buffer.="$key = $value<br>";
		}
		return $buffer;
	}

}