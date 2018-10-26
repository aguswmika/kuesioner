<?php 

class Penjualan
{
	
	static function getAll($limit = 0){
		$sql = "SELECT * FROM penjualan_view WHERE del = 0";
		if(Session::sess('akses') > 1){
			$sql .= ' AND id_kasir = "'.Session::sess('id').'"';
		}

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
		$sql = "SELECT * FROM penjualan LEFT JOIN kasir ON kasir.id_kasir = penjualan.id_kasir WHERE penjualan.del = 0";
		if(Session::sess('akses') > 1){
			$sql .= ' AND penjualan.id_kasir = "'.Session::sess('id').'"';
		}
		if(!empty(Input::get('awal')) && !empty(Input::get('akhir'))){
			if(Input::get('awal') == Input::get('akhir')){
				$sql .= ' AND DATE(penjualan.tanggal) = "'.Input::get('awal').'"';
			}else{
				$sql .= ' AND DATE(penjualan.tanggal) BETWEEN "'.Input::get('awal').'" AND "'.Input::get('akhir').'"';
			}
		}else{
			$sql .= ' AND DATE(penjualan.tanggal) = "'.date('Y-m-d').'"';
		}

		$sql .= ' ORDER BY DATE(penjualan.tanggal) ASC';

		$prep = DB::conn()->prepare($sql);
		$prep->execute();
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}


	static function getSingle($id){
		$sql = "SELECT * FROM penjualan_view WHERE id_penjualan = ?";

		if(Session::sess('akses') > 1){
			$sql .= ' AND id_kasir = "'.Session::sess('id').'"';
		}

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

	static function getStats(){
		$sql = "SELECT count(*) as jml FROM penjualan_view WHERE del = 0";

		$prep = DB::conn()->prepare($sql);
		$prep->execute();
		return $prep->fetch(PDO::FETCH_OBJ);
	}


	static function search($search){
		$search = '%'.$search.'%';
		$sql = "SELECT * FROM penjualan_view WHERE (id_penjualan LIKE ? OR id_kasir LIKE ? OR nama LIKE ?) AND del = 0";
		if(Session::sess('akses') > 1){
			$sql .= ' AND id_kasir = "'.Session::sess('id').'"';
		}

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$search, $search, $search]);
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	static function add(){
		$id     = autoNum('penjualan', 'id_penjualan', 'PJ');
		
		$idBuku  = Input::post('id');
		$sql     = "";
		$total   = 0;
		$jumlah  = Input::post('jumlah');
		$harga   = Input::post('harga');
		$newJml  = 0;
		$newTtl  = 0;
		$date    = Input::post('tanggal').' '.date('H:i:s');
		$bayar   = Input::post('bayar');
		$kembali = Input::post('kembalian');
		$kasir   = Session::sess('id');
		$arr     = [];


		foreach ($idBuku as $key => $newId) {
			$sql     .= "INSERT INTO detail_penjualan (id_penjualan, id_buku, jumlah, total) VALUES (?, ?, ?, ?);";	
			$total    = $jumlah[$key]*$harga[$key];
			$newTtl  += $total;
			$newJml  += $jumlah[$key];
			$arr      = array_merge($arr, [$id, $newId, $jumlah[$key], $total]);
		}

		$sql  = "INSERT INTO penjualan (id_penjualan, id_kasir, jumlah, total, tanggal, bayar, kembali, del) VALUES (?, ?, ?, ?, ?, ?, ?, 0);".$sql;
		$arr  = array_merge([$id, $kasir, $newJml, $newTtl, $date, $bayar, $kembali], $arr);
		$prep = DB::conn()->prepare($sql);
		return $prep->execute($arr);
	}

	static function del(){
		$id = explode(',' ,substr(Input::post('id'), 1));

		$sql = '';
		foreach ($id as $newId) {
			$sql .= "UPDATE penjualan SET del = 1 WHERE id_penjualan = ?;";
		}

		$prep = DB::conn()->prepare($sql);
		return $prep->execute($id);
	}
}