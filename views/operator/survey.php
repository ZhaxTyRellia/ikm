<!DOCTYPE html>
<html id="fullscreen">

<head>
  <meta charset="utf-8">
  <title>Survey Kepuasan</title>
  <link href="<?= $basePath ?>/css/style.css" type="text/css" rel="stylesheet" />
  <link rel="icon" type="image/gif" href="<?= $basePath ?>/images/favicon.png" />

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

  <link rel="stylesheet" href="<?= $basePath ?>/css/animate.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/survey.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/keyboard.css">
</head>

<body>
  <div id="header">
    <button onclick="openFullscreen();" style="background-color:transparent;border-style:none">
      <img class="images" src="<?= $basePath ?>/images/logo.png" alt="Logo">
    </button>
    <div class="tittle-header">
      <a class="title">CV. BINTANG SEMBILAN</a>
      <a class="title">Perum Gunungsari Indah 36</a>
      <a class="title">SURABAYA</a>
    </div>
  </div>

  <div id="content">
    <section>
      <div class="title-fieldset">SURVEY KEPUASAN MASYARAKAT</div>
      <form action="<?= $basePath ?>/operator/survey?id=<?= urlencode($counter) ?>" method="post">
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
            <h2>Kritik dan saran</h2>
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
      if (audio) {
        audio.play();
      }
    }
    setTimeout(function () {
      if (audio) {
        audio.play();
      }
    }, 1000);
  </script>

  <script src="<?= $basePath ?>/js/script.multiform.js"></script>
  <script src="<?= $basePath ?>/js/jquery.min.js"></script>
  <script src="<?= $basePath ?>/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="<?= $basePath ?>/js/jquery.waypoints.min.js"></script>
  <script src="<?= $basePath ?>/js/jquery.stellar.min.js"></script>
  <script src="<?= $basePath ?>/js/owl.carousel.min.js"></script>
  <script src="<?= $basePath ?>/js/aos.js"></script>
  <script src="<?= $basePath ?>/js/scrollax.min.js"></script>
  <script src="<?= $basePath ?>/js/mainoperator.js"></script>
  <script src="<?= $basePath ?>/js/fullscreen.js"></script>
  <script src="<?= $basePath ?>/js/onscreen-keyboard.js"></script>

</body>

</html>
