<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Data Survey Operator <?= htmlspecialchars($counter, ENT_QUOTES, 'UTF-8') ?></title>
</head>

<body>
  <h2 align="center"><strong>Data Survey Operator <?= htmlspecialchars($counter, ENT_QUOTES, 'UTF-8') ?></strong></h2><br />

  <table border="1">
    <tr>
      <td width="700" align="center"><b><strong>Pertanyaan</strong></b></td>
      <td width="200" align="center"><b><strong>tidak puas</strong></b></td>
      <td width="200" align="center"><b><strong>kurang puas</strong></b></td>
      <td width="100" align="center"><b><strong>puas</strong></b></td>
      <td width="100" align="center"><b><strong>sangat puas</strong></b></td>
    </tr>
    <?php foreach ($summary as $item): ?>
      <tr>
        <td width="700"><?= htmlspecialchars($item['question'], ENT_QUOTES, 'UTF-8') ?></td>
        <td width="100"><?= (int) ($item['counts']['tidak puas'] ?? 0) ?></td>
        <td width="100"><?= (int) ($item['counts']['kurang puas'] ?? 0) ?></td>
        <td width="100"><?= (int) ($item['counts']['puas'] ?? 0) ?></td>
        <td width="100"><?= (int) ($item['counts']['sangat puas'] ?? 0) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
  <br />

  <h2 align="center"><strong>Kritik &amp; Saran</strong></h2><br />
  <table width="830" border="1">
    <tr>
      <td width="500" align="center"><b><strong>Kritik &amp; Saran</strong></b></td>
      <td width="100" align="center"><b><strong>tanggal</strong></b></td>
      <?php for ($i = 1; $i <= 9; $i++): ?>
        <td width="100" align="center"><b><strong><?= htmlspecialchars($questions[$i] ?? '', ENT_QUOTES, 'UTF-8') ?></strong></b></td>
      <?php endfor; ?>
    </tr>
    <?php foreach ($suggestions as $row): ?>
      <tr>
        <td width="500"><?= htmlspecialchars((string) $row['suggestion'], ENT_QUOTES, 'UTF-8') ?></td>
        <td width="100"><?= htmlspecialchars((string) $row['time'], ENT_QUOTES, 'UTF-8') ?></td>
        <?php for ($i = 1; $i <= 9; $i++): ?>
          <td width="100"><?= htmlspecialchars((string) ($row["q{$i}"] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
        <?php endfor; ?>
      </tr>
    <?php endforeach; ?>
  </table>

</body>

</html>
