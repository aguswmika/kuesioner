<?php

class Pasok
{

	static function getAll($limit = 0){
		$sql = "SELECT * FROM pasok_view WHERE del = 0 ORDER BY id_distributor";

		if($limit > 0){
			$awal = empty(Input::get('hal')) ? 1 : Input::get('hal');
			$awal = ($awal-1)*$limit;
			$sql .= " LIMIT {$awal}, {$limit}";
		}

		$prep = DB::conn()->prepare($sql);
		$prep->execute();
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	static function laporan($limit = 0){
		$sql = "SELECT * FROM pasok LEFT JOIN buku ON buku.id_buku = pasok.id_buku LEFT JOIN distributor ON distributor.id_distributor = pasok.id_distributor WHERE pasok.del = 0";

		if(!empty(Input::get('awal')) && !empty(Input::get('akhir'))){
			if(Input::get('awal') == Input::get('akhir')){
				$sql .= ' AND DATE(pasok.tanggal) = "'.Input::get('awal').'"';
			}else{
				$sql .= ' AND DATE(pasok.tanggal) BETWEEN "'.Input::get('awal').'" AND "'.Input::get('akhir').'"';
			}
		}else{
			$sql .= ' AND DATE(pasok.tanggal) = "'.date('Y-m-d').'"';
		}

		$sql .= ' ORDER BY DATE(pasok.tanggal) ASC';

		$prep = DB::conn()->prepare($sql);
		$prep->execute();
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	static function getSingle($id){
		$sql = "SELECT * FROM pasok_view WHERE id_pasok = ?";

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
		$sql = "SELECT * FROM pasok_view WHERE (id_pasok LIKE ? OR id_distributor LIKE ? OR id_buku LIKE ? OR nama_distributor LIKE ? OR judul LIKE ?) AND del = 0";

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$search, $search, $search, $search, $search]);
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	static function add(){
		$id      = autoNum('pasok', 'id_pasok', 'PS');
		$buku    = Input::post('buku');
		$distri  = Input::post('distri');
		$jumlah  = Input::post('jumlah');
		$tanggal = Input::post('tanggal');
		$count   = 0;


		$sql  = "INSERT INTO pasok (id_pasok, id_distributor, id_buku, jumlah, tanggal, del) VALUES (?, ?, ?, ?, ?, 0);";
		$prep = DB::conn()->prepare($sql);
		return $prep->execute([$id, $distri, $buku, $jumlah, $tanggal]);
	}

	static function edit($id){
		$jumlah  = Input::post('jumlah');
		$tanggal = Input::post('tanggal');


		$sql  = "UPDATE pasok SET jumlah = ?, tanggal = ? WHERE id_pasok = ?";
		$prep = DB::conn()->prepare($sql);
		return $prep->execute([$jumlah, $tanggal, $id]);
	}

	static function transfer($id){
		$jumlah  = Input::post('transfer');
		$buku    = Input::post('buku');


		$sql  = "UPDATE pasok SET jumlah = jumlah - ? WHERE id_pasok = ?;";
		$sql .= "UPDATE buku SET stok = stok + ? WHERE id_buku = ?;";

		$prep = DB::conn()->prepare($sql);
		return $prep->execute([$jumlah, $id ,$jumlah, $buku]);
	}

	static function del(){
		$id = explode(',' ,substr(Input::post('id'), 1));

		$sql = '';
		foreach ($id as $newId) {
			$sql .= "UPDATE pasok SET del = 1 WHERE id_pasok = ?;";
		}

		$prep = DB::conn()->prepare($sql);
		return $prep->execute($id);
	}
}
