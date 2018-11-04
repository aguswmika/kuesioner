<?php 

$url = !empty(Input::get('act')) ? Input::get('act') : 'index';

model('semester');

switch ($url) {
	case 'index':
		$breadcrumbs = '
			<h4 class="page-title pull-left">Dashboard</h4>
            <ul class="breadcrumbs pull-left">
                <li><a href="'.base_url('?p=dashboard').'">Home</a></li>
                <li><span>Dashboard</span></li>
            </ul>
        ';

		$data = [
			'title' 		=> 'Dashboard',
			'breadcrumbs' 	=> $breadcrumbs,
			'semester'		=> Semester::getAll()
		];

		view('dashboard/index', $data);
		break;
	
	default:
		die('404 Not Found');
		break;
}