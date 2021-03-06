<?php
//error_reporting(0);
//ini_set('display_errors', 'Off');

session_start();
DEFINE('BASE_PATH', __DIR__ . '/');
date_default_timezone_set("Asia/Makassar");

require_once BASE_PATH.'app/init.php';


#CSRF::start();
$url = !empty(Input::get('p')) ? strtolower(Input::get('p')) : 'dashboard';
model('admin');

switch ($url) {
	case 'dashboard':
		cekLogin();

		load('dashboard');
		break;

		case 'front_end':
			load('front_end');
			break;

	case 'login':
		cekStatus();

		if(cekPost() == false){

			$data = [
				'title' => 'Login Pengguna'
			];

			view('sign/login', $data);
		}else{
			$config = [
				'email' => [
					'required' => true
				],
				'password' => [
					'required' => true
				]
			];

			$valid = new Validation($config);
			if($valid->run()){
				if(Admin::login() == true){
					redirect('?p=dashboard');
				}else{
					msg('Username atau Password Anda Salah', 'danger');
					redirect('?p=login');
				}
			}else{
				msg($valid->getErrors(), 'danger');
				redirect('?p=login');
			}
		}
		break;

	case 'kuesioner':
		cekLogin();

		load('kuesioner');
		break;

	case 'semester':
		cekLogin();

		load('semester');
		break;

	case 'logout':
		cekLogin();
		session_destroy();

		redirect('?p=login');
		break;

	default:
		die('404 Not Found');
		break;
}
