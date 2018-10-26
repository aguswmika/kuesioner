<?php 

class Buku
{
	
	static function getAll($limit = 0){
		$sql = "SELECT * FROM buku_view WHERE del = 0";

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
		$sql = "SELECT * FROM buku_view WHERE id_buku = ?";

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$id]);
		return $prep->fetch(PDO::FETCH_OBJ);
	}

	static function getPj(){
		$sql = "SELECT * FROM buku_view WHERE stok > 0 AND del = 0";


		$prep = DB::conn()->prepare($sql);
		$prep->execute();
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	static function search($search){
		$search = '%'.$search.'%';
		$sql = "SELECT * FROM buku_view WHERE (id_buku LIKE ? OR judul LIKE ? OR penerbit LIKE ? OR penulis LIKE ?) AND del = 0";

		$prep = DB::conn()->prepare($sql);
		$prep->execute([$search, $search, $search, $search]);
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	static function getStats(){
		$sql = "SELECT count(*) as jml, sum(stok) as stk FROM buku_view WHERE del = 0";

		$prep = DB::conn()->prepare($sql);
		$prep->execute();
		return $prep->fetch(PDO::FETCH_OBJ);
	}

	static function add(){
		$id      = autoNum('buku', 'id_buku', 'BK');
		
		$judul    = Input::post('judul');
		$noisbn   = Input::post('noisbn');
		$penulis  = Input::post('penulis');
		$penerbit = Input::post('penerbit');
		$tahun    = Input::post('tahun');
		$pokok    = Input::post('pokok');
		$jual     = Input::post('jual');
		$ppn      = Input::post('ppn');
		$diskon   = Input::post('diskon');
		$slug     = filter_var(str_replace('&', '', str_replace('#', '', str_replace(' ', '-', strtolower(Input::post('judul'))))), FILTER_SANITIZE_URL);


		if(!empty($_FILES['gambar']['name'])){
			if($_FILES['gambar']['size'] < 2000000){
				move_uploaded_file($_FILES['gambar']['tmp_name'], '../uploads/'.$_FILES['gambar']['name']);
				$gambar = $_FILES['gambar']['name'];
			}
		}else{
			$gambar = NULL;
		}


		$sql  = "INSERT INTO buku (id_buku, judul, noisbn, penulis, penerbit, tahun, stok, harga_pokok, harga_jual, ppn, diskon, slug, gambar, del) VALUES (?, ?, ?, ?, ?, ?, 0, ?, ?, ?, ?, ?, ?, 0);";
		$prep = DB::conn()->prepare($sql);
		return $prep->execute([$id, $judul, $noisbn, $penulis, $penerbit, $tahun, $pokok, $jual, $ppn, $diskon, $slug, $gambar]);
	}

	static function edit($id){
		$judul    = Input::post('judul');
		$noisbn   = Input::post('noisbn');
		$penulis  = Input::post('penulis');
		$penerbit = Input::post('penerbit');
		$tahun    = Input::post('tahun');
		$pokok    = Input::post('pokok');
		$jual     = Input::post('jual');
		$ppn      = Input::post('ppn');
		$diskon   = Input::post('diskon');
		$slug     = filter_var(str_replace('&', '', str_replace('#', '', str_replace(' ', '-', strtolower(Input::post('judul'))))), FILTER_SANITIZE_URL);

		if(!empty($_FILES['gambar']['name'])){
			if($_FILES['gambar']['size'] < 2000000){

				if(file_exists('../uploads/'.$_FILES['gambar']['name'])){
					unlink('../uploads/'.$_FILES['gambar']['name']);
				}

				move_uploaded_file($_FILES['gambar']['tmp_name'], '../uploads/'.$_FILES['gambar']['name']);
				$gambar = $_FILES['gambar']['name'];

				$sql  = "UPDATE buku SET judul = ?, noisbn = ?, penulis = ?, penerbit = ?, tahun = ?, harga_pokok = ?, harga_jual = ?, ppn = ?, diskon = ?, slug = ?, gambar = ? WHERE id_buku = ?";
				$prep = DB::conn()->prepare($sql);
				return $prep->execute([$judul, $noisbn, $penulis, $penerbit, $tahun, $pokok, $jual, $ppn, $diskon, $slug, $gambar, $id]);
			}
		}else{
			$sql  = "UPDATE buku SET judul = ?, noisbn = ?, penulis = ?, penerbit = ?, tahun = ?, harga_pokok = ?, harga_jual = ?, ppn = ?, diskon = ?, slug = ? WHERE id_buku = ?";
			$prep = DB::conn()->prepare($sql);
			return $prep->execute([$judul, $noisbn, $penulis, $penerbit, $tahun, $pokok, $jual, $ppn, $diskon, $slug, $id]);
		}
	}

	static function del(){
		$id = explode(',' ,substr(Input::post('id'), 1));

		$sql = '';
		foreach ($id as $newId) {
			$sql .= "UPDATE buku SET del = 1 WHERE id_buku = ?;";
		}

		$prep = DB::conn()->prepare($sql);
		return $prep->execute($id);
	}
}