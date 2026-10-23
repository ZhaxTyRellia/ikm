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
      font-family: 'Open Sans', sans-serif;
      font-size: 12.5px;
      font-weight: 700;
      padding: 5px 16px;
      border-radius: 50px;
      margin-bottom: 12px;
      letter-spacing: 0.4px;
    }
    .feedback-actions {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 14px;
      margin-top: 20px;
    }
    .btn-submit-survey {
      background: linear-gradient(135deg, #1e3a8a, #0f766e);
      color: #ffffff;
      border: none;
      padding: 12px 26px;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(15, 118, 110, 0.25);
    }
    .btn-skip-feedback {
      background: #64748b;
      color: #ffffff;
      border: none;
      padding: 12px 22px;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
    }
    .btn-submit-survey:hover, .btn-skip-feedback:hover {
      opacity: 0.92;
    }
    .btn-back-home {
      background: rgba(255, 255, 255, 0.14);
      border: 1px solid rgba(255, 255, 255, 0.28);
      color: #ffffff;
      padding: 8px 18px;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      font-size: 13.5px;
      transition: background 0.2s ease;
    }
    .btn-back-home:hover {
      background: rgba(255, 255, 255, 0.24);
    }
  </style>
</head>

<body>
  <!-- Elemen Animasi Background Formal -->
  <div class="survey-bg-elements" aria-hidden="true">
    <div class="geo-shape geo-1"></div>
    <div class="geo-shape geo-2"></div>
    <div class="geo-shape geo-3"></div>
    <div class="geo-shape geo-4"></div>
    <div class="geo-shape geo-5"></div>
  </div>

  <div id="header">
    <div style="display:flex;align-items:center;">
      <button onclick="openFullscreen();" style="background-color:transparent;border-style:none;cursor:pointer;padding:0;" title="Layar Penuh">
        <img class="images" src="<?= htmlspecialchars($photoUrl, ENT_QUOTES, 'UTF-8') ?>"
             alt="<?= htmlspecialchars($opName, ENT_QUOTES, 'UTF-8') ?>"
             style="width:68px;height:68px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,255,255,0.65);padding:0;background:#fff;">
      </button>
      <div class="tittle-header">
        <a class="title"><?= htmlspecialchars($opName, ENT_QUOTES, 'UTF-8') ?></a>
        <a class="title" style="font-size:14px;font-weight:500;color:#cbd5e1;">
          <?= htmlspecialchars((string) ($operator['address'] ?? 'Unit Pelayanan Masyarakat'), ENT_QUOTES, 'UTF-8') ?>
        </a>
        <?php if (!empty($operator['mobile']) || !empty($operator['email'])): ?>
          <a class="title" style="font-size:12.5px;font-weight:400;color:#94a3b8;">
            <?= htmlspecialchars(trim(($operator['email'] ?? '') . ' ' . ($operator['mobile'] ? '| ' . $operator['mobile'] : '')), ENT_QUOTES, 'UTF-8') ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
    <a href="<?= $basePath ?>/" class="btn-back-home">
      &larr; Kembali ke Home
    </a>
  </div>

  <div id="content">
    <section class="survey-card-shell">
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
                  <label class="emote-option-card">
                    <input type="radio" name="q<?= $stepIndex ?>" value="<?= htmlspecialchars($ratingValue, ENT_QUOTES, 'UTF-8') ?>"
                      required="required" class="btn btn-next width-50 ml-auto">
                    <img src="<?= $basePath ?>/images/emote/<?= htmlspecialchars($emoticonFile, ENT_QUOTES, 'UTF-8') ?>"
                      width="135px" height="135px" alt="<?= htmlspecialchars($ratingValue, ENT_QUOTES, 'UTF-8') ?>">
                    <span class="emote-label-text"><?= htmlspecialchars($ratingValue, ENT_QUOTES, 'UTF-8') ?></span>
                  </label>
                <?php endforeach; ?>
              </fieldset>
            </div>
            <?php $stepIndex++; ?>
          <?php endforeach; ?>

          <!-- Langkah Terakhir: Tulis Catatan / Feedback untuk Operator (Wajib tampil di akhir radio, tapi tidak required / boleh di-skip) -->
          <div class="form-step">
            <div style="text-align:center;">
              <span class="step-badge" style="background:#0f766e;">Langkah Terakhir: Catatan Feedback (Opsional)</span>
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
