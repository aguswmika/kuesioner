<?php

class Semester
{
	static function getSingle($id){
		$sql = "SELECT * FROM semester WHERE id_semester = ?";

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$id]);

		return $prep->fetch(PDO::FETCH_OBJ);
	}

	static function getAll($except = ''){
		$sql    = "SELECT * FROM semester";
		$param  = [];

		if(!empty($except)){
			$sql .= " WHERE id_semester != ?";
			$param = [$except]; 
		}

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
