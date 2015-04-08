<?php namespace Db\Campo;

use DateTime;

class CampoFechaHora extends CampoTipoPadre{
	public function validar($fecha){
		$d = DateTime::createFromFormat('Y-m-d H:i:s', $fecha);
    	if(!($d && $d->format('Y-m-d H:i:s') == $fecha))
    		throw new Exception("Formato inválido para fecha");

	}
	public function createValue($newValue){
		if($newValue instanceof DateTime)
			return $newValue;
		else
			return new DateTime($newValue);
		
	}
	public function __toString(){
		return $this->value->format('Y-m-d H:i:s');
	}
}