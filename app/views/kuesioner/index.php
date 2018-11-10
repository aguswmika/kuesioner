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
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">Arsip Kuesioner</h4>
				<div class="mb-3">
					<a href="<?php echo base_url('?p=kuesioner&act=insert') ?>" class="btn btn-success">Tambah</a>
				</div>
				<div class="data-tables">
					<table id="dataTable" class="text-center">
						<thead class="bg-light text-capitalize">
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Semester</th>
								<th>Jumlah Pertanyaan</th>
								<th>Tanggal dibuat</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$no = 1;
								foreach ($kuesioner as $item) { 
							?>
								<tr>
									<td><?php echo $no++; ?></td>
									<td>
										<a href="<?php echo base_url('?p=front_end&slug='.$item->slug) ?>">
											<?php 
												echo (strlen($item->nama) > 80)  ?
													 substr($item->nama, 0, 80) : $item->nama;
											?>
										</a>
										
									</td>
									<td><?php echo $item->tahun_semester.' - '.ucfirst($item->nama_semester); ?></td>
									<td><label class="badge badge-dark"><?php echo $item->jumlah ?></label></td>
									<td><?php echo date('d-m-Y H:i', strtotime($item->tanggal)); ?></td>
									<td><label class="badge badge-success"><?php echo ucfirst($item->status) ?></label></td>
									<td>
										<div style="margin-bottom: 5px">
											<a href="<?php echo base_url('?p=kuesioner&act=insert_question&id='.$item->id_form) ?>" class="btn btn-info btn-xs">Tambah Pertanyaan</a>
										</div>
										<a href="<?php echo base_url('?p=kuesioner&act=edit&id='.$item->id_form) ?>" class="btn btn-warning btn-xs">Edit</a>
										<form action="<?php echo base_url('?p=kuesioner&act=delete') ?>" style="display: inline-block;" method="post">
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