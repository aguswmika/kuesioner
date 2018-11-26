<?php view('layouts/header', $data) ?>
<style>
	body{
		background-color: #eeeeee;
	}

	.images-logo{
		margin: 20px 0;
	}

	.card-header{
		background-color: green;
		color: white;
		text-align: center;
	}

	.images-logo img{
		height: 75px;
		width: 75px;
	}

	.card-text{
		font-weight: normal;
		font-size: 17px;
	}
	
	ol{
		margin: 10px 0px 18px 14px;
	}

	ol li{
		font-size: 17px;
		text-align: justify;
	}
	.list-pertanyaan li{
		font-size: 20px;
		font-weight: bold;
	}
</style>
<div class="container-fluid">
	<div class="images-logo">
		<img src="<?php echo base_url('assets/images/logo/smadara.png')?>" alt="logo">
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php echo Session::flash('error'); ?>
		</div>
		<div class="col-md-2">

		</div>
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h3 class="header" id="textKuesioner">
						<?php if(empty(Session::sess('save'))){  ?>
							PETUNJUK PENGISIAN KUESIONER SMA NEGERI 2 SEMARAPURA
						<?php }else{ ?>
							PEMBERITAHUAN
						<?php } ?>
					</h3>
				</div>
				<div class="card-body">
					<?php if(empty(Session::sess('save'))){ ?>
					<div id="loading"></div>
					<div id="petunjuk">
						<p class="card-text">OM SWASTYASTU</p>
						<ol>
							<li><p class="card-text">Kuesioner SMA Negeri 2 Semarapura bertujuan untuk melakukan evaluasi terkait program sekolah, kinerja guru dan pegawai, serta fasilitas yang ada di lingkungan sekolah.</p></li>
							<li><p class="card-text">Terdapat 2 tipe kuesioner yaitu optional dan esay. Tipe optional ini memungkinkan responden untuk menilai suatu isu berdasarkan skala ukur yang tersedia misalnya sangat tidak setuju, setuju, dan sangat setuju.
											Sedangkan tipe esay, responden dapat memberikan kritik dan saran yang konstruktif atau berupa pertanyaan terhadap isu yang diberikan.</p></li>
							<li><p class="card-text">Data diri responden tidak direkam dalam jawaban yang diinputkan, sehingga isilah kuesioner dengan sejujurnya.</p></li>
						</ol>
						<p class="card-text">OM SANTIH, SANTIH, SANTIH OM</p>
						<p a href="#" class="btn btn-primary" id="btnLanjut">LANJUT</a></p>
					</div>
					<div id="kuesioner" style="display: none;">
						<div class="row" style="font-size: 18px">
							<div class="col-md-3"><b>Nama Kuesioner</b></div>
							<div class="col-md-9">: <?php echo htmlentities($kuesioner->nama) ?></div>
							<div class="col-md-3"><b>Semester</b></div>
							<div class="col-md-9">: <?php echo htmlentities($kuesioner->tahun_semester.' - '.ucfirst($kuesioner->nama_semester)) ?></div>
						</div>
						<ol class="list-pertanyaan">
							<form method="POST">
								<?php $no = 0; ?>
								<?php foreach ($kuesioners as $item) { ?>
										<div class="form-group">
											<input type="hidden" name="id_pertanyaan[<?php echo $no ?>]" value="<?php echo htmlentities($item->id_pertanyaan) ?>">
											<li><?php echo htmlentities($item->pertanyaan) ?></li>
											<input type="hidden" name="tipe[<?php echo $no ?>]" value="<?php echo htmlentities($item->tipe) ?>">
											<?php if($item->tipe == 'opsional') {?>
												<?php $opsi = Kuesioner::getAllOption(htmlentities($item->id_pertanyaan)) ?>
												<?php foreach ($opsi as $item_opsi) { ?>
													<label for='opsi_<?php echo htmlentities($item_opsi->id_opsi)  ?>'>
														<input required id='opsi_<?php echo htmlentities($item_opsi->id_opsi)  ?>' type="radio" name="opsi[<?php echo $no ?>]" value="<?php echo htmlentities($item_opsi->id_opsi) ?>">  
														<span style="margin-left: 10px"><?php echo htmlentities($item_opsi->value) ?></span>
													</label><br>
												<?php } ?>
											<?php }else{ ?> 
												<textarea required class="form-control" name="esay[<?php echo $no ?>]" rows="6" placeholder="Masukkan jawaban disini, maksimal 1000 kata" maxlength="1000"></textarea>
											<?php }	?>
										</div>
								<?php 
									$no++;
								} ?>
								<div class="form-group">
									<button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin melanjutkan?')">Simpan</button>
								</div>
							</form>
						</ol>
					</div>
					<?php }else{ ?>
						<?php if(Session::sess('save') == 'benar'){ ?>
							<p class="card-text" align="center">Terima kasih, sistem telah berhasil menyimpan semua jawaban Anda</p>
						<?php }else{ ?>
							<p class="card-text" align="center" style="color: #e57373;">Mohon maaf, sistem telah gagal menyimpan semua jawaban Anda</p>
						<?php } ?>
					<?php unset($_SESSION['save']); } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php view('layouts/footer') ?>
<script>
	$(document).ready(function(){
		$('#btnLanjut').click(function(){
			if(confirm('Apakah Anda yakin ingin melanjutkan?')){
				$('#petunjuk').fadeOut();
				$('#loading').text('Loading...').fadeIn();
				setTimeout(function(){
					$('#loading').fadeOut(function(){
						$('#kuesioner').fadeIn();
						$('#textKuesioner').text('PENGISIAN KUESIONER');
					});
				}, 1000);
			}
		});
	});
</script>
