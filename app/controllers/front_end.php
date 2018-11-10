<?php

$url = !empty(Input::get('act')) ? Input::get('act') : 'index';
model('kuesioner');
model('hasilkuesioner');

switch ($url) {
	case 'index':
		$slug = Input::get('slug');
		if(cekPost() == false){
			if(!empty($slug)){
				$kuesioner = Kuesioner::getSingleSlug($slug);
				if(!empty($kuesioner)){
					$kuesioners = Kuesioner::getAllQuestion($kuesioner->id_form);

					$data = [
						'title' 		=> $kuesioner->nama,
						'kuesioner'		=> $kuesioner,
						'kuesioners'	=> $kuesioners
					];

					view('front_end/index', $data);
				}else{
					die('404 Not Found');
				}
			}else{
				die('404 Not Found');
			}
		}else{
			if(Hasilkuesioner::insert()){
				Session::sess('save', 'benar');
				redirect(base_url('view/'.$slug));
			}else{
				Session::sess('save', 'salah');
				redirect(base_url('view/'.$slug));
			}
		}
		break;

	default:
		die('404 Not Found');
		break;
}
