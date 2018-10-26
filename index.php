<?php
//error_reporting(0);
//ini_set('display_errors', 'Off');

session_start();
DEFINE('BASE_PATH', __DIR__ . '/');
echo BASE_PATH;
date_default_timezone_set("Asia/Makassar");

require_once BASE_PATH.'app/init.php';


CSRF::start();
$url = !empty(Input::get('p')) ? strtolower(Input::get('p')) : 'dashboard';

switch ($url) {
	case 'value':
		break;
	
	default:
		break;
}