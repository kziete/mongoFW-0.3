<?php  namespace Db;

use Exception;

class DbHelper {

	private $ado = null;
	private $conn;

	public function __construct(){  

		$config = new \Doctrine\DBAL\Configuration(); 
		$connectionParams = array(
			'dbname' => DATABASE,
			'user' => USER,
			'password' => PASSWORD,
			'host' => HOST,
			'driver' => DB_DRIVER,
			'charset' => 'utf8'
		);
		$this->conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
	}
	public static function getInstance(){
		static $instance = null;
		if (null === $instance) {
			$instance = new static();
		}

		return $instance;
	}

	public function sql($sql,$args=array()){
		return $this->conn->executeQuery($sql,$args);
	}

	public function fetch($query){
		$array = array();
		while ($row = $query->fetch()){
			$array[] = $row;
		}
		return $array;
	}

	public function insert($table, $hash){		
		return $this->conn->insert($table,$hash);
	}

	public function update($table, $hash, $condition=false){
		if($condition)
			return $this->conn->update($table,$hash,$condition);
		else
			throw new Exception("No se permiten updates sin condicion!");
	}
	public function delete($table,$condition=false){
		if($condition)
			return $this->conn->delete($table, $condition);
		else
			throw new Exception("No se permiten deletes sin condicion!");
			
	}
	public function lastInsert(){
		return $this->conn->lastInsertId();
	}

	public function sqlPaginado($sql,$pagina_actual,$porpagina,$rango=3){


		$query = $this->sql($sql);
		$total = count($this->fetch($query));
		$paginas = ceil($total/$porpagina);

		$offset = ($pagina_actual-1)*$porpagina;
		$sql .= " limit $offset, $porpagina";
		$query = $this->sql($sql);
		
		//$query = $this->ado->SelectLimit($sql,$porpagina,$offset);

		$return = array();		
		$return['cont'] = $this->fetch($query);
		if($paginas > 1){
			$tmp = array();
			for ($i=1; $i <= $paginas; $i++) {

				if(abs($pagina_actual - $i) > $rango)
					continue;

				$tmp[$i-1]['numero'] = $i;
				if($i == $pagina_actual)				
					$tmp[$i-1]['actual'] = true;
			}
			$limpio = array();
			foreach ($tmp as $v) {
				$limpio[] = $v;
			}
			$return['nav'] = $limpio;
		}


		$tmp = array();
		foreach ($_GET as $k => $v) {
			if($v && $k != 'p')
				if(is_array($v))
					foreach ($v as $kk => $vv) {
						$tmp[] = $k . '[' .$kk . ']=' . $vv;
					}
				else
					$tmp[] = $k . '=' . $v;
		}
		$return['url'] = join('&',$tmp);
		return $return;
	}

	public function quote($string){
		return str_replace("'", "''", $string);
		#return $this->ado->qstr($string);
	}
}