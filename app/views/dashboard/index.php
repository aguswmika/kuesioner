<?php view('layouts/header', $data) ?>
<div class="row mt-3">
	<div class="col-md-12">
		<div class="alert alert-success">
				Selamat datang di dashboard <b><?php echo Session::sess('nama') ?></b>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
            <div class="seo-fact sbg1">
            	<div class="p-4 d-flex justify-content-between align-items-center">
	                <div class="seofct-icon"><i class="ti-book"></i> Kuesioner</div>
	                <h2><?php echo $kuesioner ?></h2>
                </div>
            </div>
        </div>
	</div>
	<div class="col-md-4">
		<div class="card">
            <div class="seo-fact sbg2">
            	<div class="p-4 d-flex justify-content-between align-items-center">
	                <div class="seofct-icon"><i class="ti-user"></i> Responden</div>
	                <h2><?php echo $responden ?></h2>
                </div>
            </div>
        </div>
	</div>
	<div class="col-md-4">
		<div class="card">
            <div class="seo-fact sbg3">
            	<div class="p-4 d-flex justify-content-between align-items-center">
	                <div class="seofct-icon"><i class="ti-agenda"></i> Semester</div>
	                <h2><?php echo $semester ?></h2>
                </div>
            </div>
        </div>
	</div>
</div>
<?php view('layouts/footer') ?>