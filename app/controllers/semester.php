<?php 

$url = !empty(Input::get('act')) ? Input::get('act') : 'index';
model('semester');

switch ($url) {
	case 'index':
		if(cekPost() == false){
			$breadcrumbs = '
				<h4 class="page-title pull-left">Semester</h4>
	            <ul class="breadcrumbs pull-left">
	                <li><a href="'.base_url('?p=dashboard').'">Home</a></li>
	                <li><span>Semester</span></li>
	            </ul>
	        ';

	        $id 	= Input::get('id');
	        $except = '';

			if(!empty($id)){
				$except                 = $id;
			}


			$data = [
				'title'			=> 'Semester',
				'breadcrumbs' 	=> $breadcrumbs,
				'semester'		=> Semester::getAll($except)
			];

			if(!empty($id)){
				$data['singlesemester'] = Semester::getSingle($id);
			}

			view('semester/index', $data);
		}else{
			$id = Input::get('id');

			if(empty($id)){
				if(Semester::insert()){
					msg('Berhasil menambahkan', 'success');
					redirect('?p=semester&act=index');
				}else{
					msg('Gagal menambahkan', 'danger');
					redirect('?p=semester&act=index');
				}
			}else{
				if(Semester::update($id)){
					msg('Berhasil diubah', 'success');
					redirect('?p=semester&act=index');
				}else{
					msg('Gagal diubah', 'danger');
					redirect('?p=semester&act=index');
				}
			}
		}
		break;
	

	case 'delete':
		//ambil id dari link ?id='blabla'
		$id = Input::post('id');

		//manggil fungsi dari class Semester
		//fungsi untuk menghapus record di table semester
		if(Semester::delete($id)){
			msg('Berhasil dihapus', 'success');
			redirect('?p=semester&act=index');
		}else{
			msg('Berhasil dihapu', 'danger');
			redirect('?p=semester&act=index');
		}
		break;
	default:
		die('404 Not Found');
		break;
}