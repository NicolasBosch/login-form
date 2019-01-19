<?php

function validate($inputs = []){
	$errors = [];
	foreach ($inputs as $field => $value) {
		switch($field){
			case 'username':
				$errors[$field] = check($value,true,4,20);
				break;
			case 'email':
				$errors[$field] = check($value,true,'','','',true);
				break;
			case 'email_repeat':
				$errors[$field] = check($value,true,'','',$inputs['email'],true);
				break;
			case 'password':
			case 'password_old':
				$errors[$field] = check($value,true,6,20);
				break;
			case 'password_repeat':
				$errors[$field] = check($value,true,6,20,$inputs['password']);
				break;
		}
		if(empty($errors[$field])){
			unset($errors[$field]);
		}
	}
	return $errors;
}

function sanitize($input){
	$sanitizedData;
	if(is_array($input)){
		foreach($input as $name => $value){
			$sanitizedData[$name] = trim(htmlentities($value));
		}
	}elseif(is_object($input)){
		foreach($input as $name => $value){
			$input->$name = trim(htmlentities($value));
		}
		return $input;
	}elseif (is_string($input)){
		$sanitizedData = trim(htmlentities($input));
	}
	return $sanitizedData;
}

function check($data,$required = false,$min = null,$max = null, $match = null, $email = false){
	$errors = [];
	if(empty($data) && $required){
		$errors[] = "this field is mandatory";
	}else{
		if($min && !(strlen($data) >= $min)){
			$errors[] = "this field must be at least $min characters long";
		}
		if($max && !(strlen($data) <= $max)){
			$errors[] = "this field can't be longer than $max characters long";
		}
		if(!empty($match) && $data != $match){
			$errors[] = "this field must match the other one";
		}
		if($email && !filter_var($data,FILTER_VALIDATE_EMAIL)){
			$errors[] = "please enter a valid email";
		}
	}
	return $errors;
}

function displayErrors($errors = array(), $fieldName){
	if(isset($errors[$fieldName])){
		if(is_array($errors[$fieldName])){
			return implode(". <br>",$errors[$fieldName]);
		}
	}
}