<?php

class User{
	private $_DB,
			$_data,
			$_error;

	public function __construct($name = null){
		$this->_DB = Database::getInstance();
		if($name){
			$this->getUserData($name);
		}
	}


	public function register($data){
		if($this->exists($data['username'])){
			return $this->_error = 'Username already exists';
		}else{
			$username = strtolower($data['username']);
			$email = strtolower($data['email']);
			$password = password_hash($data['password'],PASSWORD_DEFAULT);
			if(!$this->_DB->insert('users',['username' => $username,'password' => $password,'email' => $email])){
				$this->_error = 'User could not be registered, please try again later';
				return false;
			}
		return true;
		}
	}

	public function update($fields = [], $values = []){
		if($fields && $values){
			return $this->_DB->update('users',$fields,$values,['id','=',$this->_data->id]);
		}
	}

	public function exists($name){
		if(!$this->getUserData($name)){
			return false;
		}
		return true;
	}

	public function getUserData($name = null){
		if(is_string($name) && !is_numeric($name)){
			if($results = $this->_DB->select('users',['username','=',strtolower($name)])->getResults()){
				$this->_data = sanitize($results[0]);
			}
		}elseif(ctype_digit($name)){
			if($results = $this->_DB->select('users',['id','=',$name])->getResults()){
				$this->_data = sanitize($results[0]);
			}
		}
		return $this->_data;
	}

	public function getPassword(){
		return $this->_data->password;
	}

	public function getError(){
		return $this->_error;
	}

}
