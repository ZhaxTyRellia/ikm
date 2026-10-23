<div class="container">
    <!-- Header Management Admin -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">Management Operator &amp; Pertanyaan Dinamis</h3>
            <p class="text-muted mb-0">
                Kelola tambah/kurang profil target operator, atur jumlah pertanyaan dinamis (1–10 pertanyaan + 1 feedback akhir), serta pantau hasil survei &amp; rating bintang.
            </p>
        </div>
        <div class="mt-3 mt-md-0 d-flex flex-wrap" style="gap: 10px;">
            <a href="<?= $basePath ?>/admin/account_add" class="btn btn-primary font-weight-bold shadow-sm">
                + Tambah Operator Baru
            </a>
        </div>
    </div>

    <!-- Ringkasan Cepat -->
    <?php
    $totalOperators = count($operators ?? []);
    $totalResponses = 0;
    foreach (($operators ?? []) as $opRow) {
        $totalResponses += (int) ($opRow['total_suara'] ?? 0);
    }
    ?>
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #1e3a8a !important;">
                <div class="card-body py-3">
                    <div class="text-muted small font-weight-bold text-uppercase">Total Target Operator</div>
                    <div class="h3 font-weight-bold text-dark mb-0"><?= $totalOperators ?> Operator</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0d9488 !important;">
                <div class="card-body py-3">
                    <div class="text-muted small font-weight-bold text-uppercase">Total Partisipasi Survei</div>
                    <div class="h3 font-weight-bold text-dark mb-0"><?= $totalResponses ?> Suara Masuk</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #f59e0b !important;">
                <div class="card-body py-3">
                    <div class="text-muted small font-weight-bold text-uppercase">Skema Kuesioner</div>
                    <div class="h6 font-weight-bold text-dark mb-0 mt-1">1–10 Pertanyaan Radio + 1 Catatan Feedback (Opsional)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Card Management Operator -->
    <div class="row">
        <?php if (empty($operators)): ?>
            <div class="col-12">
                <div class="alert alert-warning text-center py-4 shadow-sm">
                    Belum ada target Operator. Silakan klik tombol <strong>+ Tambah Operator Baru</strong> di atas.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($operators as $op): ?>
                <?php
                $photoUrl = !empty($op['photo'])
                    ? $basePath . '/' . ltrim($op['photo'], '/')
                    : $basePath . '/images/user.png';
                $starsFilled = (int) ($op['stars_filled'] ?? 0);
                $starRating  = number_format((float) ($op['star_rating'] ?? 0), 1);
                $totalSuara  = (int) ($op['total_suara'] ?? 0);
                $qCount      = (int) ($op['question_count'] ?? 0);
                ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px;">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <img src="<?= htmlspecialchars($photoUrl) ?>"
                                     alt="<?= htmlspecialchars($op['name']) ?>"
                                     class="rounded-circle border mr-3"
                                     style="width: 68px; height: 68px; object-fit: cover;" />
                                <div>
                                    <h5 class="font-weight-bold text-dark mb-0"><?= htmlspecialchars($op['name']) ?></h5>
                                    <div class="small text-muted">@<?= htmlspecialchars($op['username']) ?> (ID: <?= (int) $op['id'] ?>)</div>
                                    <span class="badge badge-<?= htmlspecialchars($op['status_class'] ?? 'secondary') ?> mt-1">
                                        <?= htmlspecialchars($op['status_label'] ?? 'Belum Dinilai') ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Statistik Rating & Pertanyaan -->
                            <div class="bg-light rounded p-3 mb-3 border">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small text-muted font-weight-bold">Akumulasi Rating:</span>
                                    <span class="font-weight-bold text-warning" style="letter-spacing: 1px;">
                                        <?php for ($s = 1; $s <= 5; $s++): ?>
                                            <?= $s <= $starsFilled ? '&#9733;' : '&#9734;' ?>
                                        <?php endfor; ?>
                                        <span class="text-dark ml-1">(<?= $starRating ?>)</span>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small text-muted">Jumlah Responden:</span>
                                    <span class="badge badge-primary px-2 py-1"><?= $totalSuara ?> Suara</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small text-muted">Konfigurasi Soal:</span>
                                    <span class="badge badge-info px-2 py-1"><?= $qCount ?> Radio + 1 Feedback</span>
                                </div>
                            </div>

                            <!-- Identitas Operator -->
                            <div class="small text-muted mb-3">
                                <div class="mb-1"><strong>Unit/Alamat:</strong> <?= htmlspecialchars($op['address'] ?: '-') ?></div>
                                <div class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($op['email'] ?: '-') ?></div>
                                <div><strong>No. HP:</strong> <?= htmlspecialchars($op['mobile'] ?: '-') ?></div>
                            </div>

                            <!-- Tombol Aksi Management -->
                            <div class="mt-auto pt-2 border-top">
                                <div class="row no-gutters mb-2">
                                    <div class="col-6 pr-1">
                                        <a href="<?= $basePath ?>/admin/question_table?counter=<?= urlencode((string) $op['id']) ?>"
                                           class="btn btn-info btn-sm btn-block font-weight-bold">
                                            Atur Pertanyaan (<?= $qCount ?>)
                                        </a>
                                    </div>
                                    <div class="col-6 pl-1">
                                        <a href="<?= $basePath ?>/admin/data_table?counter=<?= urlencode((string) $op['id']) ?>"
                                           class="btn btn-success btn-sm btn-block font-weight-bold">
                                            Hasil &amp; Feedback
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="<?= $basePath ?>/survey?id=<?= urlencode((string) $op['id']) ?>"
                                       target="_blank"
                                       class="btn btn-outline-primary btn-sm">
                                        Buka Form Survei &nearr;
                                    </a>
                                    <div>
                                        <a href="<?= $basePath ?>/admin/account_edit?id=<?= (int) $op['id'] ?>"
                                           class="btn btn-outline-secondary btn-sm">
                                            Edit Profil
                                        </a>
                                        <a href="<?= $basePath ?>/admin/account_delete?id=<?= (int) $op['id'] ?>"
                                           class="btn btn-outline-danger btn-sm"
                                           onclick="return confirm('Yakin ingin menghapus operator <?= htmlspecialchars(addslashes($op['name'])) ?> beserta data surveinya?');">
                                            Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
