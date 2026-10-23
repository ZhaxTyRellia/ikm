<div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-1"><?= htmlspecialchars($heading ?? 'Pilih Target Operator', ENT_QUOTES, 'UTF-8') ?></h3>
            <p class="text-muted mb-0">Pilih salah satu operator di bawah ini untuk melanjutkan.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="<?= $basePath ?>/admin/home" class="btn btn-outline-secondary btn-sm font-weight-bold">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="row">
        <?php if (empty($operators)): ?>
            <div class="col-12">
                <div class="alert alert-warning text-center py-4">
                    Belum ada akun Operator. Silakan tambahkan di menu <a href="<?= $basePath ?>/admin/account_add">Tambah Operator</a>.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($operators as $op): ?>
                <?php
                $photoUrl = !empty($op['photo'])
                    ? $basePath . '/' . ltrim((string) $op['photo'], '/')
                    : $basePath . '/images/user.png';
                $starsFilled = (int) ($op['stars_filled'] ?? 0);
                $starRating  = number_format((float) ($op['star_rating'] ?? 0), 1);
                ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px;">
                        <div class="card-body text-center d-flex flex-column justify-content-between p-4">
                            <div>
                                <img src="<?= htmlspecialchars($photoUrl, ENT_QUOTES, 'UTF-8') ?>"
                                     alt="<?= htmlspecialchars((string) $op['name'], ENT_QUOTES, 'UTF-8') ?>"
                                     class="rounded-circle border mb-3"
                                     style="width: 84px; height: 84px; object-fit: cover;" />
                                <h5 class="font-weight-bold mb-1"><?= htmlspecialchars((string) ($op['name'] ?: $op['username']), ENT_QUOTES, 'UTF-8') ?></h5>
                                <div class="small text-muted mb-2">@<?= htmlspecialchars((string) $op['username'], ENT_QUOTES, 'UTF-8') ?> (ID #<?= (int) $op['id'] ?>)</div>
                                <div class="mb-2">
                                    <span class="text-warning font-weight-bold">
                                        <?php for ($s = 1; $s <= 5; $s++): ?>
                                            <?= $s <= $starsFilled ? '&#9733;' : '&#9734;' ?>
                                        <?php endfor; ?>
                                    </span>
                                    <span class="small font-weight-bold text-dark">(<?= $starRating ?> / 5.0)</span>
                                    <span class="badge badge-<?= htmlspecialchars($op['status_class'] ?? 'secondary') ?> ml-1">
                                        <?= htmlspecialchars($op['status_label'] ?? 'Belum Dinilai') ?>
                                    </span>
                                </div>
                                <div class="bg-light rounded p-2 small text-left mb-3 border">
                                    <div><strong>Unit/Alamat:</strong> <?= htmlspecialchars((string) ($op['address'] ?: '-'), ENT_QUOTES, 'UTF-8') ?></div>
                                    <div><strong>Responden:</strong> <?= (int) ($op['total_suara'] ?? 0) ?> suara &bull; <?= (int) ($op['question_count'] ?? 0) ?> soal</div>
                                </div>
                                <p class="small text-muted mb-3"><?= htmlspecialchars($cardDescription ?? '') ?></p>
                            </div>
                            <a href="<?= $basePath . $targetRoute . urlencode((string) $op['id']) ?>" class="btn btn-primary btn-block font-weight-bold">
                                Pilih Operator Ini &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
