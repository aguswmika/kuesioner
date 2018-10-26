<?php 


class Session
{

	static function sess($name, $val = NULL){
		if(empty($val)){
			if(isset($_SESSION[$name])){
				return $_SESSION[$name];
			}else{
				return NULL;
			}
		}else{
			$_SESSION[$name] = $val;
		}
	}

	static function flash($name, $val = NULL){
		if(empty($val)){
			if(isset($_SESSION['tmp_'.$name])){
				$sess =  $_SESSION['tmp_'.$name];
				unset($_SESSION['tmp_'.$name]);
				return $sess;
			}else{
				return NULL;
			}
		}else{
			$_SESSION['tmp_'.$name] = $val;
		}
	}
}