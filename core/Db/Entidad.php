<?php namespace Db;

use \Db\EntidadObj;
use ArrayAccess;

use Iterator;
use IteratorAggregate;

class Entidad implements ArrayAccess, IteratorAggregate{
	public function crear($params = array()){
		$campos = $this->init();

		$tabla = get_called_class();

		$obj = new EntidadObj($tabla);
		
		foreach($campos as $k => $v){
			$obj->setCampo($k,$v);			
		}
		foreach ($params as $k => $v) {
			$obj->{$k} = $v;
		}
		return $obj;
	}

	public function all(){
		echo "Trayendome todos los registros\n";
		return $this;
	}
	public function filter(){
		echo "Filtrados\n";
		return $this;
	}

	public function makeQuery(){
		$this->data = array(
			array(
				'titulo' => 'primero',
				'numero' => 1
			),
			array(
				'titulo' => 'segundo',
				'numero' => 2
			),
			array(
				'titulo' => 'tercero',
				'numero' => 3
			)
		);
	}

	#IteratorAggregate
	public function getIterator(){
		if(empty($this->data))
			$this->makeQuery();
		return new MyIterator($this,$this->data);
	}

	#ArrayAccess
	public function offsetGet($offset){
		if(empty($this->data))
			$this->makeQuery();
		return isset($this->data[$offset]) ? $this->crear($this->data[$offset]) : null;
	}
	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->data[] = $value;
		} else {
			$this->data[$offset] = $value;
		}
	}
	public function offsetExists($offset) {
		return isset($this->data[$offset]);
	}
	public function offsetUnset($offset) {
		unset($this->data[$offset]);
	}
}


class MyIterator implements Iterator
{
    private $var = array();
    private $modelo;
    
    public function __construct($modelo,$array)
    {
        //if (is_array($array)) {
    		$this->modelo = $modelo;
            $this->var = $array;
        //}
    }
    public function rewind()
    {
        #echo "rewinding\n";
        reset($this->var);
    }
    public function current()
    {
        $var = current($this->var);
        #echo "current: $var\n";
        return $this->modelo->crear($var);
    }
    public function key()
    {
        $var = key($this->var);
        #echo "key: $var\n";
        return $var;
    }
    public function next()
    {
        $var = next($this->var);
        #echo "next: $var\n";
        return $var;
    }
    public function valid()
    {
        $key = key($this->var);
        $var = ($key !== NULL && $key !== FALSE);
        #echo "valid: $var\n";
        return $var;
    }
}