<?php

class Router{

	public static function redirect(string $page){
		header("location:{$page}.php");
		exit;
	}

}