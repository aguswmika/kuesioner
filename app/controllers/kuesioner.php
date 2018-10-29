<?php 

$url = !empty(Input::get('act')) ? Input::get('act') : 'index';

switch ($url) {
	case 'insert':
		$breadcrumbs = '
			<h4 class="page-title pull-left">Kuesioner</h4>
            <ul class="breadcrumbs pull-left">
                <li><a href="'.base_url('?p=dashbaord').'">Home</a></li>
                <li><a href="'.base_url('?p=kuesioner&act=arsip').'">Kuesioner</a></li>
                <li><span>Tambah</span></li>
            </ul>
        ';

		$data = [
			'title'	=> 'Tambah Kuesioner',
			'breadcrumbs' => $breadcrumbs
		];

		view('kuesioner/insert', $data);
		break;
	
	default:
		die('404 Not Found');
		break;
}