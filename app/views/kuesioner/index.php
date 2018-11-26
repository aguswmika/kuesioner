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
				<div class="data-tables" style="padding: 0px 50px;">
					<table id="dataTable" class="text-center">
						<thead class="bg-light text-capitalize">
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Semester</th>
								<th>Jumlah Pertanyaan</th>
								<th>Jumlah Jawaban</th>
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
										<a href="<?php echo base_url('view/'.htmlentities($item->slug)) ?>" target="_blank">
											<?php 
												echo htmlentities((strlen($item->nama) > 80)  ?
													 substr($item->nama, 0, 80) : $item->nama);
											?>
										</a>
										
									</td>
									<td><?php echo htmlentities($item->tahun_semester.' - '.ucfirst($item->nama_semester)); ?></td>
									<td><label class="badge badge-dark"><?php echo htmlentities($item->jumlah) ?></label></td>
									<td><label class="badge badge-light"><?php echo htmlentities($item->jumlah_jawaban) ?></label></td>
									<td><?php echo htmlentities(date('d-m-Y H:i', strtotime($item->tanggal))); ?></td>
									<td><label class="badge badge-success"><?php echo htmlentities(ucfirst($item->status)) ?></label></td>
									<td>
										<div class="btn-group" role="group">
										    <button id="btnGroupDrop1" type="button" class="btn btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    	Aksi
										    </button>
										    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
										    	<button class="btn-link dropdown-item text-dark" type="button" onclick="copyStringToClipboard('<?php echo base_url('view/'.$item->slug) ?>')">Dapatkan link</button>
										    	<a class="dropdown-item text-info" href="<?php echo base_url('?p=kuesioner&act=insert_question&id='.$item->id_form) ?>">Tambah Pertanyaan</a>
										    	<a class="dropdown-item text-primary" href="<?php echo base_url('?p=kuesioner&act=view_answer&id='.$item->id_form) ?>">Lihat Jawaban</a>
										    	<a class="dropdown-item text-warning" href="<?php echo base_url('?p=kuesioner&act=edit&id='.$item->id_form) ?>">Edit</a>
										    	<form action="<?php echo base_url('?p=kuesioner&act=delete') ?>" style="display: inline;" method="post" onclick="return confirm('Apakah yakin ingin dihapus?')">
													<input type="hidden" name="id" value="<?php echo $item->id_form ?>">
													<button type="submit" class="dropdown-item btn-link text-danger">Hapus</button>
												</form>
										    </div>
										</div>
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
<script>
	function copyStringToClipboard (str) {
	   // Create new element
	   var el = document.createElement('textarea');
	   // Set value (string to be copied)
	   el.value = str;
	   // Set non-editable to avoid focus and move outside of view
	   el.setAttribute('readonly', '');
	   el.style = {position: 'absolute', left: '-9999px'};
	   document.body.appendChild(el);
	   // Select text inside element
	   el.select();
	   // Copy text to clipboard
	   document.execCommand('copy');
	   // Remove temporary element
	   document.body.removeChild(el);
	   alert('Link sudah di copy');
	}
</script>

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