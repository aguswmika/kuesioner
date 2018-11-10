<?php

class Kuesioner
{
	static function getSingle($id){
		$sql = "SELECT 
					form.*, 
					semester.id_semester, 
					semester.nama_semester, 
					semester.tahun as tahun_semester, 
					(SELECT COUNT(form_pertanyaan.id_pertanyaan) FROM form_pertanyaan WHERE form_pertanyaan.id_form = form.id_form) as jumlah 
				FROM form INNER JOIN semester ON semester.id_semester = form.id_semester WHERE form.id_form = ?";

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$id]);

		return $prep->fetch(PDO::FETCH_OBJ);
	}

	static function getSingleSlug($id){
		$sql = "SELECT 
					form.*, 
					semester.id_semester, 
					semester.nama_semester, 
					semester.tahun as tahun_semester, 
					(SELECT COUNT(form_pertanyaan.id_pertanyaan) FROM form_pertanyaan WHERE form_pertanyaan.id_form = form.id_form) as jumlah 
				FROM form INNER JOIN semester ON semester.id_semester = form.id_semester WHERE form.slug = ?";

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$id]);

		return $prep->fetch(PDO::FETCH_OBJ);
	}

	static function getSingleQuestion($id){
		$sql = "SELECT * FROM form_pertanyaan WHERE id_pertanyaan = ?";

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$id]);

		return $prep->fetch(PDO::FETCH_OBJ);
	}

	static function getAll($except = ''){
		$sql    = "SELECT form.*, semester.id_semester, semester.nama_semester, semester.tahun as tahun_semester, (SELECT COUNT(form_pertanyaan.id_pertanyaan) FROM form_pertanyaan WHERE form_pertanyaan.id_form = form.id_form) as jumlah FROM form";
		$param  = [];

		if(!empty($except)){
			$sql .= " WHERE id_form != ?";
			$param = [$except]; 
		}

		$sql .= " INNER JOIN semester ON semester.id_semester = form.id_semester";

		$prep = DB::conn()->prepare($sql);
		$prep->execute($param);

		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	static function getAllQuestion($id){
		$sql    = "SELECT * FROM form_pertanyaan WHERE id_form = ?";
		$param  = [$id];

		// if(!empty($except)){
		// 	$sql .= " WHERE id_pertanyaan != ?";
		// 	$param = [$except]; 
		// }

		// $sql .= " INNER JOIN semester ON semester.id_semester = form.id_semester";

		$prep = DB::conn()->prepare($sql);
		$prep->execute($param);

		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	static function getAllOption($id){
		$sql    = "SELECT * FROM opsi WHERE id_pertanyaan = ?";
		$param  = [$id];

		// if(!empty($except)){
		// 	$sql .= " WHERE id_pertanyaan != ?";
		// 	$param = [$except]; 
		// }

		// $sql .= " INNER JOIN semester ON semester.id_semester = form.id_semester";

		$prep = DB::conn()->prepare($sql);
		$prep->execute($param);

		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	static function insert(){
		$id_form 		= autoNum('form', 'id_form', 'F');
		$nama 		  	= Input::post('nama');
		$id_semester	= Input::post('semester');
		$status			= Input::post('status');
		$slug			= strtolower(str_replace('_', '-', str_replace(' ', '-', $nama)));
		$tanggal 		= date('Y-m-d H:i:s');

		$sql = "INSERT INTO form(id_form, nama, id_semester, tanggal, status, slug) VALUES (?, ?, ?, ?, ?, ?)";

		$prep = DB::conn()->prepare($sql);
		return $prep->execute([
			$id_form,
			$nama,
			$id_semester,
			$tanggal,
			$status,
			$slug
		]);
	}

	static function edit($id){
		$id_form 		= $id;
		$nama 		  	= Input::post('nama');
		$id_semester	= Input::post('semester');
		$status			= Input::post('status');
		//$slug			= strtolower(str_replace('_', '-', str_replace(' ', '-', $nama)));
		//$tanggal 		= date('Y-m-d H:i:s');

		$sql = "UPDATE form SET nama = ?, id_semester = ?, status = ? WHERE id_form = ?";

		$prep = DB::conn()->prepare($sql);
		return $prep->execute([
			$nama,
			$id_semester,
			$status,
			$id_form
		]);
	}

	static function insert_question(){
		$id_form 		= Input::post('id_form');
		$pertanyaan 	= Input::post('pertanyaan');
		$tipe			= Input::post('tipe');
		$opsi			= Input::post('opsi');
		$tanggal 		= date('Y-m-d H:i:s');

		DB::conn()->beginTransaction();

		try {
			foreach ($pertanyaan as $key => $item_pertanyaan) {
				if(!empty($item_pertanyaan)){
					$sql = "INSERT INTO form_pertanyaan(id_form, pertanyaan, tipe) VALUES (?, ?, ?)";

					$prep = DB::conn()->prepare($sql);
					$prep->execute([
						$id_form,
						$item_pertanyaan,
						$tipe[$key]
					]);

					$id_pertanyaan = DB::conn()->lastInsertId();
					if($tipe[$key] == 'opsional'){
						foreach ($opsi[$key] as $item_opsi) {
							if(!empty($item_opsi)){
								$sql = "INSERT INTO opsi(id_pertanyaan, value) VALUES (?, ?)";

								$prep = DB::conn()->prepare($sql);
								$prep->execute([
									$id_pertanyaan,
									$item_opsi
								]);
							}
						}
					}
				}
			}


			DB::conn()->commit();

			DB::conn()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			DB::conn()->rollBack();
			die();
		}
	}


	static function delete_question($id){
		$sql = "DELETE FROM opsi WHERE id_opsi = ?";

		$prep = DB::conn()->prepare($sql);
		return $prep->execute([
			$id
		]);
	}

	static function deleteAll_question($id){
		$sql = "DELETE FROM opsi WHERE id_pertanyaan = ?";

		$prep = DB::conn()->prepare($sql);
		return $prep->execute([
			$id
		]);
	}

	static function edit_question($id){
		$nama 				= Input::post('nama');
		$tipe_pertanyaan 	= Input::post('tipe_pertanyaan');
		$opsi 				= Input::post('opsi');

		DB::conn()->beginTransaction();

		try {
			$sql = "UPDATE form_pertanyaan SET pertanyaan = ?, tipe = ? WHERE id_pertanyaan = ?";

			$prep = DB::conn()->prepare($sql);
			
			$prep->execute([
				$nama,
				$tipe_pertanyaan,
				$id
			]);

			if($tipe_pertanyaan == 'opsional'){
				self::deleteAll_question($id);
				foreach ($opsi as $value) {
					if(!empty($value)){
						$sql_mini = "INSERT INTO opsi(id_pertanyaan, value) VALUES (?, ?)";

						$prep = DB::conn()->prepare($sql_mini);
						$prep->execute([
							$id,
							$value
						]);
					}
				}
			}

			DB::conn()->commit();

			DB::conn()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			DB::conn()->rollBack();
			die();
		}
	}
}