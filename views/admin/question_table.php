<?php
$currentCount = count($questions ?? []);
if ($currentCount < 1) {
    $currentCount = 1;
}
if ($currentCount > 10) {
    $currentCount = 10;
}

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
<div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                Atur Pertanyaan Dinamis (1–10): <?= htmlspecialchars($operator['name'] ?? "Operator {$counter}") ?>
            </h3>
            <p class="text-muted mb-0">
                Pilih jumlah pertanyaan radio (1 sampai 10) sesuai kebutuhan operator ini. Setelah pertanyaan radio terakhir, sistem otomatis menampilkan <strong>1 kotak Catatan Feedback</strong> (boleh di-skip pengunjung).
            </p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="<?= $basePath ?>/admin/home" class="btn btn-outline-secondary font-weight-bold">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
        <div class="card-body p-4">
            <form action="<?= $basePath ?>/admin/question_edit?counter=<?= urlencode((string) $counter) ?>" method="POST">
                <input type="hidden" name="counter" value="<?= htmlspecialchars((string) $counter) ?>" />

                <!-- Pilih Jumlah Pertanyaan (1 - 10) -->
                <div class="form-group row align-items-center bg-light p-3 rounded border mb-4 mx-0">
                    <label for="questionCountSelect" class="col-md-5 col-form-label font-weight-bold text-dark mb-2 mb-md-0">
                        Jumlah Pertanyaan Radio untuk Operator Ini:
                    </label>
                    <div class="col-md-4">
                        <select id="questionCountSelect" name="question_count" class="form-control font-weight-bold">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>" <?= $i === $currentCount ? 'selected' : '' ?>>
                                    <?= $i ?> Pertanyaan Radio (+ 1 Feedback Akhir)
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3 text-md-right mt-2 mt-md-0">
                        <span class="badge badge-info px-3 py-2" id="activeCountBadge">
                            Aktif: <?= $currentCount ?> Pertanyaan
                        </span>
                    </div>
                </div>

                <!-- Daftar Input Pertanyaan 1 s/d 10 -->
                <div id="questionsContainer">
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <?php
                        $val = $existingMap[$i] ?? ($defaultQuestions[$i] ?? "Bagaimana penilaian Anda terhadap aspek pelayanan ke-{$i}?");
                        $isVisible = $i <= $currentCount;
                        ?>
                        <div class="form-group question-item-row p-3 rounded border mb-3"
                             data-q-index="<?= $i ?>"
                             style="<?= $isVisible ? '' : 'display: none;' ?> background: #ffffff;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="font-weight-bold text-primary mb-0" for="qInput<?= $i ?>">
                                    Pertanyaan Radio #<?= $i ?>
                                </label>
                                <span class="badge badge-light border">Langkah Ke-<?= $i ?></span>
                            </div>
                            <input type="text"
                                   id="qInput<?= $i ?>"
                                   name="questions[<?= $i ?>]"
                                   class="form-control q-input-field"
                                   value="<?= htmlspecialchars($val) ?>"
                                   placeholder="Tulis teks pernyataan/pertanyaan ke-<?= $i ?>..."
                                   <?= $isVisible ? 'required' : '' ?> />
                        </div>
                    <?php endfor; ?>
                </div>

                <!-- Informasi Step Terakhir: Catatan Feedback -->
                <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mt-4 mb-4" style="border-left: 4px solid #0284c7 !important;">
                    <div>
                        <h6 class="font-weight-bold mb-1">+ Langkah Terakhir Otomatis: Tulis Catatan Feedback kepada Operator</h6>
                        <p class="small mb-0">
                            Setelah pengunjung menjawab pertanyaan radio terakhir di atas, halaman survei selalu menampilkan kotak teks <strong>Catatan / Feedback untuk Operator</strong>. Bagian feedback ini wajib hadir di akhir survei namun <em>tidak bersifat required</em> (pengunjung yang malas mengetik dapat langsung menekan tombol <strong>Lewati / Kirim Survei</strong> dan seluruh jawaban tetap tersimpan ke database).
                        </p>
                    </div>
                </div>

                <div class="d-flex justify-content-end" style="gap: 10px;">
                    <a href="<?= $basePath ?>/admin/home" class="btn btn-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                        Simpan Konfigurasi Pertanyaan
                    </button>
                </div>
            </form>
        </div>
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
