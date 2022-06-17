<?php

require_once 'connection.php';

class DB {

    private $dbhost = "";
    private $dbname = "";
    private $dbport = "";
    private $dbuser = "";
    private $dbpass = "";
    public $link = null;
    public $resultQuery = null;
    public $raw = null;
    public $last_id = null;

    function __construct(){  
        $this->dbhost = DBHOST;
        $this->dbname = DBNAME;
        $this->dbport = DBPORT;
        $this->dbuser = DBUSER;
        $this->dbpass = DBPASS;
        $this->connect();
    }

    public function connect(){
        $this->link = mysqli_init();
        $connectResult = $this->getConnect();
        if(!$connectResult or mysqli_connect_errno() !== 0){
            $errorMessage = mysqli_connect_errno() . ' : ' . mysqli_connect_error(); 
            throw new Exception($errorMessage);
        }
        return $connectResult;
    }

    public function disconnect(){
        if(!is_null($this->link)){
            mysqli_close($this->link);
            $this->link = null;
        }
    }

    public function isConnected() {
		return !is_null($this->link);
	}

    private function existError(){
        return mysqli_errno($this->link) !== 0;
    }

    public function realEscape(string $string){
        if(!$this->isConnected()) throw new Exception("No hay conexión abierta.");
        if(empty(trim($string))) return $string;
        return mysqli_real_escape_string($this->link, $string);
    }

    public function get(string $table, int $id = null){
        $result = null;

        if(!$this->isConnected()) throw new Exception("No hay conexión abierta.");

        $sql = "SELECT * FROM `$table` WHERE 1=1 ";
        if(is_numeric($id)){
            $sql .= " AND id = $id ";
        }

        $this->resultQuery = mysqli_query($this->link, $sql);

        if($this->existError()) throw new Exception("Error en mysql " . mysqli_error($this->link));

        if(mysqli_num_rows($this->resultQuery) > 0){
            $result = $this->first();
            $this->raw = $result;
        }

        return $result;
    }

    function first($mysqliResult = null){
        if(!$this->isConnected()) throw new Exception("No hay conexión abierta.");
        if(is_null($mysqliResult)) $mysqliResult = $this->resultQuery;
        mysqli_data_seek($mysqliResult, 0);
        return mysqli_fetch_object($mysqliResult);
    }

    function next($mysqliResult = null){
        if(!$this->isConnected()) throw new Exception("No hay conexión abierta.");
        if(is_null($mysqliResult)) $mysqliResult = $this->resultQuery;
        return mysqli_fetch_object($mysqliResult);
    }

    public function create(string $table, array $record){
        if(!$this->isConnected()) throw new Exception("No hay conexión abierta.");

        $sql = "INSERT INTO `".$table."` (`".implode("`, `",array_keys($record))."`) VALUES (";
		reset($record);
		$work = array();
		foreach ($record as $key => $value) {
			if (is_null($value)) {
				$work[] = "NULL";
			} else {
				$work[] = "'$value'";
			}
		}
		$sql .= implode(',',$work).");";

        $this->resultQuery = mysqli_query($this->link,$sql);
        $this->last_id = mysqli_insert_id($this->link);

        return $this->resultQuery;
    }

    public function update(string $table, array $record, string $where = ""){
        if(!$this->isConnected()) throw new Exception("No hay conexión abierta.");
        
        $sql = "UPDATE `".$table."` SET ";
		$work = array();
		foreach ($record as $key => $value) {
			$key = '`'.$key.'`';
			if (is_null($value)) {
				$work[] = $key."=NULL";
			} else {
				$work[] = $key."='$value'";
			}
		}
		$sql .= implode(',',$work);
		if (!empty(trim($where))) {  $sql .= " WHERE ".$where; }
		$sql .= ";";

        $this->resultQuery = mysqli_query($this->link,$sql);
        return $this->resultQuery;
    }

    private function getConnect(){
        return mysqli_real_connect($this->link, $this->dbhost, $this->dbuser, $this->dbpass, $this->dbname, $this->dbport);
    }
}