<?php view('layouts/header', $data) ?>

<style>
	card-text{
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
	.list-group li{
		font-weight: normal;
		font-size: inherit;
	}
</style>

<div class="row mt-5">
	<div class="col-md-12">
		<?php echo Session::flash('error'); ?>
	</div>
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">Jawaban Kuesioner</h4>
				<div class="row" style="font-size: 18px">
					<div class="col-md-3"><b>Nama Kuesioner</b></div>
					<div class="col-md-9">: <?php echo $kuesioner->nama ?></div>
					<div class="col-md-3"><b>Semester</b></div>
					<div class="col-md-9">: <?php echo $kuesioner->tahun_semester.' - '.ucfirst($kuesioner->nama_semester) ?></div>
				</div>
				<ol class="list-pertanyaan" style="margin-top: 25px;display: block;">
					<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
					<?php $no = 0; ?>
					<?php foreach ($kuesioners as $item) { ?>
						<div class="form-group">
							<li><?php echo $item->pertanyaan ?></li>
							<?php if($item->tipe == 'opsional') {?>
								<?php $opsi = Kuesioner::getAllOption($item->id_pertanyaan) ?>
								<canvas id="<?php echo 'chart-'.$item->id_pertanyaan ?>" height="100"></canvas>
								<?php 
									$label = ''; 
									$data = ''; 
									foreach ($opsi as $item_opsi){
										$label .= ',"'.$item_opsi->value.'"';
										$data  .= ',"'.$item_opsi->hasil.'"';
									} 
								?>
								<script>
									var ctx = document.getElementById('<?php echo 'chart-'.$item->id_pertanyaan ?>');
									var myBarChart = new Chart(ctx, {
									    'type': 'bar',
											'data' : {
													'labels'   : [<?php echo substr($label, 1) ?>],
													'datasets' : [
															{
																'label': <?php echo '"'.$item->pertanyaan.'"' ?>,
																'data':[<?php echo substr($data, 1) ?>],
																'fill':false,
																'backgroundColor':[
																	'rgba(255, 99, 132, 0.2)',
																	'rgba(255, 159, 64, 0.2)',
																	'rgba(75, 192, 192, 0.2)',
																	'rgba(153, 102, 255, 0.2)',
																	'rgba(201, 203, 207, 0.2)'
																],
																'borderColor':[
																	'rgb(255, 99, 132)',
																	'rgb(255, 159, 64)',
																	'rgb(75, 192, 192)',
																	'rgb(153, 102, 255)',
																	'rgb(201, 203, 207)'],
																'borderWidth':1
															}
													]
												},
											'options' : {
												'scales' : {
													'yAxes':[
														{ 'ticks': {'beginAtZero':true} }
													]
												}
											} 
										});
								</script>
								
							<?php }else{ ?> 
								<?php $hasils = Hasilkuesioner::getAll($item->id_pertanyaan); ?>
								<ul class="list-group">
								<?php foreach ($hasils as $hasil) { ?>
									<li class="list-group-item"><?php echo $hasil->hasil_esay ?></li>
								<?php } ?>
								</ul>
							<?php }	?>
						</div>
					<?php 
						$no++;
					} ?>
				</ol>
			</div>
		</div>
	</div>
</div>

<?php view('layouts/footer') ?>

<script>

</script>