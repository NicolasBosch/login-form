<?php

class Login{
	private $_user = null,
			$_error;


	public function __construct(){
		$this->_user = new User;
	}

	public static function verifySession(){
		if(isset($_SESSION['id'])){
			return true;
		}
		return false;
	}

	public function verifyLogin($input = array()){
		$username = $input['username'];
		if($this->_user->exists($username)){
			$enteredPassword = $input['password'];
			$dbPassword = $this->_user->getPassword();
			if(!password_verify($enteredPassword,$dbPassword)){
				$this->_error = 'Incorrect Username or Password, please try again';
				return false;
			}else{
				$_SESSION['id'] = $this->_user->getUserData()->id;
				$_SESSION['username'] = $this->_user->getUserData()->username;
				return true;
			}
		}else{
			$this->_error = 'Incorrect Username or Password, please try again';
			return false;
		}
	}

	public function getError(){
		return $this->_error;
	}
}