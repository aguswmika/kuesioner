<?php 

$url = !empty(Input::get('act')) ? Input::get('act') : 'index';

model('kuesioner');
model('semester');

switch ($url) {
	case 'index':
		$breadcrumbs = '
			<h4 class="page-title pull-left">Kuesioner</h4>
            <ul class="breadcrumbs pull-left">
                <li><a href="'.base_url('?p=dashboard').'">Home</a></li>
                <li><span>Semester</span></li>
            </ul>
        ';

		$data = [
			'title'			=> 'Kuesioner',
			'breadcrumbs' 	=> $breadcrumbs,
			'kuesioner' 	=> Kuesioner::getAll()
		];

		view('kuesioner/index', $data);
		break;

	case 'insert':
		if(cekPost() == false){
			$breadcrumbs = '
				<h4 class="page-title pull-left">Tambah Kuesioner</h4>
	            <ul class="breadcrumbs pull-left">
	                <li><a href="'.base_url('?p=dashboard').'">Home</a></li>
	                <li><a href="'.base_url('?p=kuesioner').'">Kuesioner</a></li>
	                <li><span>Tambah</span></li>
	            </ul>
	        ';

			$data = [
				'title'			=> 'Tambah Kuesioner',
				'breadcrumbs' 	=> $breadcrumbs,
				'semester'		=> Semester::getAll()
			];

			view('kuesioner/insert', $data);
		}else{
			if(Kuesioner::insert()){
				msg('Berhasil menambahkan', 'success');
				redirect('?p=kuesioner');
			}else{
				msg('Gagal menambahkan', 'danger');
				redirect('?p=kuesioner');
			}
		}
		break;

	case 'edit':
		$id = Input::get('id');
		if(cekPost() == false){
			$kuesioner = Kuesioner::getSingle($id);
			$kuesioners = Kuesioner::getAllQuestion($id);
			$breadcrumbs = '
				<h4 class="page-title pull-left">Edit Kuesioner</h4>
	            <ul class="breadcrumbs pull-left">
	                <li><a href="'.base_url('?p=dashboard').'">Home</a></li>
	                <li><a href="'.base_url('?p=kuesioner').'">Kuesioner</a></li>
	                <li><span>Edit</span></li>
	            </ul>
	        ';

			$data = [
				'title'			=> 'Edit Kuesioner ('.$kuesioner->nama.')',
				'breadcrumbs' 	=> $breadcrumbs,
				'semester'		=> Semester::getAll(),
				'kuesioner'		=> $kuesioner,
				'kuesioners'	=> $kuesioners
			];

			view('kuesioner/edit', $data);
		}else{
			if(Kuesioner::edit($id)){
				msg('Berhasil mengubah', 'success');
				redirect('?p=kuesioner');
			}else{
				msg('Gagal mengubah', 'danger');
				redirect('?p=kuesioner');
			}
		}
		break;

	case 'insert_question':
		$id = Input::get('id');
		if(cekPost() == false){
	        $kuesioner = Kuesioner::getSingle($id);

			$breadcrumbs = '
				<h4 class="page-title pull-left">Tambah Pertanyaan</h4>
	            <ul class="breadcrumbs pull-left">
	                <li><a href="'.base_url('?p=dashboard').'">Home</a></li>
	                <li><a href="'.base_url('?p=kuesioner').'">Kuesioner ('.$kuesioner->nama.')</a></li>
	                <li><span>Tambah Pertanyaan</span></li>
	            </ul>
	        ';

			$data = [
				'title'			=> 'Tambah Pertanyaan ('.$kuesioner->nama.')',
				'breadcrumbs' 	=> $breadcrumbs,
				'kuesioner'		=> $kuesioner
			];

			view('kuesioner/insert_question', $data);
		}else{
			if(Kuesioner::insert_question()){
				msg('Berhasil menambahkan', 'success');
				redirect('?p=kuesioner&act=insert_question&id='.$id);
			}else{
				msg('Gagal menambahkan', 'danger');
				redirect('?p=kuesioner&act=insert_question&id='.$id);
			}
		}
		break;

	case 'edit_question':
		$id = Input::get('id');
		$pertanyaan = Kuesioner::getSingleQuestion($id);
		if(cekPost() == false){
			$opsi	    = Kuesioner::getAllOption($pertanyaan->id_pertanyaan);

			$breadcrumbs = '
				<h4 class="page-title pull-left">Edit Pertanyaan</h4>
	            <ul class="breadcrumbs pull-left">
	                <li><a href="'.base_url('?p=dashboard').'">Home</a></li>
	                <li><a href="'.base_url('?p=kuesioner').'">Kuesioner</a></li>
	                <li><span>Pertanyaan</span></li>
	            </ul>
	        ';

			$data = [
				'title'			=> 'Edit Pertanyaan ('.$pertanyaan->pertanyaan.')',
				'breadcrumbs' 	=> $breadcrumbs,
				'pertanyaan'	=> $pertanyaan,
				'opsi'			=> $opsi
			];

			view('kuesioner/edit_question', $data);
		}else{
			if(Kuesioner::edit_question($id)){
				msg('Berhasil mengubah', 'success');
				redirect('?p=kuesioner&act=edit&id='.$pertanyaan->id_form);
			}else{
				msg('Gagal mengubah', 'danger');
				redirect('?p=kuesioner&act=edit&id='.$pertanyaan->id_form);
			}
		}
		break;
		
	case 'delete':

		break;
	
	default:
		die('404 Not Found');
		break;
}