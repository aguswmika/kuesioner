<?php view('layouts/header', $data) ?>

<div class="row mt-5">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="form-group">
					<label>Tipe Pertanyaan</label>
					<select id="tipe_pertanyaan" class="form-control">
						<option value="opsional">Opsi</option>
						<option value="esay">Esay</option>
					</select>
				</div>
				<div class="form-group" id="container_jumlah_opsi">
					<label>Jumlah Opsi</label>
					<input type="number" id="jumlah_opsi" min="1" max="5" value="1" class="form-control">
				</div>
				<div class="form-group">
					<button type="button" id="button_pertanyaan" class="btn btn-info">Tambah</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<p align="right" id="max_pertanyaan">Jumlah pertanyaan : <span id="jumlah_pertanyaan">0</span>/<?php echo ($kuesioner->jumlah == 0) ? '40' : 40-$kuesioner->jumlah ?></p>
				<form method="POST">
					<input type="hidden" name="id_form" value="<?php echo $kuesioner->id_form ?>">
					<div id="form_pertanyaan">
						
					</div>
					<button type="submit" class="btn btn-success" id="button_simpan" style="display: none">Simpan</button>
					<a href="<?php echo base_url('?p=kuesioner') ?>" class="btn btn-primary">Kembali</a>
				</form>
			</div>
		</div>
	</div>
</div>

<?php view('layouts/footer') ?>
<script>
	$(document).ready(function(){
		var tipe_pertanyaan = 'opsional';

		//hilangin jumlah opsi kalo pilih essay
		$('#tipe_pertanyaan').change(function(){
			if($(this).val() == "opsional"){
				$('#container_jumlah_opsi').show();
			}else{
				$('#container_jumlah_opsi').hide();
			}

			tipe_pertanyaan = $(this).val();
		});

		function getJumlahPertanyaan(){
			var jml = $('div[id*="pertanyaan_"]').length;
			$('#jumlah_pertanyaan').text(jml);
			if(jml > 0){
				$('#button_simpan').show();
			}else{
				$('#button_simpan').hide();
			}

			return jml;
		}

		//index pertanyaan
		var index = 0, max = 40 - parseInt('<?php echo $kuesioner->jumlah ?>');


		$('#button_pertanyaan').click(function(){
			var append_form = '', 
				append_opsi = '', 
				jumlah_opsi = parseInt($('#jumlah_opsi').val()),
				jumlah_pertanyaan = getJumlahPertanyaan(); 

			if(jumlah_opsi > 5){
				alert('Jumlah opsi maksimal 5!');
				$('#jumlah_opsi').val(5);
				return false;
			}else if(jumlah_opsi < 1){
				alert('Jumlah opsi kurang dari 1!');
				$('#jumlah_opsi').val(1);
				return false;
			}

			if(jumlah_pertanyaan < max){

				if(tipe_pertanyaan == 'opsional'){
					append_opsi += '<div class="form-group">'+
									'<label>Opsi : </label>';
					for (var i = 0; i < jumlah_opsi; i++) {
						append_opsi += '<input type="text" name="opsi['+index+']['+i+']" class="form-control" placeholder="Masukan opsi '+(i+1)+'...">';
					}

					append_opsi += '</div>';
				}

				append_form =   '<div id="pertanyaan_'+index+'">'+
									'<div class="form-group">'+
										'<input type="hidden" name="tipe['+index+']" class="form-control" value="'+tipe_pertanyaan+'">'+
										'<label><b>Pertanyaan ke-'+(index+1)+' : </b></label>'+
										'<button type="button" data-id="pertanyaan_'+index+'" style="margin-left:10px;padding: 3px;margin-bottom: 5px" class="btn btn-danger btn-xs delete_pertanyaan"><i class="ti-trash"></i> Hapus</button>'+
										'<input type="text" name="pertanyaan['+index+']" class="form-control" placeholder="Masukan pertanyaan...">'+
									'</div>'+
									append_opsi+
								'</div>';



				$('#form_pertanyaan').append(append_form);
				getJumlahPertanyaan();
				index++;
			}else{
				$('#max_pertanyaan').css('color', 'red');
				alert('Pertanyaan sudah penuh!');
			}
		});

		$(document).on('click', '.delete_pertanyaan', function(){
			var id = $(this).attr('data-id');
			if(confirm('Apakah yang ingin dihapus?')){
				$('#'+id).remove();
				getJumlahPertanyaan();
				//console.log(id);
			}
		});


	});
</script>