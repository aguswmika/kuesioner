<?php 
	$data['css'] = '
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
	';

	view('layouts/header', $data) 
?>

<div class="row mt-5">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<form method="POST" method="POST">
					<div class="form-group">
						<label>Semester</label>
						<select name="semester" class="form-control">
							<option value="">-- Pilih --</option>
							<?php foreach ($semester as $item) { ?>
								<option <?php if($item->id_semester === $kuesioner->id_semester) echo "selected" ?> value="<?php echo $item->id_semester ?>"><?php echo $item->tahun ?> - <?php echo ucfirst($item->nama_semester) ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Nama Kuesioner</label>
						<input type="text" class="form-control" name="nama" value="<?php echo $kuesioner->nama ?>">
					</div>
					<div class="form-group">
						<label>Status</label>
						<select name="status" class="form-control">
							<option value="aktif">Aktif</option>
							<option value="nonaktif" <?php if ($kuesioner->status == 'nonaktif') echo "selected" ?>>Nonaktif</option>
						</select>
					</div>
					<button type="submit" class="btn btn-warning">Edit</button>
					<a href="<?php echo base_url('?p=kuesioner') ?>" class="btn btn-primary">Kembali</a>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row mt-5">
	<div class="col-md-12">
		<?php echo Session::flash('error'); ?>
	</div>
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">List Pertanyaan</h4>
				<div class="mb-3">
					<a href="<?php echo base_url('?p=kuesioner&act=insert') ?>" class="btn btn-success">Tambah</a>
				</div>
				<div class="data-tables">
					<table id="dataTable" class="text-center">
						<thead class="bg-light text-capitalize">
							<tr>
								<th>No</th>
								<th>Judul pertanyaan</th>
								<th>Tipe</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$no = 1;
								foreach ($kuesioners as $item) { 
							?>
								<tr>
									<td><?php echo $no++; ?></td>
									<td>
										<?php 
											echo (strlen($item->pertanyaan) > 80)  ?
												 substr($item->pertanyaan, 0, 80) : $item->pertanyaan;
										?>
										
									</td>
									<td><label class="badge badge-info"><?php echo ucfirst($item->tipe) ?></label></td>
									<td>
										<a href="<?php echo base_url('?p=kuesioner&act=edit_question&id='.$item->id_pertanyaan) ?>" class="btn btn-warning btn-xs">Edit</a>
										<form action="<?php echo base_url('?p=kuesioner&act=delete_question') ?>" style="display: inline-block;" method="post">
											<input type="hidden" name="id" value="<?php echo $item->id_form ?>">
											<button type="submit" class="btn btn-danger btn-xs">Hapus</button>
										</form>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
$js = [
	'js' => '
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
	<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
'];

view('layouts/footer', $js) ?>