<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= htmlspecialchars($title ?? 'Dashboard', ENT_QUOTES, 'UTF-8') ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/gif" href="<?= $basePath ?>/images/favicon.png" />
  <link rel="stylesheet" href="<?= $basePath ?>/css/animate.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/style2.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/style.css">
  <?php if (!empty($showFooter)): ?>
  <style>
    .footer {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      background-color: #007bff;
      color: white;
      text-align: left;
      border-top-left-radius: 6px;
      border-top-right-radius: 6px;
      z-index: 999;
    }
    .footer .text {
      padding-left: 20px;
      font-size: 20px;
      font-weight: 500;
      font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    }
  </style>
  <?php endif; ?>
</head>

<body>
  <?php if (!empty($showFooter)): ?>
  <div class="footer">
    <div class="text">Publisher MTProject &copy; 2024</div>
  </div>
  <?php endif; ?>

  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <?php if (!empty($isHome)): ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
          aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span>&#9776;</span> Menu
        </button>
        <div style="font-size:25px;font-weight:800;color:white;font-family:calibri;">SATISFACTION SURVEY SYSTEM</div>
      <?php else: ?>
        <a class="navbar-brand" href="<?= $basePath ?>/admin/home">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
          aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span>&#9776;</span> Menu
        </button>
      <?php endif; ?>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <?php if (!empty($isHome)): ?>
            <li class="nav-item <?= ($activeMenu ?? '') === 'home' ? 'active' : '' ?>">
              <a href="<?= $basePath ?>/admin/home" class="nav-link">Home</a>
            </li>
          <?php endif; ?>
          <li class="nav-item <?= ($activeMenu ?? '') === 'data' ? 'active' : '' ?>">
            <a href="<?= $basePath ?>/admin/data" class="nav-link">Data</a>
          </li>
          <li class="nav-item <?= ($activeMenu ?? '') === 'question' ? 'active' : '' ?>">
            <a href="<?= $basePath ?>/admin/question" class="nav-link">Question</a>
          </li>
          <li class="nav-item <?= ($activeMenu ?? '') === 'account' ? 'active' : '' ?>">
            <a href="<?= $basePath ?>/admin/account" class="nav-link">Account</a>
          </li>
          <li class="nav-item cta">
            <a href="<?= $basePath ?>/logout" class="nav-link"><span>logout</span></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <?= $content ?>

  <script src="<?= $basePath ?>/js/jquery.min.js"></script>
  <script src="<?= $basePath ?>/js/popper.min.js"></script>
  <script src="<?= $basePath ?>/js/bootstrap.min.js"></script>
  <script src="<?= $basePath ?>/js/jquery.easing.1.3.js"></script>
  <script src="<?= $basePath ?>/js/jquery.waypoints.min.js"></script>
  <script src="<?= $basePath ?>/js/owl.carousel.min.js"></script>
  <script src="<?= $basePath ?>/js/jquery.animateNumber.min.js"></script>
  <script src="<?= $basePath ?>/js/mainoperator.js"></script>
</body>

</html>
