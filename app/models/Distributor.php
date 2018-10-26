<?php 

class Distributor
{
	
	static function getAll($limit = 0){
		$sql = "SELECT * FROM distributor WHERE del = 0";

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
		$sql = "SELECT * FROM distributor WHERE id_distributor = ?";

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$id]);
		return $prep->fetch(PDO::FETCH_OBJ);
	}

	static function getDetail($id){
		$sql = "SELECT * FROM detail_view WHERE id_penjualan = ?";

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$id]);
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}


	static function search($search){
		$search = '%'.$search.'%';
		$sql = "SELECT * FROM distributor WHERE (id_distributor LIKE ? OR nama_distributor LIKE ?) AND del = 0";

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$search, $search]);
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	static function add(){
		$id      = autoNum('distributor', 'id_distributor', 'DS');
		
		$nama     = Input::post('nama');
		$alamat   = Input::post('alamat');
		$telepon  = Input::post('telepon');


		$sql  = "INSERT INTO distributor (id_distributor, nama_distributor, alamat, telepon, del) VALUES (?, ?, ?, ?, 0);";
		$prep = DB::conn()->prepare($sql);
		return $prep->execute([$id, $nama, $alamat, $telepon]);
	}

	static function edit($id){
		
		$nama     = Input::post('nama');
		$alamat   = Input::post('alamat');
		$telepon  = Input::post('telepon');


		$sql  = "UPDATE distributor SET nama_distributor = ?, alamat = ?, telepon = ? WHERE id_distributor = ?;";
		$prep = DB::conn()->prepare($sql);
		return $prep->execute([$nama, $alamat, $telepon, $id]);
	}

	static function del(){
		$id = explode(',' ,substr(Input::post('id'), 1));

		$sql = '';
		foreach ($id as $newId) {
			$sql .= "UPDATE distributor SET del = 1 WHERE id_distributor = ?;";
		}

		$prep = DB::conn()->prepare($sql);
		return $prep->execute($id);
	}
}