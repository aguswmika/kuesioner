<?php view('layouts/header', $data) ?>

<div class="row mt-5">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<form method="POST" method="POST">
					<div class="form-group">
						<label>Judul Pertanyaan</label>
						<input type="text" class="form-control" name="nama" value="<?php echo $pertanyaan->pertanyaan ?>">
					</div>
					<div class="form-group">
						<label>Tipe</label>
						<select name="tipe_pertanyaan" class="form-control">
							<option value="opsional">Opsi</option>
							<option value="esay" <?php if($pertanyaan->tipe == 'esay') echo 'selected'; ?>>Esay</option>
						</select>
					</div>
					<div class="form-group" id="container_option">						
						<button type="button" class="btn btn-primary btn-xs" style="margin-bottom: 5px; <?php if( (count($opsi) >= 5) && $pertanyaan->tipe == 'opsional' ){ echo 'display: none;'; } ?>" id="insert_option">Tambah opsi</button>
						<?php if( (count($opsi) > 0) && $pertanyaan->tipe == 'opsional' ){ ?>
							<?php foreach ($opsi as $key => $value) { ?>
								<input type="text" class="form-control" id="opsi_<?php echo $key ?>" name="opsi[<?php echo $key ?>]" value="<?php echo $value->value ?>">
							<?php } ?>
						<?php } ?>
					</div>
					<button type="submit" class="btn btn-warning">Edit</button>
					<a href="<?php echo base_url('?p=kuesioner&act=edit&id='.$pertanyaan->id_form) ?>" class="btn btn-primary">Kembali</a>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

	});
</script>

<?php view('layouts/footer') ?>