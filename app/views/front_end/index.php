<?php view('layouts/header', $data) ?>
<style media="screen">
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

          .card-title{
            text-align: justify;
            font-weight: normal;
          }

</style>
<div class="container-fluid">
  <div class="images-logo">
      <img src="<?php echo base_url('assets/images/logo/smadara.png')?>" alt="logo">
  </div>
  <div class="row">
    <div class="col-md-2">

    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h2 class="header">PETUNJUK PENGISIAN KUESIONER SMA NEGERI 2 SEMARAPURA</h2>
        </div>
        <div class="card-body">
          <p class="card-text">OM SWASTYASTU</p>
          <h4 class="card-title">1. Kuesioner SMA Negeri 2 Semarapura bertujuan untuk melakukan evaluasi terkait program sekolah, kinerja guru dan pegawai, serta fasilitas yang ada di lingkungan sekolah.</h4>
          <h4 class="card-title">2. Terdapat 2 tipe kuesioner yaitu optional dan esay. Tipe optional ini memungkinkan responden untuk menilai suatu isu berdasarkan skala ukur yang tersedia misalnya sangat tidak setuju, setuju, dan sangat setuju.
                                    Sedangkan tipe esay, responden dapat memberikan kritik dan saran yang konstruktif atau berupa pertanyaan terhadap isu yang diberikan.</h4>
          <h4 class="card-title">3. Data diri responden tidak direkam dalam jawaban yang diinputkan, sehingga isilah kuesioner dengan sejujurnya.</h4>
          <p class="card-text">OM SANTIH, SANTIH, SANTIH OM</p>
          <p a href="#" class="btn btn-primary">LANJUT</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php view('layouts/footer') ?>
