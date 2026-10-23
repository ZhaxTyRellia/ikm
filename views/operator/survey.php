<!DOCTYPE html>
<html id="fullscreen">

<head>
  <meta charset="utf-8">
  <title>Survey Kepuasan - <?= htmlspecialchars((string) ($operator['name'] ?? "Operator {$counter}"), ENT_QUOTES, 'UTF-8') ?></title>
  <link href="<?= $basePath ?>/css/style.css" type="text/css" rel="stylesheet" />
  <link rel="icon" type="image/gif" href="<?= $basePath ?>/images/favicon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
  <link rel="stylesheet" href="<?= $basePath ?>/css/animate.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/survey.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/keyboard.css">
</head>

<body>
  <?php
  $opName = $operator['name'] ?? "Operator {$counter}";
  $photoUrl = !empty($operator['photo'])
      ? $basePath . '/' . ltrim((string) $operator['photo'], '/')
      : $basePath . '/images/logo.png';
  ?>
  <div id="header" style="justify-content:space-between;padding:8px 20px;">
    <div style="display:flex;align-items:center;">
      <button onclick="openFullscreen();" style="background-color:transparent;border-style:none">
        <img class="images" src="<?= htmlspecialchars($photoUrl, ENT_QUOTES, 'UTF-8') ?>"
             alt="<?= htmlspecialchars($opName, ENT_QUOTES, 'UTF-8') ?>"
             style="width:85px;height:85px;border-radius:50%;object-fit:cover;border:3px solid #2c01a3;padding:0;">
      </button>
      <div class="tittle-header">
        <a class="title"><?= htmlspecialchars($opName, ENT_QUOTES, 'UTF-8') ?></a>
        <a class="title" style="font-size:16px;font-weight:500;">
          <?= htmlspecialchars((string) ($operator['address'] ?? 'CV. BINTANG SEMBILAN - SURABAYA'), ENT_QUOTES, 'UTF-8') ?>
        </a>
        <?php if (!empty($operator['mobile']) || !empty($operator['email'])): ?>
          <a class="title" style="font-size:14px;font-weight:400;">
            <?= htmlspecialchars(trim(($operator['email'] ?? '') . ' ' . ($operator['mobile'] ? '| ' . $operator['mobile'] : '')), ENT_QUOTES, 'UTF-8') ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
    <a href="<?= $basePath ?>/" style="background:#2c01a3;color:#fff;padding:8px 16px;border-radius:6px;text-decoration:none;font-weight:600;font-family:sans-serif;">
      &larr; Kembali ke Home
    </a>
  </div>

  <div id="content">
    <section>
      <div class="title-fieldset">SURVEY KEPUASAN MASYARAKAT (SUARA RAKYAT)</div>
      <form action="<?= $basePath ?>/survey?id=<?= urlencode($counter) ?>" method="post">
        <input type="hidden" name="counter" value="<?= htmlspecialchars($counter, ENT_QUOTES, 'UTF-8') ?>">
        <div class="container">
          <?php foreach ($questions as $num => $text): ?>
            <div class="form-step <?= (int) $num === 1 ? 'form-step-active' : '' ?>">
              <h2><?= htmlspecialchars($text, ENT_QUOTES, 'UTF-8') ?></h2>
              <fieldset id="group<?= (int) $num ?>">
                <?php foreach ($ratingOptions as $ratingValue => $emoticonFile): ?>
                  <label>
                    <input type="radio" name="q<?= (int) $num ?>" value="<?= htmlspecialchars($ratingValue, ENT_QUOTES, 'UTF-8') ?>"
                      required="required" class="btn btn-next width-50 ml-auto">
                    <img src="<?= $basePath ?>/images/Emot4/<?= htmlspecialchars($emoticonFile, ENT_QUOTES, 'UTF-8') ?>"
                      width="160px" height="160px" alt="<?= htmlspecialchars($ratingValue, ENT_QUOTES, 'UTF-8') ?>">
                  </label>
                <?php endforeach; ?>
              </fieldset>
            </div>
          <?php endforeach; ?>

          <div class="form-step">
            <h2>Kritik dan saran untuk <?= htmlspecialchars($opName, ENT_QUOTES, 'UTF-8') ?></h2>
            <input type="text" name="suggestion" class="form-control" placeholder="Tulis pesan anda disini"
              aria-label="Kritik dan saran">
            <br><br>
            <center>
              <input type="submit" name="submit" value="Submit" onclick="play()">
              <audio id="audio" src="<?= $basePath ?>/audio/thankyou.mp3"></audio>
            </center>
          </div>
        </div>
      </form>
    </section>
  </div>

  <div id="footer">
    <marquee>
      <span>Terima kasih atas saran dan masukan anda, bagi kami.</span>
    </marquee>
  </div>

  <script>
    var audio = document.getElementById('audio');
    function play() {
      if (audio) audio.play();
    }
    setTimeout(play, 1000);
  </script>

  <script src="<?= $basePath ?>/js/script.multiform.js"></script>
  <script src="<?= $basePath ?>/js/fullscreen.js"></script>
  <script src="<?= $basePath ?>/js/onscreen-keyboard.js"></script>
</body>

</html>
