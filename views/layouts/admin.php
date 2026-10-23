<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= htmlspecialchars($title ?? 'Dashboard Management Admin - IKM') ?></title>
    <link rel="shortcut icon" href="<?= $basePath ?>/images/logo.png">
    <link rel="stylesheet" href="<?= $basePath ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= $basePath ?>/css/style.css" />
    <style>
        body {
            background-color: #f4f7fb;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .admin-navbar {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.15);
        }
        .admin-main {
            flex: 1;
            padding-top: 28px;
            padding-bottom: 48px;
        }
        .admin-footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 18px 0;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark admin-navbar py-3">
    <div class="container">
        <a class="navbar-brand font-weight-bold d-flex align-items-center" href="<?= $basePath ?>/admin/home">
            <img src="<?= $basePath ?>/images/logo.png" alt="Logo" style="height: 32px; margin-right: 10px;" onerror="this.style.display='none'">
            <span>Panel Management IKM</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?= ($activeMenu ?? '') === 'home' ? 'active font-weight-bold' : '' ?>">
                    <a class="nav-link" href="<?= $basePath ?>/admin/home">Management Operator</a>
                </li>
                <li class="nav-item <?= ($activeMenu ?? '') === 'question' ? 'active font-weight-bold' : '' ?>">
                    <a class="nav-link" href="<?= $basePath ?>/admin/question">Pertanyaan Dinamis (1–10)</a>
                </li>
                <li class="nav-item <?= ($activeMenu ?? '') === 'data' ? 'active font-weight-bold' : '' ?>">
                    <a class="nav-link" href="<?= $basePath ?>/admin/data">Rekap Data &amp; Feedback</a>
                </li>
                <li class="nav-item <?= ($activeMenu ?? '') === 'account' ? 'active font-weight-bold' : '' ?>">
                    <a class="nav-link" href="<?= $basePath ?>/admin/account">Semua Akun</a>
                </li>
            </ul>
            <div class="d-flex align-items-center" style="gap: 10px;">
                <a class="btn btn-outline-light btn-sm px-3" href="<?= $basePath ?>/" target="_blank">
                    Lihat Halaman Publik &nearr;
                </a>
                <a class="btn btn-danger btn-sm px-3 font-weight-bold" href="<?= $basePath ?>/logout">
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<main class="admin-main">
    <?= $content ?>
</main>

<?php if (!empty($showFooter)): ?>
<footer class="admin-footer mt-auto">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div>&copy; <?= date('Y') ?> Panel Management Admin Survei IKM.</div>
        <div><a href="<?= $basePath ?>/" class="text-light">Ke Halaman Utama (Welcome Screen) &rarr;</a></div>
    </div>
</footer>
<?php endif; ?>

<script src="<?= $basePath ?>/js/jquery-3.6.0.min.js"></script>
<script src="<?= $basePath ?>/js/bootstrap.bundle.min.js"></script>
</body>
</html>
