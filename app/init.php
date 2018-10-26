<?php

require_once BASE_PATH.'app/functions/Default.php';

spl_autoload_register(function($str){
	require_once BASE_PATH.'app/functions/'.$str.'.php';
});

// Connection to mysql
DB::getInstance('localhost', 'root', 'root', 'kuesioner');
