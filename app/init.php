<?php

require_once BASE_PATH.'app/functions/Default.php';
require_once BASE_PATH.'app/config.php';

spl_autoload_register(function($str){
	require_once BASE_PATH.'app/functions/'.$str.'.php';
});

// Connection to mysql
DB::getInstance($_HOST, $_USER, $_PASS, $_DB);
