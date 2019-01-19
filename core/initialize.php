<?php

require_once 'config.php';
require_once '../functions/validation.php';

spl_autoload_register(function($class){
	require_once ROOT_DIR."/classes/".$class.".php";
});

session_start();