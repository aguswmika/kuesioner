<?php

class Hasilkuesioner
{

	/*

	SELECT 
	form.id_form, (SELECT COUNT(hasil_kuesioner.id_pertanyaan) FROM hasil_kuesioner WHERE hasil_kuesioner.id_pertanyaan = form_pertanyaan.id_pertanyaan) as hasil
	FROM form
    INNER JOIN form_pertanyaan 
    ON form_pertanyaan.id_form = form.id_form
    WHERE (SELECT COUNT(hasil_kuesioner.id_pertanyaan) FROM hasil_kuesioner WHERE hasil_kuesioner.id_pertanyaan = form_pertanyaan.id_pertanyaan) > 0
    GROUP BY form.id_form
	
	*/

	static function getAll($id){
		$sql    = "SELECT * FROM hasil_kuesioner WHERE id_pertanyaan = ?";
		$param  = [$id];

		$prep = DB::conn()->prepare($sql);
		$prep->execute($param);

		return $prep->fetchAll(PDO::FETCH_OBJ);
	}


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