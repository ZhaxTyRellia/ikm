<?php
$opName = $operator['name'] ?? "Operator {$counter}";
$photoUrl = !empty($operator['photo'])
    ? $basePath . '/' . ltrim((string) $operator['photo'], '/')
    : $basePath . '/images/user.png';
$qCount = max(1, count($questions ?? []));

$exportUrl = $basePath . '/admin/excel/export?counter=' . urlencode((string) $counter);
if ($awal !== '' && $akhir !== '') {
    $exportUrl .= '&awal=' . urlencode($awal) . '&akhir=' . urlencode($akhir);
}
?>
<div class="container">
    <!-- Header Info Operator -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="d-flex align-items-center">
            <img src="<?= htmlspecialchars($photoUrl, ENT_QUOTES, 'UTF-8') ?>"
                 alt="<?= htmlspecialchars($opName, ENT_QUOTES, 'UTF-8') ?>"
                 class="rounded-circle border mr-3"
                 style="width: 64px; height: 64px; object-fit: cover;" />
            <div>
                <h3 class="font-weight-bold text-dark mb-1">
                    Rekap Data Survei: <?= htmlspecialchars($opName, ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <?php if (!empty($operator)): ?>
                    <div class="small text-muted">
                        Kode: <strong>@<?= htmlspecialchars((string) $operator['username'], ENT_QUOTES, 'UTF-8') ?></strong> &bull;
                        Unit/Alamat: <strong><?= htmlspecialchars((string) ($operator['address'] ?: '-'), ENT_QUOTES, 'UTF-8') ?></strong> &bull;
                        Jumlah Soal Aktif: <strong><?= $qCount ?> Pertanyaan + 1 Feedback</strong>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="mt-3 mt-md-0 d-flex" style="gap: 8px;">
            <a href="<?= $exportUrl ?>" class="btn btn-success font-weight-bold">
                &#128196; Export Excel (.xls)
            </a>
            <a href="<?= $basePath ?>/admin/home" class="btn btn-outline-secondary font-weight-bold">
                &larr; Kembali
            </a>
        </div>
    </div>

    <!-- Filter Tanggal -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
        <div class="card-body py-3">
            <form action="<?= $basePath ?>/admin/data_table?counter=<?= urlencode((string) $counter) ?>" method="post" class="form-inline justify-content-between">
                <div class="font-weight-bold text-dark mb-2 mb-md-0">
                    Filter Periode Tanggal Survei:
                </div>
                <div class="d-flex flex-wrap align-items-center" style="gap: 10px;">
                    <input type="date" name="awal" class="form-control form-control-sm" required value="<?= htmlspecialchars($awal, ENT_QUOTES, 'UTF-8') ?>" />
                    <span>s/d</span>
                    <input type="date" name="akhir" class="form-control form-control-sm" required value="<?= htmlspecialchars($akhir, ENT_QUOTES, 'UTF-8') ?>" />
                    <button type="submit" name="pencarian" value="Cari" class="btn btn-primary btn-sm px-3 font-weight-bold">Terapkan</button>
                    <a href="<?= $basePath ?>/admin/data_table?counter=<?= urlencode((string) $counter) ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Rekapitulasi Jawaban Per Pertanyaan -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
            <h5 class="font-weight-bold text-dark mb-0">Rekapitulasi Pilihan Jawaban (<?= count($summary ?? []) ?> Pertanyaan)</h5>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 50px;" class="text-center">#</th>
                            <th>Pernyataan / Pertanyaan</th>
                            <th class="text-center" style="width: 120px;">Tidak Puas</th>
                            <th class="text-center" style="width: 120px;">Kurang Puas</th>
                            <th class="text-center" style="width: 120px;">Puas</th>
                            <th class="text-center" style="width: 120px;">Sangat Puas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($summary ?? []) as $idx => $item): ?>
                            <tr>
                                <td class="text-center font-weight-bold"><?= $idx + 1 ?></td>
                                <td><?= htmlspecialchars($item['question'], ENT_QUOTES, 'UTF-8') ?></td>
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

    <!-- Tabel Detail Jawaban Responden & Catatan Feedback -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
            <h5 class="font-weight-bold text-dark mb-0">Daftar Jawaban Responden &amp; Catatan Feedback (<?= count($suggestions ?? []) ?> Responden)</h5>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" style="width: 50px;">ID</th>
                            <th style="width: 155px;">Waktu</th>
                            <?php for ($i = 1; $i <= $qCount; $i++): ?>
                                <th class="text-center">Soal <?= $i ?></th>
                            <?php endfor; ?>
                            <th>Catatan Feedback / Saran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($suggestions)): ?>
                            <tr>
                                <td colspan="<?= $qCount + 3 ?>" class="text-center text-muted py-4">
                                    Belum ada data responden untuk periode ini.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($suggestions as $row): ?>
                                <?php $feedbackText = trim((string) ($row['suggestion'] ?? '')); ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars((string) $row['id_data'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars((string) $row['time'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <?php for ($i = 1; $i <= $qCount; $i++): ?>
                                        <td class="text-center"><?= htmlspecialchars((string) ($row["q{$i}"] ?? '-'), ENT_QUOTES, 'UTF-8') ?></td>
                                    <?php endfor; ?>
                                    <td>
                                        <?php if ($feedbackText !== ''): ?>
                                            <?= htmlspecialchars($feedbackText, ENT_QUOTES, 'UTF-8') ?>
                                        <?php else: ?>
                                            <span class="text-muted font-italic">- (Dilewati / Tanpa Catatan)</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
