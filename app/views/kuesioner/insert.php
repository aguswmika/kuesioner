<?php view('layouts/header', $data) ?>

<div class="row mt-5">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<form method="POST">
					<div class="form-group">
						<label>Nama Kuesioner</label>
						<input type="text" class="form-control" name="nama">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php view('layouts/footer') ?>