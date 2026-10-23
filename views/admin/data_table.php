<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

  <section class="ftco-section ftco-section-2">
    <div class="container">
      <div class="row">
      </div>
    </div>
  </section>

  <div class="row justify-content-center mb-5 pb-5">
    <div class="col-md-7 text-center heading-section ftco-animate">
      <h2 class="tittle" align="center"><strong>Data Survey Operator <?= htmlspecialchars($counter, ENT_QUOTES, 'UTF-8') ?></strong></h2><br />

      <form action="<?= $basePath ?>/admin/data_table?counter=<?= urlencode($counter) ?>" method="post">
        <p align="center">
          <font color="black" size="3"><b>Tampilkan Data Berdasarkan Periode Tanggal</b></font>
        </p>

        <table border="0" align="center">
          <tr>
            <td width="200">Date : <input type="date" name="awal" size="16" required value="<?= htmlspecialchars($awal, ENT_QUOTES, 'UTF-8') ?>" /></td>
            <td>to : <input type="date" name="akhir" size="16" required value="<?= htmlspecialchars($akhir, ENT_QUOTES, 'UTF-8') ?>" /></td>
            <td width="125"><input type="submit" value="Cari" name="pencarian" /></td>
            <td width="125"><input type="reset" value="Reset" onclick="window.location.href='<?= $basePath ?>/admin/data_table?counter=<?= urlencode($counter) ?>'" /></td>
            <td>
              <?php
              $exportUrl = $basePath . '/admin/excel/export?counter=' . urlencode($counter);
              if ($awal !== '' && $akhir !== '') {
                  $exportUrl .= '&awal=' . urlencode($awal) . '&akhir=' . urlencode($akhir);
              }
              ?>
              <a href="<?= $exportUrl ?>" class="export">Export</a>
            </td>
          </tr>
        </table>
      </form>
      <br />

      <table border="1" style="background-color:yellow;">
        <thead>
          <tr>
            <td width="700" align="center"><b><strong>Pertanyaan</strong></b></td>
            <td width="100" align="center"><b><strong>tidak puas</strong></b></td>
            <td width="100" align="center"><b><strong>kurang puas</strong></b></td>
            <td width="100" align="center"><b><strong>puas</strong></b></td>
            <td width="100" align="center"><b><strong>sangat puas</strong></b></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($summary as $item): ?>
            <tr>
              <td width="700"><?= htmlspecialchars($item['question'], ENT_QUOTES, 'UTF-8') ?></td>
              <td width="100"><?= (int) ($item['counts']['tidak puas'] ?? 0) ?></td>
              <td width="100"><?= (int) ($item['counts']['kurang puas'] ?? 0) ?></td>
              <td width="100"><?= (int) ($item['counts']['puas'] ?? 0) ?></td>
              <td width="100"><?= (int) ($item['counts']['sangat puas'] ?? 0) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <br />

      <h2 class="tittle" align="center"><strong>Kritik &amp; Saran</strong></h2><br />
      <table border="1" style="background-color:yellow;">
        <thead>
          <tr>
            <td width="30" align="center"><b><strong>no</strong></b></td>
            <td width="170" align="center"><b><strong>date</strong></b></td>
            <?php for ($i = 1; $i <= 9; $i++): ?>
              <td width="100" align="center"><b><strong>ask <?= $i ?></strong></b></td>
            <?php endfor; ?>
            <td width="700" align="center"><b><strong>Kritik &amp; Saran</strong></b></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($suggestions as $row): ?>
            <tr>
              <td width="30"><?= htmlspecialchars((string) $row['id_data'], ENT_QUOTES, 'UTF-8') ?></td>
              <td width="170"><?= htmlspecialchars((string) $row['time'], ENT_QUOTES, 'UTF-8') ?></td>
              <?php for ($i = 1; $i <= 9; $i++): ?>
                <td width="100"><?= htmlspecialchars((string) ($row["q{$i}"] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
              <?php endfor; ?>
              <td width="700"><?= htmlspecialchars((string) $row['suggestion'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
