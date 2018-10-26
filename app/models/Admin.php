<?php

class Admin
{
	static function login(){
		$email     = Input::post('email');
		$password  = md5(Input::post('password'));

		$sql = "SELECT email, password FROM admin_new WHERE email = ? AND password = ?";

		$prep = DB::conn()->prepare($sql);

		$prep->execute([
			$email,
			$password
		]);

		if($prep->rowCount() > 0){
			$data = $prep->fetch(PDO::FETCH_OBJ);

			Session::sess('id_admin', $data->id_admin);
      Session::sess('is_login', true);

			return true;
		}else{
			return false;
		}
	}

}
