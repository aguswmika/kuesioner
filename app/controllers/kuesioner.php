<?php 

$url = !empty(Input::get('act')) ? Input::get('act') : 'index';

model('kuesioner');
model('hasilkuesioner');
model('semester');

switch ($url) {
	case 'index':
		$breadcrumbs = '
			<h4 class="page-title pull-left">Kuesioner</h4>
            <ul class="breadcrumbs pull-left">
                <li><a href="'.base_url('?p=dashboard').'">Home</a></li>
                <li><span>Kuesioner</span></li>
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
			$config = [
				'semester' => [
					'required' => true
				],
				'nama' => [
					'required' => true
				],
				'status'	=> [
					'required' => true
				]
			];

			$valid = new Validation($config);
			if($valid->run()){
				if(Kuesioner::insert()){
					msg('Berhasil menambahkan', 'success');
					redirect('?p=kuesioner');
				}else{
					msg('Gagal menambahkan', 'danger');
					redirect('?p=kuesioner');
				}
			}else{
				msg($valid->getErrors(), 'danger');
				redirect('?p=kuesioner&act=insert');
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
			$config = [
				'semester' => [
					'required' => true
				],
				'nama' => [
					'required' => true
				],
				'status'	=> [
					'required' => true
				]
			];

			$valid = new Validation($config);
			if($valid->run()){
				if(Kuesioner::edit($id)){
					msg('Berhasil mengubah', 'success');
					redirect('?p=kuesioner');
				}else{
					msg('Gagal mengubah', 'danger');
					redirect('?p=kuesioner');
				}
			}else{
				msg($valid->getErrors(), 'danger');
				redirect('?p=kuesioner&act=edit&id='.$id);
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
		//ambil id dari link ?id='blabla'
		$id = Input::post('id');

		//manggil fungsi dari class Kuesioner
		//fungsi untuk menghapus record di table semester
		if(Kuesioner::delete($id)){
			msg('Berhasil dihapus', 'success');
			redirect('?p=kuesioner&act=index');
		}else{
			msg('Berhasil dihapus', 'danger');
			redirect('?p=kuesioner&act=index');
		}
		break;

	case 'delete_pertanyaan':
		//ambil id dari link ?id='blabla'
		$id = Input::post('id');
		$id_web = Input::get('last');

		//manggil fungsi dari class Kuesioner
		//fungsi untuk menghapus record di table semester
		if(Kuesioner::delete_pertanyaan($id)){
			msg('Berhasil dihapus', 'success');
			redirect('?p=kuesioner&act=edit&id='.$id_web);
		}else{
			msg('Berhasil dihapus', 'danger');
			redirect('?p=kuesioner&act=edit&id='.$id_web);
		}
		break;


	case 'view_answer':
		$id = Input::get('id');
		$kuesioner = Kuesioner::getSingle($id);
		$kuesioners = Kuesioner::getAllQuestion($kuesioner->id_form);

		$breadcrumbs = '
			<h4 class="page-title pull-left">Kuesioner</h4>
            <ul class="breadcrumbs pull-left">
                <li><a href="'.base_url('?p=dashboard').'">Home</a></li>
                <li><a href="'.base_url('?p=kuesioner').'">Kuesioner</a></li>
                <li><span>Lihat Jawaban</span></li>
            </ul>
        ';

		$data = [
			'title'			=> 'Lihat Jawaban Kuesioner '.$kuesioner->nama,
			'breadcrumbs' 	=> $breadcrumbs,
			'kuesioner'		=> $kuesioner,
			'kuesioners'	=> $kuesioners
		];

		view('kuesioner/hasil', $data);

		break;
	
	default:
		die('404 Not Found');
		break;
}