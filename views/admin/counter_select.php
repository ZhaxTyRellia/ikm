<section class="ftco-section ftco-work">
  <div class="container">
    <div class="row justify-content-center mb-5 pb-3">
      <div class="col-md-8 text-center heading-section ftco-animate">
        <h1 class="mb-3"><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h1>
        <span class="subheading">Satisfaction Survey System</span>
      </div>
    </div>
    <div class="row justify-content-center">
      <?php if (empty($operators)): ?>
        <div class="col-md-8 text-center">
          <p>Belum ada akun Operator. Silakan tambahkan di menu <a href="<?= $basePath ?>/admin/account_add">Account</a>.</p>
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
                <span class="badge badge-info mb-2">@<?= htmlspecialchars((string) $op['username'], ENT_QUOTES, 'UTF-8') ?> (ID #<?= (int) $op['id'] ?>)</span>
                <div class="operator-meta">
                  <div><strong>Alamat/Unit:</strong> <?= htmlspecialchars((string) ($op['address'] ?: '-'), ENT_QUOTES, 'UTF-8') ?></div>
                  <div><strong>Email:</strong> <?= htmlspecialchars((string) ($op['email'] ?: '-'), ENT_QUOTES, 'UTF-8') ?></div>
                  <div><strong>No. HP:</strong> <?= htmlspecialchars((string) ($op['mobile'] ?: '-'), ENT_QUOTES, 'UTF-8') ?></div>
                  <div><strong>Suara Masuk:</strong> <?= (int) ($op['total_suara'] ?? 0) ?> suara</div>
                </div>
                <p class="small text-muted mb-3"><?= $cardDescription ?></p>
              </div>
              <a href="<?= $basePath . $targetRoute . urlencode((string) $op['id']) ?>" class="btn btn-primary btn-block py-2 font-weight-bold">
                Buka Target Operator
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>
