<?php 

class Input{
	static function post($str){
		return isset($_POST[$str]) ? $_POST[$str] : null;
	}

	static function get($str){
		return isset($_GET[$str]) ? $_GET[$str] : null;
	}
}