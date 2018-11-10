<?php

$url = !empty(Input::get('act')) ? Input::get('act') : 'index';


switch ($url) {
	case 'index':


		$data = [
			'title' 		=> 'Dashboard',

		];

		view('front_end/index', $data);
		break;

	default:
		die('404 Not Found');
		break;
}
