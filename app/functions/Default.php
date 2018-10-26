<?php 

function load($str){
	require_once BASE_PATH.'app/controllers/'.$str.'.php';
}

function model($str){
	require_once BASE_PATH.'app/models/'.$str.'.php';
}

function view($str, $data = []){
	extract($data);
	require_once BASE_PATH.'app/views/'.$str.'.php';
}

function base_url($str = NULL){
	$http = 'http'.((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 's' : '').'://';
	$url  = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
	if(!empty($str)){
		$str = $str.'/';
	}
	return $http.$_SERVER['HTTP_HOST'].$url.$str;
}

function cekPost(){
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		return true;
	}else{
		return false;
	}
}

function autoNum($table, $id, $code){
	$date = date('Ym');
	$sql = "SELECT max({$id}) as max FROM {$table}";

	$prep = DB::conn()->prepare($sql);
	if($prep->execute()){
		$item = $prep->fetch(PDO::FETCH_OBJ);


		$num   = (int) substr($item->max, 9);
		$num++;
		$count = str_pad($num, 3, "0", STR_PAD_LEFT);


		return $code."-".$date.$count;
	}else{
		return $code."-".$date.'001';
	}
	
}

function msg($msg = NULL, $sts = NULL){
	if(empty($msg)){
		return Session::flash('error');
	}else{
		Session::flash('error','<div class="message '.$sts.' clearfix"><span class="fl">'.$msg.'</span><span class="fr"><i class="fa fa-times"></i></span></div>');
	}
}

function cekLogin(){
	if(empty(Session::sess('akses'))){
		redirect('?p=login');
	}
}

function cekStatus(){
	if(!empty(Session::sess('akses'))){
		redirect('?p=dashboard');
	}
}

function cekAkses(){
	if(Session::sess('akses') > 1){
		redirect('?p=dashboard');
	}
}

function redirect($str){
	header('location: '.$str);
}

function paginate($table, $limit){
	$sql = "SELECT count(*) as count FROM {$table} WHERE del = 0";

	$prep = DB::conn()->prepare($sql);
	$prep->execute();
	$item = $prep->fetch(PDO::FETCH_OBJ);

	$total = ceil($item->count/$limit);


	$start = '<center><ul class="nav-page">';
	$mid   = '';
	$p     = Input::get('p');
	$hal   = empty(Input::get('hal')) ? 1 : Input::get('hal');

	for ($i=1; $i <= $total; $i++) { 
		if($hal == $i ){
			$class = 'class="active"';
		}else{
			$class = '';
		}
		$mid .= '<li><a '.$class.' href="?p='.$p.'&hal='.$i.'">'.$i.'</a></li>';
	}
	$end   = '</ul></center>';

	if(empty(Input::get('search'))){
		return $start.$mid.$end;
	}else{
		return NULL;
	}
}

