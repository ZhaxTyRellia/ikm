<div class="hero-wrap">
  <div class="overlay"></div>
  <div class="container-fluid">
    <div class="slider-text d-md-flex align-items-center">
      <div class="one-forth ftco-animate align-self-md-center">
        <h1 class="mb-4"> Satisfaction Survey
          <strong class="typewrite" data-period="4000"
            data-type='[ "System", "Instansi", "CV. Bintang Sembilan", "Perhotelan", "Puskesmas", "Rumah Sakit" ]'>
            <span class="wrap"></span>
          </strong>
        </h1>
        <p class="mb-md-5 mb-sm-3">Aplikasi ini
          berguna untuk menampung dan mengolah data kepuasan pengunjung,<br>
          Sehingga Setiap instansi yang menggunakan indeks kepuasan bisa mengevaluasi kinerja dalam hal personal
          untuk public.</p>
        <p>
          <a href="#" class="btn btn-primary px-4 py-3">Bintang Sembilan</a>
        </p>
      </div>
      <div class="one-half align-self-md-end align-self-sm-center">
        <div class="slider-carousel owl-carousel">
          <div class="item">
            <img src="<?= $basePath ?>/images/dashboard_full_1.png" class="img-fluid img" alt="">
          </div>
          <div class="item">
            <img src="<?= $basePath ?>/images/dashboard_full_2.png" class="img-fluid img" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section ftco-section-2">
  <div class="container"><div class="row"></div></div>
</section>

<div class="container-fluid">
  <div class="one-forth ftco-animate align-self-md-center">
    <div class="row justify-content-center mb-5 pb-5">
      <div class="col-md-7 text-center heading-section ftco-animate">
        <h2 class="mb-2">Jumlah Indeks Data Survey</h2>
        <span class="subheading">Satisfaction Survey System</span>
      </div>
    </div>

    <div class="ftco-section ftco-counter img" id="section-counter">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-11">
            <div class="row">
              <?php foreach ($counters as $counterNum => $total): ?>
                <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                  <div class="block-18 text-center">
                    <div class="text">
                      <strong class="number" data-number="<?= (int) $total ?>">0</strong>
                      <span>counter <?= (int) $counterNum ?></span>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
