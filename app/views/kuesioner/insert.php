<?php view('layouts/header', $data) ?>

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
								<option value="<?php echo $item->id_semester ?>"><?php echo $item->tahun ?> - <?php echo ucfirst($item->nama_semester) ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Nama Kuesioner</label>
						<input type="text" class="form-control" name="nama">
					</div>
					<div class="form-group">
						<label>Status</label>
						<select name="status" class="form-control">
							<option value="aktif">Aktif</option>
							<option value="nonaktif">Nonaktif</option>
						</select>
					</div>
					<button type="submit" class="btn btn-success">Tambah</button>
					<a href="<?php echo base_url('?p=kuesioner') ?>" class="btn btn-primary">Kembali</a>
				</form>
			</div>
		</div>
	</div>
</div>

<?php view('layouts/footer') ?>