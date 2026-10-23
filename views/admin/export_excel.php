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
            Username: @<?= htmlspecialchars((string) $operator['username'], ENT_QUOTES, 'UTF-8') ?> |
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
                <td width="180" align="center">
                    <b><strong><?= htmlspecialchars($qHeader, ENT_QUOTES, 'UTF-8') ?></strong></b>
                </td>
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
