<?php

define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT'].'/login/'); // change this to the name of the root folder of your project
define('DB_ENGINE','mysql');
define('DB_HOST','127.0.0.1');
define('DB_NAME','login');
define('DB_USER','root');
define('DB_PASSWORD','');
define('DB_CHARSET','utf8');

$requestMethod = $_SERVER['REQUEST_METHOD'];