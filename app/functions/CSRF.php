<?php 


class CSRF
{
	static function start(){
		if(!isset($_SESSION['token']) && empty(Session::sess('_token'))){
			Session::sess('_token', bin2hex(openssl_random_pseudo_bytes(16)));
		}

		if($_SERVER['REQUEST_METHOD'] === 'POST' && Input::post('_token') !== Session::sess('_token')){
			die('Invalid CSRF Token!');
		}
	}

	static function get(){
		if(!isset($_SESSION['token']) && empty(Session::sess('_token'))){
			Session::sess('_token', bin2hex(openssl_random_pseudo_bytes(16)));
		}

		if($_SERVER['REQUEST_METHOD'] === 'GET' && Input::get('_token') !== Session::sess('_token')){
			die('Invalid CSRF Token!');
		}
	}


	static function token(){
		return Session::sess('_token');
	}
}