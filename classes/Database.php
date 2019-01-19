<?php

class Database{
	private $_pdo,
			$_stmt,
			$_results;
	private static $_instance = null;

	private function __construct(){
		return $this->_pdo = new PDO(DB_ENGINE.":host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET.";",DB_USER,DB_PASSWORD);
	}

	public static function getInstance(){
		if(!isset(self::$_instance)){
			return self::$_instance = new Database();
		}
	}

	public function select($table,$where = [],$columns = ['*']){
		$columns = implode(', ',$columns);
		$sql = "SELECT $columns FROM $table";
		if(!empty($where) && count($where) === 3){
			$field = $where[0];
			$operator = $where[1];
			$value = '?';
			$sql .= " WHERE $field $operator $value";
		}
		$this->_stmt = $this->_pdo->prepare($sql);
		if($this->_stmt->execute([$where[2]])){
			$this->_results = $this->_stmt->fetchAll(PDO::FETCH_OBJ);
		}
		return $this;
	}

	public function insert($tableName, $data){
		$fields = implode(', ',array_keys($data));
		$placeholders = '';
		foreach($data as $field => $value){
			$placeholders .= ":$field,";
		}
		$placeholders = rtrim($placeholders,',');
		$sql = "INSERT INTO $tableName ($fields) VALUES ($placeholders)";
		$this->_stmt = $this->_pdo->prepare($sql);
		if(!$this->_stmt->execute($data)){
			return false;
		}
		return true;
	}
	
	public function update($table,$fields,$values,$condition = []){
		$table = sanitize($table);
		$sql = "UPDATE $table SET";
		foreach($fields as $field){
			$sql .= " $field = ?,";
		}
		if(count($condition) === 3){
			$field = $condition[0];
			$operator = $condition[1];
			$value = $condition[2];
			$where = " WHERE $field $operator ?";
			$sql = rtrim($sql,',').$where;
			$values[] = $value;
			$this->_stmt = $this->_pdo->prepare($sql);
			if(!$this->_stmt->execute($values)){
				return false;
			}
			return true;
		}
	}

	public function getResults(){
		return $this->_results;
	}
}