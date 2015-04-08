<?php namespace Db\Campo;

class CampoInteger extends CampoTipoPadre{
	public function validar($value){
		if(!is_numeric($value))
			throw new Exception("Este campo acepta solo Números");
	}
}