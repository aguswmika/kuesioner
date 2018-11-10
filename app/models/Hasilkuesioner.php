<?php

class Hasilkuesioner
{
	static function insert(){
		$id_pertanyaan 	= Input::post('id_pertanyaan');
		$tipe			= Input::post('tipe');
		$opsi			= Input::post('opsi');
		$esay			= Input::post('esay');

		DB::conn()->beginTransaction();

		try {
			foreach ($id_pertanyaan as $key => $item_pertanyaan) {
				$item_opsi = NULL;
				$item_esay = NULL;
				$sql = "INSERT INTO hasil_kuesioner(id_pertanyaan, id_opsi, hasil_esay) VALUES (?, ?, ?)";

				$prep = DB::conn()->prepare($sql);

				if($tipe[$key] == 'opsional' ){
					$item_opsi = $opsi[$key];
				}else{
					$item_esay = $esay[$key];
				}

				$prep->execute([
					$item_pertanyaan,
					$item_opsi,
					$item_esay,
				]);
			}


			DB::conn()->commit();

			DB::conn()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return true;
		} catch (PDOException $e) {
			//echo $e->getMessage();
			DB::conn()->rollBack();
			return false;
		}
	}
}