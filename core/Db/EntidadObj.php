<?php namespace Db;

use Exception;

class EntidadObj{

	private $campos;
	private $db;
	protected $table;

	public function __construct($table){
		$this->table = $table;
		$this->db = DbHelper::getInstance();
	}
	public function __get($name){
		return $this->campos[$name]->getValue();
	}
	public function __set($name,$value){
		if(!isset($this->campos[$name]))
			throw new Exception($name . " no pertenece al modelo " . $this->table);

		$this->campos[$name]->setValue($value);
	}
	public function getObj($name){
		return $this->campos[$name];
	}

	public function setCampo($nombre,$campo){
		$this->campos[$nombre] = $campo;
	}

	public function grabar(){
		if($this->id){
			$this->db->update($this->table,$this->campos,"id=" . $this->id);
		}else{
			$this->db->insert($this->table,$this->campos);
			$this->id = $this->db->lastInsert();
		}
	}
}