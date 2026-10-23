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
          <a href="#section-counter" class="btn btn-primary px-4 py-3">Pilih Target Survei</a>
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

<div class="container-fluid" id="section-counter">
  <div class="one-forth ftco-animate align-self-md-center">
    <div class="row justify-content-center mb-5 pb-3">
      <div class="col-md-8 text-center heading-section ftco-animate">
        <h2 class="mb-2">Target Survei Kepuasan (Suara Rakyat)</h2>
        <span class="subheading">Pilih Operator Pelayanan untuk memberikan penilaian &amp; melihat jumlah indeks suara</span>
      </div>
    </div>

    <div class="container pb-5">
      <div class="row justify-content-center">
        <?php if (empty($operators)): ?>
          <div class="col-md-8 text-center py-4">
            <p class="text-muted">Belum ada akun target Operator yang dibuat oleh Admin.</p>
          </div>
        <?php else: ?>
          <?php foreach ($operators as $op): ?>
            <?php
            $photoUrl = !empty($op['photo'])
                ? $basePath . '/' . ltrim((string) $op['photo'], '/')
                : $basePath . '/images/logo.png';
            ?>
            <div class="col-md-4 d-flex align-items-stretch ftco-animate">
              <div class="operator-card text-center d-flex flex-column justify-content-between">
                <div>
                  <img src="<?= htmlspecialchars($photoUrl, ENT_QUOTES, 'UTF-8') ?>"
                       alt="<?= htmlspecialchars((string) $op['name'], ENT_QUOTES, 'UTF-8') ?>"
                       class="operator-avatar">
                  <h4 class="font-weight-bold mb-1"><?= htmlspecialchars((string) ($op['name'] ?: $op['username']), ENT_QUOTES, 'UTF-8') ?></h4>
                  <span class="badge badge-info mb-2">ID Operator #<?= (int) $op['id'] ?> &bull; @<?= htmlspecialchars((string) $op['username'], ENT_QUOTES, 'UTF-8') ?></span>

                  <div class="operator-meta">
                    <div><strong>Alamat/Unit:</strong> <?= htmlspecialchars((string) ($op['address'] ?: '-'), ENT_QUOTES, 'UTF-8') ?></div>
                    <div><strong>Email:</strong> <?= htmlspecialchars((string) ($op['email'] ?: '-'), ENT_QUOTES, 'UTF-8') ?></div>
                    <div><strong>No. HP:</strong> <?= htmlspecialchars((string) ($op['mobile'] ?: '-'), ENT_QUOTES, 'UTF-8') ?></div>
                  </div>
                </div>

                <div>
                  <div class="suara-badge">
                    <strong class="number" data-number="<?= (int) ($op['total_suara'] ?? 0) ?>"><?= (int) ($op['total_suara'] ?? 0) ?></strong>
                    <small>Total Suara Rakyat</small>
                  </div>

                  <a href="<?= $basePath ?>/survey?id=<?= urlencode((string) $op['id']) ?>"
                     class="btn btn-primary btn-block py-2 font-weight-bold">
                    Beri Suara / Mulai Survei
                  </a>

                  <?php if (!empty($isAdmin)): ?>
                    <div class="mt-2 d-flex justify-content-between">
                      <a href="<?= $basePath ?>/admin/data_table?counter=<?= urlencode((string) $op['id']) ?>" class="btn btn-sm btn-outline-secondary w-50 mr-1">Rekap Data</a>
                      <a href="<?= $basePath ?>/admin/question_table?counter=<?= urlencode((string) $op['id']) ?>" class="btn btn-sm btn-outline-info w-50 ml-1">Pertanyaan</a>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
