<?php namespace Db;

use \Db\EntidadObj;
use ArrayAccess;

use Iterator;
use IteratorAggregate;

class Entidad implements ArrayAccess, IteratorAggregate{
	public function __construct(){
		$this->table = get_called_class();
		$this->db = DbHelper::getInstance();
	}
	public function crear($params = array()){
		$campos = $this->init();

		$obj = new EntidadObj($this->table);
		
		$obj->setCampo("id", new Campo\CampoId());

		foreach($campos as $k => $v){
			$obj->setCampo($k,$v);			
		}
		foreach ($params as $k => $v) {
			$obj->{$k} = $v;
		}
		return $obj;
	}

	public function makeQuery(){
		$sql = "select * from " . $this->table;
		$params = array();
		if(!empty($this->filtros)){
			$where = $this->getWhere($this->filtros);
			$sql .= $where['where'];
			$params = $where['params'];
		}
		#$sql .= ' where ' . join("=? and ",array_keys($this->filtros)) . "=?";			
		if($this->orden)
			$sql .= ' order by ' . $this->orden;
		$query = $this->db->sql($sql,$params);
		$this->data = $this->db->fetch($query);
	}

	public function getWhere($filtros){
		$wheres = array();
		$params = array();
		foreach ($filtros as $field => $value) {
			$field_parts = explode("__",$field);
			if($field_parts[1]){
				switch($field_parts[1]){
					case 'like':
						$wheres[] = $field_parts[0] . ' like ?';
						$params[] = '%' . $value . '%';
						break;
					case 'gt':
						$wheres[] = $field_parts[0] . ' > ?';
						$params[] = $value;
						break;
					case 'gte':
						$wheres[] = $field_parts[0] . ' >= ?';
						$params[] = $value;
						break;
					case 'lt':
						$wheres[] = $field_parts[0] . ' < ?';
						$params[] = $value;
						break;
					case 'lte':
						$wheres[] = $field_parts[0] . ' <= ?';
						$params[] = $value;
						break;
				}
			}else{
				$wheres[] = $field . '=?';
				$params[] = $value;
			}
		}
		return array(
			'where' => count($wheres) > 0 ? " where " . join(' and ', $wheres) : "",
			'params' => $params
		);
	}
	public function filter($filtros=array()){
		$this->resetData();
		$this->filtros = $filtros;
		return $this;
	}
	public function orderBy($orden='id asc'){
		$this->resetData();
		$this->orden = $orden;
		return $this;
	}
	public function rawData(){
		if(empty($this->data))
			$this->makeQuery();
		return $this->data;
	}
	public function resetData(){
		$this->data = array();
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