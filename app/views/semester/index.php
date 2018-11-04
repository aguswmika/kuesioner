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
	<div class="col-md-12">
		<?php echo Session::flash('error'); ?>
	</div>
	<div class="col-md-5">
		<div class="card">
			<div class="card-body">
				<?php if(!empty(Input::get('id'))){ ?>
					<h4 class="header-title">Ubah Semester</h4>
				<?php }else{ ?>
					<h4 class="header-title">Tambah Semester</h4>
				<?php } ?>
				<form method="POST">
					<div class="form-group">
						<label>Tipe semester</label>
						<?php if(empty($singleSemester)){ ?>
							<select name="tipe" class="form-control">
								<option value="ganjil">Ganjil</option>
								<option value="genap">Genap</option>
							</select>
						<?php }else{ ?>
							<select name="tipe" class="form-control">
								<option value="ganjil">Ganjil</option>
								<option value="genap" <?php if($singleSemester->nama_semester == 'genap') echo 'selected'; ?>>Genap</option>
							</select>
						<?php } ?>
					</div>
					<div class="form-group">
						<label>Tahun</label>
						<input type="number" class="form-control" maxlength="4" name="tahun" value="<?php if(empty($singleSemester)) echo date('Y'); else echo $singleSemester->tahun; ?>">
					</div>
					<div class="form-group">
						<?php if(empty(Input::get('id'))) { ?>
							<button type="submit" class="btn btn-success">Tambah</button>
						<?php }else{ ?>
							<button type="submit" class="btn btn-warning">Ubah</button> 
							<a href="<?php echo base_url('?p=semester&act=index') ?>" class="btn btn-primary">Kembali</a>
						<?php } ?>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-7">

	</div>
</div>

<div class="row mt-5">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">Arsip Semester</h4>
				<div class="data-tables">
					<table id="dataTable" class="text-center">
						<thead class="bg-light text-capitalize">
							<tr>
								<th>No</th>
								<th>Tipe</th>
								<th>Tahun</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$no = 1;
								foreach ($semester as $item) { 
							?>
								<tr>
									<td><?php echo $no++; ?></td>
									<td><?php echo ucfirst($item->nama_semester); ?></td>
									<td><?php echo $item->tahun; ?></td>
									<td>
										<a href="<?php echo base_url('?p=semester&act=index&id='.$item->id_semester) ?>" class="btn btn-warning btn-xs">Edit</a>
										<form action="<?php echo base_url('?p=semester&act=delete') ?>" style="display: inline-block;" method="post">
											<input type="hidden" name="id" value="<?php echo $item->id_semester ?>">
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

<!-- Start datatable js -->
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