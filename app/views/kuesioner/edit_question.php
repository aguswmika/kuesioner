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
						<button type="button" class="btn btn-primary btn-xs" style="margin-bottom: 5px; <?php if($pertanyaan->tipe == 'opsional') { if(count($opsi) >= 5) echo 'display: none;'; } else {echo 'display: none';} ?>" id="insert_option">Tambah opsi</button>
						<label style="<?php if( $pertanyaan->tipe == 'esay' ){ echo 'display: none;'; } ?>" id="text_option"><small>(Kosongkan jika tidak digunakan)</small></label>

						<?php 
							$keyLast = 0;
							if( (count($opsi) > 0) && $pertanyaan->tipe == 'opsional' ){ 
						?>
							<?php foreach ($opsi as $key => $value) { ?>
								<input type="text" class="form-control" id="opsi_<?php echo $key ?>" name="opsi[<?php echo $key ?>]" value="<?php echo $value->value ?>">
							<?php 
									$keyLast = $key;
								} 
							?>
						<?php } ?>
						<input type="hidden" id="key_last" value="<?php echo $keyLast ?>">
					</div>
					<button type="submit" class="btn btn-warning">Edit</button>
					<a href="<?php echo base_url('?p=kuesioner&act=edit&id='.$pertanyaan->id_form) ?>" class="btn btn-primary">Kembali</a>
				</form>
			</div>
		</div>
	</div>
</div>

<?php view('layouts/footer') ?>

<script>
	$(document).ready(function(){
		function getType(){
			if($('select[name="tipe_pertanyaan"]').val() == 'esay'){
				$('#container_option').hide();
				$('#insert_option').hide();
				$('#text_option').hide();
			}else{
				$('#container_option').show();
				$('#text_option').show();
				if($('input[id*="opsi_"]').length < 5)
					$('#insert_option').show();
			}
		}

		getType();

		$('select[name="tipe_pertanyaan"]').change(function(){
			getType();
		});

		var keyLast = $('#key_last').val();


		$('#insert_option').click(function(){
			var count   = $('input[id*="opsi_"').length;
			if(count < 5) {
				keyLast++;
				var input   = '<input type="text" class="form-control" id="opsi_'+keyLast+'" name="opsi['+keyLast+']" value="">';
				$('#container_option').append(input);
			}else{
				alert('Jumlah opsi penuh!');
			}
		});


	});
</script>