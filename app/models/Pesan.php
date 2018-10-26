<?php 

class Pesan
{
	
	static function getAll($limit = 0){
		$sql = "SELECT * FROM pesan WHERE del = 0";

		if($limit > 0){
			$awal = empty(Input::get('hal')) ? 1 : Input::get('hal');
			$awal = ($awal-1)*$limit;
			$sql .= " LIMIT {$awal}, {$limit}";
		}

		$prep = DB::conn()->prepare($sql);
		$prep->execute();
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	static function getSingle($id){
		$sql = "SELECT * FROM pesan WHERE id_pesan = ?";

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$id]);
		return $prep->fetch(PDO::FETCH_OBJ);
	}

	static function search($search){
		$search = '%'.$search.'%';
		$sql = "SELECT * FROM pesan WHERE (perihal LIKE ? OR nama LIKE ? OR email LIKE ?) AND del = 0";

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$search, $search, $search]);
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	static function del(){
		$id = explode(',' ,substr(Input::post('id'), 1));

		$sql = '';
		foreach ($id as $newId) {
			$sql .= "UPDATE pesan SET del = 1 WHERE id_pesan = ?;";
		}

		$prep = DB::conn()->prepare($sql);
		return $prep->execute($id);
	}
}