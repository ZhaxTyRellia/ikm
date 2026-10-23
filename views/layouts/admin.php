<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= htmlspecialchars($title ?? 'Satisfaction Survey System', ENT_QUOTES, 'UTF-8') ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/gif" href="<?= $basePath ?>/images/favicon.png" />
  <link rel="stylesheet" href="<?= $basePath ?>/css/animate.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/style2.css">
  <link rel="stylesheet" href="<?= $basePath ?>/css/style.css">
  <style>
    .operator-card {
      background: #ffffff;
      border-radius: 14px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      padding: 24px 20px;
      margin-bottom: 30px;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
      border: 1px solid #eef2f7;
      width: 100%;
    }
    .operator-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 14px 32px rgba(0, 123, 255, 0.16);
    }
    .operator-avatar {
      width: 110px;
      height: 110px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #78d5ef;
      margin: 0 auto 14px auto;
      display: block;
      background: #f8f9fa;
    }
    .operator-meta {
      font-size: 13.5px;
      color: #555;
      text-align: left;
      background: #f8fbff;
      border-radius: 8px;
      padding: 10px 12px;
      margin: 12px 0;
      line-height: 1.6;
    }
    .operator-meta div {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .suara-badge {
      background: linear-gradient(135deg, #007bff, #00c6ff);
      color: #fff;
      border-radius: 10px;
      padding: 10px;
      margin: 12px 0;
    }
    .suara-badge .number {
      font-size: 28px;
      font-weight: 800;
      display: block;
      line-height: 1.1;
    }
    <?php if (!empty($showFooter)): ?>
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
    <?php endif; ?>
  </style>
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
          <?php if (!empty($isAdmin)): ?>
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
          <?php else: ?>
            <li class="nav-item active">
              <a href="<?= $basePath ?>/" class="nav-link">Home</a>
            </li>
            <li class="nav-item cta">
              <a href="#" class="nav-link" data-toggle="modal" data-target="#loginModal"><span>Login Admin</span></a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <?= $content ?>

  <?php if (empty($isAdmin)): ?>
  <!-- Modal Pop-up Login Admin -->
  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius:12px;overflow:hidden;">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title text-white font-weight-bold" id="loginModalLabel">SIGN IN ADMIN</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= $basePath ?>/login" method="post">
          <div class="modal-body p-4">
            <?php if (!empty($loginError)): ?>
              <div class="alert alert-danger text-center py-2"><?= htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
            <div class="form-group">
              <label class="font-weight-bold">Username</label>
              <input type="text" name="username" class="form-control" placeholder="Masukkan Username Admin" required>
            </div>
            <div class="form-group mb-0">
              <label class="font-weight-bold">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
            </div>
          </div>
          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" name="login" class="btn btn-primary px-4">Sign In</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <script src="<?= $basePath ?>/js/jquery.min.js"></script>
  <script src="<?= $basePath ?>/js/popper.min.js"></script>
  <script src="<?= $basePath ?>/js/bootstrap.min.js"></script>
  <script src="<?= $basePath ?>/js/jquery.easing.1.3.js"></script>
  <script src="<?= $basePath ?>/js/jquery.waypoints.min.js"></script>
  <script src="<?= $basePath ?>/js/owl.carousel.min.js"></script>
  <script src="<?= $basePath ?>/js/jquery.animateNumber.min.js"></script>
  <script src="<?= $basePath ?>/js/mainoperator.js"></script>
  <?php if (!empty($loginError)): ?>
  <script>
    $(function () {
      $('#loginModal').modal('show');
    });
  </script>
  <?php endif; ?>
</body>

</html>
