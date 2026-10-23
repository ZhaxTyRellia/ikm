<?php if (($section ?? '') === 'export'): ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <?php
    $opName = $operator['name'] ?? "Operator {$counter}";
    $qList = array_values($questions ?? []);
    $qCount = max(1, count($qList));
    ?>
    <title>Data Survey <?= htmlspecialchars($opName, ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
    <h2 align="center"><strong>Data Survey: <?= htmlspecialchars($opName, ENT_QUOTES, 'UTF-8') ?></strong></h2>
    <?php if (!empty($operator)): ?>
        <p align="center">
            Alamat/Unit: <?= htmlspecialchars((string) ($operator['address'] ?: '-'), ENT_QUOTES, 'UTF-8') ?> |
            Email: <?= htmlspecialchars((string) ($operator['email'] ?: '-'), ENT_QUOTES, 'UTF-8') ?> |
            No. HP: <?= htmlspecialchars((string) ($operator['mobile'] ?: '-'), ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>
    <br />
    <table border="1">
        <tr>
            <td width="700" align="center"><b><strong>Pertanyaan</strong></b></td>
            <td width="150" align="center"><b><strong>tidak puas</strong></b></td>
            <td width="150" align="center"><b><strong>kurang puas</strong></b></td>
            <td width="120" align="center"><b><strong>puas</strong></b></td>
            <td width="120" align="center"><b><strong>sangat puas</strong></b></td>
        </tr>
        <?php foreach (($summary ?? []) as $item): ?>
            <tr>
                <td width="700"><?= htmlspecialchars($item['question'], ENT_QUOTES, 'UTF-8') ?></td>
                <td width="150"><?= (int) ($item['counts']['tidak puas'] ?? 0) ?></td>
                <td width="150"><?= (int) ($item['counts']['kurang puas'] ?? 0) ?></td>
                <td width="120"><?= (int) ($item['counts']['puas'] ?? 0) ?></td>
                <td width="120"><?= (int) ($item['counts']['sangat puas'] ?? 0) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br />
    <h2 align="center"><strong>Detail Jawaban &amp; Catatan Feedback</strong></h2><br />
    <table border="1">
        <tr>
            <td width="160" align="center"><b><strong>Tanggal</strong></b></td>
            <?php for ($i = 1; $i <= $qCount; $i++): ?>
                <?php
                $qItem = $qList[$i - 1] ?? "Pertanyaan {$i}";
                $qHeader = is_array($qItem) ? ($qItem['text'] ?? "Pertanyaan {$i}") : (string) $qItem;
                ?>
                <td width="180" align="center"><b><strong><?= htmlspecialchars($qHeader, ENT_QUOTES, 'UTF-8') ?></strong></b></td>
            <?php endfor; ?>
            <td width="400" align="center"><b><strong>Catatan Feedback / Saran</strong></b></td>
        </tr>
        <?php foreach (($suggestions ?? []) as $row): ?>
            <tr>
                <td><?= htmlspecialchars((string) $row['time'], ENT_QUOTES, 'UTF-8') ?></td>
                <?php for ($i = 1; $i <= $qCount; $i++): ?>
                    <td><?= htmlspecialchars((string) ($row["q{$i}"] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                <?php endfor; ?>
                <td><?= htmlspecialchars((string) ($row['suggestion'] ?: '-'), ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
<?php return; endif; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= htmlspecialchars($title ?? 'Dashboard Management Admin - IKM', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="icon" type="image/png" href="<?= $basePath ?>/images/favicon.png">
    <link rel="stylesheet" href="<?= $basePath ?>/css/style2.css" />
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            background-color: #f1f5f9;
            font-family: 'Open Sans', 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }
        .admin-topbar {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            color: #fff;
            padding: 12px 20px;
            box-shadow: 0 2px 12px rgba(15, 23, 42, 0.15);
        }
        .admin-topbar-inner {
            max-width: 1180px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .brand-box {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff !important;
            text-decoration: none !important;
            font-weight: 800;
            font-size: 16px;
        }
        .brand-box img {
            height: 30px;
            width: 30px;
            object-fit: contain;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        .nav-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none !important;
            font-size: 13px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .nav-links a:hover, .nav-links a.active {
            color: #fff;
            background: rgba(255,255,255,0.14);
        }
        .admin-wrap {
            flex: 1;
            max-width: 1180px;
            width: 100%;
            margin: 0 auto;
            padding: 24px 20px 48px;
        }

        /* Compact Thumbnail Grid in Admin */
        .admin-thumb-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 260px));
            gap: 16px;
        }
        .admin-op-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
        }
        .admin-op-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .admin-op-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            flex-shrink: 0;
        }
        .admin-op-title {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            line-height: 1.2;
        }
        .admin-op-sub {
            font-size: 11px;
            color: #64748b;
        }
        .admin-op-stats {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 11.5px;
            margin-bottom: 10px;
        }
        .admin-op-stats div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .admin-op-stats div:last-child { margin-bottom: 0; }
        .admin-op-meta {
            font-size: 11px;
            color: #475569;
            margin-bottom: 12px;
            line-height: 1.45;
        }
        .admin-op-actions {
            margin-top: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }
        .admin-op-actions .btn-sm {
            font-size: 11px;
            padding: 5px 8px;
            font-weight: 700;
        }
        .admin-footer {
            background: #0f172a;
            color: #94a3b8;
            font-size: 12px;
            padding: 14px 20px;
            margin-top: auto;
        }
    </style>
</head>
<body>

<?php
$companyLogo = !empty($settings['company_logo'])
    ? $basePath . '/' . ltrim((string) $settings['company_logo'], '/')
    : $basePath . '/images/logo.png';
?>
<header class="admin-topbar">
    <div class="admin-topbar-inner">
        <a href="<?= $basePath ?>/admin/home" class="brand-box">
            <img src="<?= htmlspecialchars($companyLogo, ENT_QUOTES, 'UTF-8') ?>" alt="Logo" />
            <span>Dashboard Management IKM</span>
        </a>
        <nav class="nav-links">
            <a href="<?= $basePath ?>/admin/home" class="<?= ($activeMenu ?? 'home') === 'home' ? 'active' : '' ?>">Management Operator</a>
            <a href="<?= $basePath ?>/admin/account_add" class="<?= ($activeMenu ?? '') === 'account_add' ? 'active' : '' ?>">+ Tambah Operator</a>
            <a href="<?= $basePath ?>/admin/settings" class="<?= ($activeMenu ?? '') === 'settings' ? 'active' : '' ?>">Pengaturan Logo &amp; Footer</a>
            <a href="<?= $basePath ?>/" target="_blank" style="border: 1px solid rgba(255,255,255,0.25);">Lihat Home &nearr;</a>
            <a href="<?= $basePath ?>/logout" style="background:#dc2626;color:#fff;">Logout</a>
        </nav>
    </div>
</header>

<main class="admin-wrap">

    <?php if (($section ?? 'dashboard') === 'question'): ?>
        <!-- SECTION: ATUR PERTANYAAN DINAMIS (1-10) PER OPERATOR -->
        <?php
        $currentCount = count($questions ?? []);
        if ($currentCount < 1) $currentCount = 1;
        if ($currentCount > 10) $currentCount = 10;

        $existingMap = [];
        foreach (($questions ?? []) as $idx => $qRow) {
            if (is_array($qRow)) {
                $order = (int) ($qRow['q_order'] ?? ($idx + 1));
                $existingMap[$order] = (string) ($qRow['text'] ?? '');
            } else {
                $existingMap[(int) $idx] = (string) $qRow;
            }
        }
        ?>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="font-weight-bold mb-1">Atur Pertanyaan Dinamis (1–10): <?= htmlspecialchars($operator['name'] ?? "Operator {$counter}") ?></h4>
                <p class="text-muted small mb-0">Pilih jumlah pertanyaan (1 s/d 10) sesuai kebutuhan operator, ditambah 1 langkah Catatan Feedback otomatis di akhir.</p>
            </div>
            <a href="<?= $basePath ?>/admin/home" class="btn btn-outline-secondary btn-sm font-weight-bold">&larr; Kembali</a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="<?= $basePath ?>/admin/question_edit?counter=<?= urlencode((string) $counter) ?>" method="POST">
                    <input type="hidden" name="counter" value="<?= htmlspecialchars((string) $counter) ?>" />

                    <div class="form-group row align-items-center bg-light p-3 rounded border mb-3 mx-0">
                        <label for="questionCountSelect" class="col-md-5 col-form-label font-weight-bold mb-2 mb-md-0">
                            Jumlah Pertanyaan Radio Operator Ini:
                        </label>
                        <div class="col-md-4">
                            <select id="questionCountSelect" name="question_count" class="form-control form-control-sm font-weight-bold">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>" <?= $i === $currentCount ? 'selected' : '' ?>>
                                        <?= $i ?> Pertanyaan Radio (+ 1 Feedback Akhir)
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3 text-md-right mt-2 mt-md-0">
                            <span class="badge badge-info px-2 py-1" id="activeCountBadge">Aktif: <?= $currentCount ?> Pertanyaan</span>
                        </div>
                    </div>

                    <div id="questionsContainer">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <?php
                            $val = $existingMap[$i] ?? ($defaultQuestions[$i] ?? "Bagaimana penilaian Anda terhadap aspek pelayanan ke-{$i}?");
                            $isVisible = $i <= $currentCount;
                            ?>
                            <div class="form-group question-item-row p-2 rounded border mb-2"
                                 data-q-index="<?= $i ?>"
                                 style="<?= $isVisible ? '' : 'display: none;' ?> background: #fff;">
                                <label class="small font-weight-bold text-primary mb-1" for="qInput<?= $i ?>">
                                    Pertanyaan Radio #<?= $i ?>
                                </label>
                                <input type="text"
                                       id="qInput<?= $i ?>"
                                       name="questions[<?= $i ?>]"
                                       class="form-control form-control-sm q-input-field"
                                       value="<?= htmlspecialchars($val) ?>"
                                       <?= $isVisible ? 'required' : '' ?> />
                            </div>
                        <?php endfor; ?>
                    </div>

                    <div class="alert alert-info small mt-3 mb-3">
                        <strong>+ Langkah Terakhir Otomatis (Catatan Feedback):</strong> Setelah radio pertanyaan terakhir, halaman survei selalu menampilkan kotak teks <em>Catatan / Feedback untuk Operator</em> yang bersifat opsional (pengunjung dapat menekan <strong>Lewati / Skip</strong> dan seluruh jawaban tetap masuk ke database).
                    </div>

                    <div class="text-right">
                        <a href="<?= $basePath ?>/admin/home" class="btn btn-secondary btn-sm px-3">Batal</a>
                        <button type="submit" class="btn btn-primary btn-sm px-4 font-weight-bold">Simpan Pertanyaan</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            var selectEl = document.getElementById('questionCountSelect');
            var badgeEl = document.getElementById('activeCountBadge');
            var rows = document.querySelectorAll('.question-item-row');
            function updateVisibleQuestions() {
                var count = parseInt(selectEl.value, 10) || 1;
                badgeEl.textContent = 'Aktif: ' + count + ' Pertanyaan';
                rows.forEach(function (row) {
                    var idx = parseInt(row.getAttribute('data-q-index'), 10);
                    var input = row.querySelector('.q-input-field');
                    if (idx <= count) {
                        row.style.display = '';
                        if (input) input.setAttribute('required', 'required');
                    } else {
                        row.style.display = 'none';
                        if (input) input.removeAttribute('required');
                    }
                });
            }
            if (selectEl) {
                selectEl.addEventListener('change', updateVisibleQuestions);
                updateVisibleQuestions();
            }
        });
        </script>

    <?php elseif (($section ?? '') === 'data'): ?>
        <!-- SECTION: REKAP DATA SURVEI & FEEDBACK PER OPERATOR -->
        <?php
        $opName = $operator['name'] ?? "Operator {$counter}";
        $qCount = max(1, count($questions ?? []));
        $exportUrl = $basePath . '/admin/excel/export?counter=' . urlencode((string) $counter);
        if (($awal ?? '') !== '' && ($akhir ?? '') !== '') {
            $exportUrl .= '&awal=' . urlencode($awal) . '&akhir=' . urlencode($akhir);
        }
        ?>
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="font-weight-bold mb-1">Hasil Survei &amp; Feedback: <?= htmlspecialchars($opName) ?></h4>
                <p class="text-muted small mb-0">
                    Unit: <strong><?= htmlspecialchars((string) ($operator['address'] ?? '-')) ?></strong> &bull;
                    Konfigurasi: <strong><?= $qCount ?> Pertanyaan + 1 Feedback</strong>
                </p>
            </div>
            <div class="d-flex" style="gap: 8px;">
                <a href="<?= $exportUrl ?>" class="btn btn-success btn-sm font-weight-bold">Export Excel (.xls)</a>
                <a href="<?= $basePath ?>/admin/home" class="btn btn-outline-secondary btn-sm font-weight-bold">&larr; Kembali</a>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body py-2 px-3">
                <form action="<?= $basePath ?>/admin/data_table?counter=<?= urlencode((string) $counter) ?>" method="post" class="form-inline justify-content-between">
                    <span class="small font-weight-bold">Filter Tanggal:</span>
                    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                        <input type="date" name="awal" class="form-control form-control-sm" required value="<?= htmlspecialchars($awal ?? '') ?>" />
                        <span class="small">s/d</span>
                        <input type="date" name="akhir" class="form-control form-control-sm" required value="<?= htmlspecialchars($akhir ?? '') ?>" />
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                        <a href="<?= $basePath ?>/admin/data_table?counter=<?= urlencode((string) $counter) ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-3">
                <h6 class="font-weight-bold mb-2">Rekapitulasi Jawaban Per Pertanyaan</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center" style="width:40px;">#</th>
                                <th>Pertanyaan</th>
                                <th class="text-center" style="width:100px;">Tidak Puas</th>
                                <th class="text-center" style="width:100px;">Kurang Puas</th>
                                <th class="text-center" style="width:100px;">Puas</th>
                                <th class="text-center" style="width:100px;">Sangat Puas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $idx = 1; foreach (($summary ?? []) as $item): ?>
                                <tr>
                                    <td class="text-center font-weight-bold"><?= $idx++ ?></td>
                                    <td class="small"><?= htmlspecialchars($item['question']) ?></td>
                                    <td class="text-center text-danger font-weight-bold"><?= (int) ($item['counts']['tidak puas'] ?? 0) ?></td>
                                    <td class="text-center text-warning font-weight-bold"><?= (int) ($item['counts']['kurang puas'] ?? 0) ?></td>
                                    <td class="text-center text-primary font-weight-bold"><?= (int) ($item['counts']['puas'] ?? 0) ?></td>
                                    <td class="text-center text-success font-weight-bold"><?= (int) ($item['counts']['sangat puas'] ?? 0) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <h6 class="font-weight-bold mb-2">Detail Responden &amp; Catatan Feedback (<?= count($suggestions ?? []) ?> Suara)</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm mb-0 small">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" style="width:45px;">ID</th>
                                <th style="width:140px;">Waktu</th>
                                <?php for ($i = 1; $i <= $qCount; $i++): ?>
                                    <th class="text-center">Soal <?= $i ?></th>
                                <?php endfor; ?>
                                <th>Catatan Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($suggestions)): ?>
                                <tr><td colspan="<?= $qCount + 3 ?>" class="text-center text-muted py-3">Belum ada data survei.</td></tr>
                            <?php else: ?>
                                <?php foreach ($suggestions as $row): ?>
                                    <?php $fb = trim((string) ($row['suggestion'] ?? '')); ?>
                                    <tr>
                                        <td class="text-center"><?= (int) $row['id_data'] ?></td>
                                        <td><?= htmlspecialchars((string) $row['time']) ?></td>
                                        <?php for ($i = 1; $i <= $qCount; $i++): ?>
                                            <td class="text-center"><?= htmlspecialchars((string) ($row["q{$i}"] ?? '-')) ?></td>
                                        <?php endfor; ?>
                                        <td><?= $fb !== '' ? htmlspecialchars($fb) : '<span class="text-muted font-italic">- (Dilewati)</span>' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php elseif (($section ?? '') === 'account_form'): ?>
        <!-- SECTION: TAMBAH / EDIT PROFIL TARGET OPERATOR (MURNI UNTUK DISURVEI, TANPA LOGIN) -->
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="font-weight-bold mb-0"><?= !empty($isEdit) ? 'Edit Profil Target Operator' : 'Tambah Target Operator Baru' ?></h4>
                        <p class="text-muted small mb-0">Data identitas lengkap operator ini ditampilkan pada Home untuk disurvei oleh pengunjung.</p>
                    </div>
                    <a href="<?= $basePath ?>/admin/home" class="btn btn-outline-secondary btn-sm font-weight-bold">&larr; Kembali</a>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="<?= $basePath ?>/admin/<?= !empty($isEdit) ? 'account_edit' : 'account_add' ?>" method="post" enctype="multipart/form-data">
                            <?php if (!empty($isEdit)): ?>
                                <input type="hidden" name="id" value="<?= htmlspecialchars((string) ($account['id'] ?? '')) ?>" />
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="small font-weight-bold">Nama Lengkap Operator / Petugas Loket</label>
                                <input type="text" name="name" class="form-control form-control-sm" required
                                       placeholder="Contoh: Budi Santoso, S.AP"
                                       value="<?= htmlspecialchars((string) ($account['name'] ?? '')) ?>" />
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold">Unit Kerja / Loket / Alamat</label>
                                <input type="text" name="address" class="form-control form-control-sm" required
                                       placeholder="Contoh: Loket Pelayanan Administrasi Terpadu 1"
                                       value="<?= htmlspecialchars((string) ($account['address'] ?? '')) ?>" />
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="small font-weight-bold">Email</label>
                                    <input type="email" name="email" class="form-control form-control-sm"
                                           placeholder="operator@instansi.go.id"
                                           value="<?= htmlspecialchars((string) ($account['email'] ?? '')) ?>" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small font-weight-bold">No. HP / WhatsApp</label>
                                    <input type="text" name="mobile" class="form-control form-control-sm"
                                           placeholder="0812xxxxxxxx"
                                           value="<?= htmlspecialchars((string) ($account['mobile'] ?? '')) ?>" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="small font-weight-bold">Foto Profil Operator</label>
                                    <?php if (!empty($isEdit) && !empty($account['photo'])): ?>
                                        <div class="mb-2">
                                            <img src="<?= $basePath . '/' . ltrim(htmlspecialchars((string) $account['photo']), '/') ?>"
                                                 alt="Foto" style="width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid #1e3a8a;" />
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" name="photo" accept="image/*" class="form-control-file small" />
                                </div>
                                <?php if (empty($isEdit)): ?>
                                <div class="form-group col-md-6">
                                    <label class="small font-weight-bold">Jumlah Pertanyaan Awal (1–10)</label>
                                    <select name="question_count" class="form-control form-control-sm font-weight-bold">
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= $i ?>" <?= $i === 4 ? 'selected' : '' ?>><?= $i ?> Pertanyaan + 1 Feedback</option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="text-right pt-2 border-top">
                                <a href="<?= $basePath ?>/admin/home" class="btn btn-secondary btn-sm">Batal</a>
                                <button type="submit" class="btn btn-primary btn-sm px-4 font-weight-bold">Simpan Operator</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif (($section ?? '') === 'settings'): ?>
        <!-- SECTION: PENGATURAN LOGO PERUSAHAAN SETEMPAT & TULISAN FOOTER MARQUEE -->
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="font-weight-bold mb-0">Pengaturan Logo Instansi &amp; Teks Footer Marquee</h4>
                        <p class="text-muted small mb-0">Ubah gambar logo perusahaan/instansi setempat serta teks berjalan (marquee) pada footer survei dan halaman utama.</p>
                    </div>
                    <a href="<?= $basePath ?>/admin/home" class="btn btn-outline-secondary btn-sm font-weight-bold">&larr; Kembali</a>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="<?= $basePath ?>/admin/settings" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="small font-weight-bold d-block">Gambar Logo Perusahaan / Instansi Setempat Saat Ini</label>
                                <div class="p-3 bg-dark rounded d-inline-block mb-2">
                                    <img src="<?= htmlspecialchars($companyLogo, ENT_QUOTES, 'UTF-8') ?>"
                                         alt="Logo Perusahaan"
                                         style="max-height: 64px; width: auto; object-fit: contain;" />
                                </div>
                                <input type="file" name="company_logo" accept="image/*" class="form-control-file small mt-1" />
                                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti gambar logo saat ini. (Favicon tetap menggunakan <code>favicon.png</code>).</small>
                            </div>

                            <div class="form-group">
                                <label class="small font-weight-bold">Tulisan Running Text (Marquee) di Footer Survei &amp; Home</label>
                                <textarea name="marquee_text" rows="2" class="form-control form-control-sm" required
                                          placeholder="Contoh: Terima kasih atas partisipasi, penilaian, dan masukan Anda bagi peningkatan pelayanan kami."><?= htmlspecialchars((string) ($settings['marquee_text'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="small font-weight-bold">Nama Instansi / Judul Footer</label>
                                <input type="text" name="footer_text" class="form-control form-control-sm" required
                                       placeholder="Contoh: Portal Survei IKM & Suara Rakyat"
                                       value="<?= htmlspecialchars((string) ($settings['footer_text'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" />
                            </div>

                            <div class="text-right pt-2 border-top">
                                <a href="<?= $basePath ?>/admin/home" class="btn btn-secondary btn-sm">Batal</a>
                                <button type="submit" class="btn btn-primary btn-sm px-4 font-weight-bold">Simpan Pengaturan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- FITUR RESET DATABASE (KEMBALI FRESH SEPERTI BARU) -->
                <div class="card border-danger shadow-sm mt-4" style="border-width: 1px;">
                    <div class="card-body p-4">
                        <h5 class="font-weight-bold text-danger mb-1">Reset / Nolkan Database (Kembali Fresh Seperti Baru)</h5>
                        <p class="text-muted small mb-3">
                            Fitur ini <strong>khusus me-reset database saja</strong> (mengimpor ulang migrasi &amp; seed <code>ikm.sql</code>).
                            Seluruh perolehan suara survei, catatan feedback, daftar operator, pertanyaan, dan pengaturan akan dikembalikan ke kondisi awal bawaan seperti baru diinstal tanpa menghapus file aplikasi.
                        </p>
                        <form action="<?= $basePath ?>/admin/reset_database" method="post"
                              onsubmit="return confirm('PERINGATAN: Anda yakin ingin me-reset/menolkan seluruh isi database kembali fresh seperti baru?');">
                            <button type="submit" class="btn btn-danger btn-sm px-4 font-weight-bold">
                                Reset Database ke Awal Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- DEFAULT SECTION: DASHBOARD MANAGEMENT OPERATOR & PERTANYAAN DINAMIS -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h4 class="font-weight-bold mb-1">Management Operator &amp; Pertanyaan Dinamis</h4>
                <p class="text-muted small mb-0">Kelola tambah/kurang operator, atur 1–10 pertanyaan radio + 1 feedback akhir, serta lihat hasil survei.</p>
            </div>
            <a href="<?= $basePath ?>/admin/account_add" class="btn btn-primary btn-sm font-weight-bold shadow-sm">
                + Tambah Operator Baru
            </a>
        </div>

        <?php if (empty($operators)): ?>
            <div class="alert alert-warning text-center">
                Belum ada Operator. Klik <strong>+ Tambah Operator Baru</strong> untuk menambahkan.
            </div>
        <?php else: ?>
            <div class="admin-thumb-grid">
                <?php foreach ($operators as $op): ?>
                    <?php
                    $photoUrl = !empty($op['photo'])
                        ? $basePath . '/' . ltrim((string) $op['photo'], '/')
                        : $basePath . '/images/default-operator.svg';
                    $starsFilled = (int) ($op['stars_filled'] ?? 0);
                    $starRating  = number_format((float) ($op['star_rating'] ?? 0), 1);
                    $totalSuara  = (int) ($op['total_suara'] ?? 0);
                    $qCount      = (int) ($op['question_count'] ?? 0);
                    ?>
                    <div class="admin-op-card">
                        <div class="admin-op-head">
                            <img src="<?= htmlspecialchars($photoUrl) ?>" alt="<?= htmlspecialchars($op['name']) ?>" class="admin-op-avatar" />
                            <div style="min-width:0;">
                                <h5 class="admin-op-title text-truncate" title="<?= htmlspecialchars($op['name']) ?>"><?= htmlspecialchars($op['name']) ?></h5>
                                <div class="admin-op-sub"><span class="badge badge-<?= htmlspecialchars($op['status_class'] ?? 'secondary') ?>"><?= htmlspecialchars($op['status_label'] ?? 'Belum Dinilai') ?></span></div>
                            </div>
                        </div>

                        <div class="admin-op-stats">
                            <div>
                                <span class="text-muted">Rating:</span>
                                <span class="font-weight-bold text-warning">
                                    <?php for ($s = 1; $s <= 5; $s++): ?><?= $s <= $starsFilled ? '&#9733;' : '&#9734;' ?><?php endfor; ?>
                                    <span class="text-dark">(<?= $starRating ?>)</span>
                                </span>
                            </div>
                            <div>
                                <span class="text-muted">Partisipasi:</span>
                                <strong><?= $totalSuara ?> Responden</strong>
                            </div>
                            <div>
                                <span class="text-muted">Pertanyaan:</span>
                                <strong><?= $qCount ?> Soal + 1 Feedback</strong>
                            </div>
                        </div>

                        <div class="admin-op-meta">
                            <div class="text-truncate" title="<?= htmlspecialchars($op['address'] ?: '-') ?>"><strong>Unit:</strong> <?= htmlspecialchars($op['address'] ?: '-') ?></div>
                            <div class="text-truncate"><strong>Kontak:</strong> <?= htmlspecialchars($op['mobile'] ?: $op['email'] ?: '-') ?></div>
                        </div>

                        <div class="admin-op-actions">
                            <a href="<?= $basePath ?>/admin/question_table?counter=<?= (int) $op['id'] ?>" class="btn btn-info btn-sm">
                                Atur Soal (<?= $qCount ?>)
                            </a>
                            <a href="<?= $basePath ?>/admin/data_table?counter=<?= (int) $op['id'] ?>" class="btn btn-success btn-sm">
                                Data (<?= $totalSuara ?>)
                            </a>
                            <a href="<?= $basePath ?>/admin/account_edit?id=<?= (int) $op['id'] ?>" class="btn btn-outline-secondary btn-sm">
                                Edit Profil
                            </a>
                            <a href="<?= $basePath ?>/admin/account_delete?id=<?= (int) $op['id'] ?>"
                               onclick="return confirm('Hapus operator <?= htmlspecialchars(addslashes($op['name'])) ?>?');"
                               class="btn btn-outline-danger btn-sm">
                                Hapus
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</main>

<footer class="admin-footer">
    <div style="max-width:1180px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
        <span>&copy; <?= date('Y') ?> <?= htmlspecialchars((string) ($settings['footer_text'] ?? 'Panel Management Admin Survei IKM'), ENT_QUOTES, 'UTF-8') ?></span>
        <a href="<?= $basePath ?>/" class="text-light">Ke Halaman Utama &rarr;</a>
    </div>
</footer>

<script src="<?= $basePath ?>/js/jquery.min.js"></script>
<script src="<?= $basePath ?>/js/popper.min.js"></script>
<script src="<?= $basePath ?>/js/bootstrap.min.js"></script>
</body>
</html>
