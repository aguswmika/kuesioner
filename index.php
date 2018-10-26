<?php
//error_reporting(0);
//ini_set('display_errors', 'Off');

session_start();
DEFINE('BASE_PATH', __DIR__ . '/');
date_default_timezone_set("Asia/Makassar");

require_once BASE_PATH.'app/init.php';

//CSRF::start();

$url = !empty(Input::get('p')) ? strtolower(Input::get('p')) : 'dashboard';

model('admin');

switch ($url) {
	case 'dashboard':
		if(cekLogin() == false)
			redirect('?p=login');

		load('dashboard');
		break;

	case 'login':
		if(cekPost() == false){
			$data = [
				'title' => 'Login Pengguna'
			];
			
			view('sign/login', $data);
		}else{
			if(Admin::login() == true)
				redirect('?p=dashboard');
			else{
				msg('Email/Password Anda salah!', 'danger');
				redirect('?p=login');
			}
		}
		break;
	default:
		break;
}