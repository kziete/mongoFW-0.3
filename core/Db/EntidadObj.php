<?php namespace Db;

class EntidadObj{

	private $campos;
	protected $tabla;

	public function __construct($tabla){
		$this->tabla = $tabla;
	}
	public function __get($name){
		return $this->campos[$name]->getValue();
	}
	public function __set($name,$value){
		if(!isset($this->campos[$name]))
			throw new Exception($name . " no pertenece al modelo " . $this->tabla);

		$this->campos[$name]->setValue($value);
	}
	public function getObj($name){
		return $this->campos[$name];
	}

	public function setCampo($nombre,$campo){
		$this->campos[$nombre] = $campo;
	}

	public function grabar(){
		echo "Grabando: " . $this->tabla . "\n";
		foreach($this->campos as $k => $v)
			echo $k . ": " . $v . "\n";
		//print_r($this->datos);
	}
}