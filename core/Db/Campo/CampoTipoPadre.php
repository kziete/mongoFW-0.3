<?php namespace Db\Campo;

class CampoTipoPadre{
	protected $value;
	public function setValue($value){
		$this->validar($value);
		$this->value = $this->createValue($value);
	}
	public function getValue(){
		return $this->value;
	}
	public function __toString(){

		return (String)$this->value;
	}
	public function validar($valor){

	}
	public function createValue($value){
		return $value;
	}
}
