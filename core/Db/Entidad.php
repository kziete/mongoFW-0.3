<?php namespace Db;

use \Db\EntidadObj;

class Entidad{
	public static function crear(){
		$campos = static::init();

		$tabla = get_called_class();

		$obj = new EntidadObj($tabla);
		
		foreach($campos as $k => $v){
			$obj->setCampo($k,$v);			
		}
		return $obj;
	}
	public static function getCampos(){

	}
}