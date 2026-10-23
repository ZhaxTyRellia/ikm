<!DOCTYPE html>
<html lang="id" id="fullscreen">

<head>
  <meta charset="utf-8">
  <?php
  $opName = $operator['name'] ?? "Operator {$counter}";
  $photoUrl = !empty($operator['photo'])
      ? $basePath . '/' . ltrim((string) $operator['photo'], '/')
      : $basePath . '/images/default-operator.svg';
  $totalQuestions = count($questions ?? []);
  $marqueeText = $settings['marquee_text'] ?? 'Terima kasih atas partisipasi, penilaian, dan masukan Anda bagi peningkatan pelayanan kami.';
  ?>
  <title>Survei Kepuasan - <?= htmlspecialchars((string) $opName, ENT_QUOTES, 'UTF-8') ?></title>
  <link href="<?= $basePath ?>/css/style.css" type="text/css" rel="stylesheet" />
  <link rel="icon" type="image/png" href="<?= $basePath ?>/images/favicon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
  <link rel="stylesheet" href="<?= $basePath ?>/css/animate.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/survey.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/keyboard.css">
  <style>
    .step-badge {
      display: inline-block;
      background: #1e3a8a;
      color: #ffffff;
      font-family: sans-serif;
      font-size: 13px;
      font-weight: 700;
      padding: 5px 14px;
      border-radius: 50px;
      margin-bottom: 10px;
    }
    .feedback-actions {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 14px;
      margin-top: 18px;
    }
    .btn-submit-survey {
      background: #1e3a8a;
      color: #ffffff;
      border: none;
      padding: 11px 24px;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 700;
      cursor: pointer;
    }
    .btn-skip-feedback {
      background: #64748b;
      color: #ffffff;
      border: none;
      padding: 11px 20px;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
    }
    .btn-submit-survey:hover, .btn-skip-feedback:hover {
      opacity: 0.92;
    }
  </style>
</head>

<body>
  <div id="header" style="justify-content:space-between;padding:8px 20px;">
    <div style="display:flex;align-items:center;">
      <button onclick="openFullscreen();" style="background-color:transparent;border-style:none">
        <img class="images" src="<?= htmlspecialchars($photoUrl, ENT_QUOTES, 'UTF-8') ?>"
             alt="<?= htmlspecialchars($opName, ENT_QUOTES, 'UTF-8') ?>"
             style="width:76px;height:76px;border-radius:50%;object-fit:cover;border:3px solid #2c01a3;padding:0;">
      </button>
      <div class="tittle-header">
        <a class="title"><?= htmlspecialchars($opName, ENT_QUOTES, 'UTF-8') ?></a>
        <a class="title" style="font-size:15px;font-weight:500;">
          <?= htmlspecialchars((string) ($operator['address'] ?? 'Unit Pelayanan Masyarakat'), ENT_QUOTES, 'UTF-8') ?>
        </a>
        <?php if (!empty($operator['mobile']) || !empty($operator['email'])): ?>
          <a class="title" style="font-size:13px;font-weight:400;">
            <?= htmlspecialchars(trim(($operator['email'] ?? '') . ' ' . ($operator['mobile'] ? '| ' . $operator['mobile'] : '')), ENT_QUOTES, 'UTF-8') ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
    <a href="<?= $basePath ?>/" style="background:#2c01a3;color:#fff;padding:8px 16px;border-radius:6px;text-decoration:none;font-weight:600;font-family:sans-serif;font-size:14px;">
      &larr; Kembali ke Home
    </a>
  </div>

  <div id="content">
    <section>
      <div class="title-fieldset">SURVEI KEPUASAN MASYARAKAT (SUARA RAKYAT)</div>
      <form id="surveyForm" action="<?= $basePath ?>/survey?id=<?= urlencode((string) $counter) ?>" method="post">
        <input type="hidden" name="counter" value="<?= htmlspecialchars((string) $counter, ENT_QUOTES, 'UTF-8') ?>">
        <div class="container">
          <?php $stepIndex = 1; ?>
          <?php foreach (($questions ?? []) as $num => $text): ?>
            <?php $qText = is_array($text) ? ($text['text'] ?? '') : (string) $text; ?>
            <div class="form-step <?= $stepIndex === 1 ? 'form-step-active' : '' ?>">
              <div style="text-align:center;">
                <span class="step-badge">Pertanyaan <?= $stepIndex ?> dari <?= $totalQuestions ?></span>
              </div>
              <h2><?= htmlspecialchars($qText, ENT_QUOTES, 'UTF-8') ?></h2>
              <fieldset id="group<?= $stepIndex ?>">
                <?php foreach ($ratingOptions as $ratingValue => $emoticonFile): ?>
                  <label>
                    <input type="radio" name="q<?= $stepIndex ?>" value="<?= htmlspecialchars($ratingValue, ENT_QUOTES, 'UTF-8') ?>"
                      required="required" class="btn btn-next width-50 ml-auto">
                    <img src="<?= $basePath ?>/images/emote/<?= htmlspecialchars($emoticonFile, ENT_QUOTES, 'UTF-8') ?>"
                      width="150px" height="150px" alt="<?= htmlspecialchars($ratingValue, ENT_QUOTES, 'UTF-8') ?>">
                  </label>
                <?php endforeach; ?>
              </fieldset>
            </div>
            <?php $stepIndex++; ?>
          <?php endforeach; ?>

          <!-- Langkah Terakhir: Tulis Catatan / Feedback untuk Operator (Wajib tampil di akhir radio, tapi tidak required / boleh di-skip) -->
          <div class="form-step">
            <div style="text-align:center;">
              <span class="step-badge" style="background:#0d9488;">Langkah Terakhir: Catatan Feedback (Opsional)</span>
            </div>
            <h2>Tulis Catatan / Feedback untuk <?= htmlspecialchars($opName, ENT_QUOTES, 'UTF-8') ?></h2>
            <p style="text-align:center;font-family:sans-serif;color:#475569;margin-top:-8px;margin-bottom:14px;font-size:14px;">
              Berikan kritik, saran, atau apresiasi untuk operator ini (boleh dilewati / langsung kirim jika tidak ingin mengetik).
            </p>
            <input type="text" id="suggestionInput" name="suggestion" class="form-control"
              placeholder="Tulis catatan feedback Anda di sini (opsional / boleh dikosongkan)..."
              aria-label="Catatan dan feedback">
            <div class="feedback-actions">
              <button type="submit" name="submit" value="Submit" class="btn-submit-survey" onclick="play()">
                Kirim Survei &amp; Feedback
              </button>
              <button type="submit" name="skip_feedback" value="1" class="btn-skip-feedback" onclick="skipAndSubmit()">
                Lewati Catatan (Skip) &amp; Kirim
              </button>
              <audio id="audio" src="<?= $basePath ?>/audio/thankyou.mp3"></audio>
            </div>
          </div>
        </div>
      </form>
    </section>
  </div>

  <div id="footer">
    <marquee>
      <span><?= htmlspecialchars((string) $marqueeText, ENT_QUOTES, 'UTF-8') ?></span>
    </marquee>
  </div>

  <script>
    var audio = document.getElementById('audio');
    function play() {
      if (audio) audio.play();
    }
    function skipAndSubmit() {
      var input = document.getElementById('suggestionInput');
      if (input) input.value = '';
      play();
    }
    setTimeout(play, 1000);
  </script>

  <script src="<?= $basePath ?>/js/script.multiform.js"></script>
  <script src="<?= $basePath ?>/js/fullscreen.js"></script>
  <script src="<?= $basePath ?>/js/onscreen-keyboard.js"></script>
</body>

</html>
