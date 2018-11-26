<?php

class Semester
{
	static function getSingle($id){
		$sql = "SELECT 
				semester.*,
				COUNT(form.id_semester) as jumlah_kuesioner
				FROM semester 
				LEFT JOIN form ON form.id_semester = semester.id_semester
				WHERE semester.id_semester = ?
				GROUP BY semester.id_semester";

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$id]);

		return $prep->fetch(PDO::FETCH_OBJ);
	}

	static function getAll($except = ''){
		$sql    = "SELECT 
					semester.*,
					COUNT(form.id_semester) as jumlah_kuesioner
					FROM semester 
					LEFT JOIN form ON form.id_semester = semester.id_semester";
		$param  = [];

		if(!empty($except)){
			$sql .= " WHERE semester.id_semester != ?";
			$param = [$except]; 
		}

		$sql .= " GROUP BY semester.id_semester";

		$prep = DB::conn()->prepare($sql);
		$prep->execute($param);

		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	static function insert(){
		$nama_semester  = Input::post('tipe');
		$tahun 			= Input::post('tahun');

		$sql = "INSERT INTO semester(nama_semester, tahun) VALUES (?, ?)";

		$prep = DB::conn()->prepare($sql);
		return $prep->execute([
			$nama_semester,
			$tahun
		]);
	}

	static function update($id){
		$nama_semester  = Input::post('tipe');
		$tahun 			= Input::post('tahun');

		$sql = "UPDATE semester SET nama_semester = ?, tahun = ? WHERE id_semester = ?";

		$prep = DB::conn()->prepare($sql);
		return $prep->execute([
			$nama_semester,
			$tahun,
			$id
		]);
	}

	static public function delete($id){
		$sql = "DELETE FROM semester WHERE id_semester = ?";

		$prep = DB::conn()->prepare($sql);
		return $prep->execute([
			$id
		]);
	}

}
