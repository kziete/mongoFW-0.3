<?php namespace Db;

class EntidadObj{

	private $campos;
	protected $tabla;

	public function __construct($tabla){
		$this->tabla = $tabla;
	}
	public function __get($name){
		return $this->campos[$name];
	}
	public function __set($name,$value){
		if(!isset($this->campos[$name]))
			throw new Exception($name . " no pertenece al modelo " . $this->tabla);

		$this->campos[$name]->setValue($value);
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
	public function all(){
		echo "Trayendome todos los registros\n";
		return $this;
	}
	public function filter(){
		echo "Filtrados\n";
		return $this;
	}

}