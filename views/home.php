<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Portal Polling &amp; Survei IKM - Suara Rakyat</title>
    <link rel="icon" type="image/png" href="<?= $basePath ?>/images/favicon.png">
    <link rel="stylesheet" href="<?= $basePath ?>/css/style2.css" />
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Open Sans', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* 1. FULL SCREEN WELCOME HERO */
        .welcome-screen {
            position: relative;
            min-height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(-45deg, #0f172a, #1e3a8a, #0f766e, #1e1b4b);
            background-size: 400% 400%;
            animation: heroGradient 14s ease infinite;
            color: #ffffff;
            padding: 40px 20px 80px;
            overflow: hidden;
            text-align: center;
        }
        @keyframes heroGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .bg-circles {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 1;
        }
        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.14) 0%, rgba(255,255,255,0) 70%);
            animation: floatBubble 16s infinite ease-in-out alternate;
        }
        .c1 { width: 380px; height: 380px; top: -80px; left: -80px; }
        .c2 { width: 450px; height: 450px; bottom: -120px; right: -100px; animation-delay: -5s; }
        .c3 { width: 260px; height: 260px; top: 20%; right: 12%; animation-delay: -9s; }
        @keyframes floatBubble {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(35px, -30px) scale(1.1); }
        }

        .welcome-content {
            position: relative;
            z-index: 2;
            max-width: 820px;
            width: 100%;
            margin: 0 auto;
        }
        .welcome-logo {
            width: 64px;
            height: 64px;
            object-fit: contain;
            margin-bottom: 14px;
            filter: drop-shadow(0 4px 12px rgba(0,0,0,0.3));
        }
        .welcome-pill {
            display: inline-block;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #bae6fd;
            padding: 5px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
        .welcome-title {
            font-size: 2.3rem;
            font-weight: 800;
            line-height: 1.25;
            margin: 0 0 14px;
            color: #ffffff;
            text-shadow: 0 4px 16px rgba(0,0,0,0.25);
        }
        .welcome-desc {
            font-size: 1rem;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.88);
            margin: 0 auto 24px;
            max-width: 720px;
        }
        .welcome-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 28px;
            text-align: left;
        }
        .welcome-step-item {
            background: rgba(15, 23, 42, 0.45);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 10px;
            padding: 12px 14px;
        }
        .welcome-step-item strong {
            display: block;
            font-size: 13px;
            color: #38bdf8;
            margin-bottom: 3px;
        }
        .welcome-step-item span {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.82);
            line-height: 1.4;
            display: block;
        }
        .btn-scroll-operators {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            color: #0f172a !important;
            font-weight: 700;
            font-size: 14px;
            padding: 12px 26px;
            border-radius: 50px;
            text-decoration: none !important;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            transition: transform 0.2s ease, background 0.2s ease;
        }
        .btn-scroll-operators:hover {
            transform: translateY(-2px);
            background: #e0f2fe;
        }
        .scroll-hint {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            color: rgba(255,255,255,0.65);
            font-size: 12px;
            text-decoration: none !important;
        }
        .scroll-hint:hover {
            color: #ffffff;
        }

        /* 2. COMPACT THUMBNAIL GRID OPERATOR SECTION */
        .operator-section {
            padding: 56px 20px 70px;
            max-width: 1140px;
            margin: 0 auto;
        }
        .section-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .section-header h2 {
            font-size: 1.55rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 6px;
        }
        .section-header p {
            font-size: 0.9rem;
            color: #64748b;
            margin: 0 auto;
            max-width: 580px;
        }

        /* Small Thumbnail Grid */
        .thumb-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 225px));
            gap: 16px;
            justify-content: center;
        }
        .op-thumb {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 14px 14px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        .op-thumb::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1e3a8a, #0d9488);
        }
        .op-thumb:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.1);
            border-color: #cbd5e1;
        }
        .op-thumb-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            margin-bottom: 8px;
        }
        .op-thumb-name {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 2px;
            line-height: 1.25;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            width: 100%;
        }
        .op-thumb-unit {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
        }
        .op-thumb-stars {
            font-size: 13px;
            letter-spacing: 1px;
            line-height: 1;
            margin-bottom: 4px;
        }
        .star-on { color: #f59e0b; }
        .star-off { color: #cbd5e1; }
        .op-thumb-rating-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            margin-bottom: 8px;
        }
        .op-thumb-score {
            font-size: 11px;
            font-weight: 700;
            color: #334155;
        }
        .op-thumb-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 50px;
            color: #fff;
        }
        .bg-st-success { background: #16a34a; }
        .bg-st-info { background: #0284c7; }
        .bg-st-warning { background: #d97706; }
        .bg-st-danger { background: #dc2626; }
        .bg-st-secondary { background: #64748b; }

        .op-thumb-meta {
            width: 100%;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 8px;
            padding: 6px 8px;
            font-size: 11px;
            color: #475569;
            margin-bottom: 10px;
            line-height: 1.4;
        }
        .op-thumb-btn {
            margin-top: auto;
            width: 100%;
            background: linear-gradient(135deg, #1e3a8a, #0f766e);
            color: #ffffff !important;
            font-size: 12px;
            font-weight: 700;
            padding: 7px 10px;
            border-radius: 6px;
            text-decoration: none !important;
            transition: opacity 0.2s ease;
        }
        .op-thumb-btn:hover {
            opacity: 0.92;
        }

        /* 3. FOOTER WITH SUBTLE LOGIN ON RIGHT */
        .site-footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 20px;
            font-size: 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .site-footer-inner {
            max-width: 1140px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .btn-login-subtle {
            color: rgba(148, 163, 184, 0.35);
            background: transparent;
            border: 1px solid rgba(148, 163, 184, 0.15);
            font-size: 11px;
            padding: 4px 12px;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none !important;
            transition: all 0.2s ease;
        }
        .btn-login-subtle:hover {
            color: #e2e8f0;
            border-color: rgba(255, 255, 255, 0.35);
            background: rgba(255, 255, 255, 0.06);
        }

        @media (max-width: 768px) {
            .welcome-title { font-size: 1.75rem; }
            .welcome-steps { grid-template-columns: 1fr; }
            .thumb-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            }
        }
    </style>
</head>
<body>

<!-- 1. FULL SCREEN WELCOME SCREEN -->
<section class="welcome-screen">
    <div class="bg-circles">
        <div class="bg-circle c1"></div>
        <div class="bg-circle c2"></div>
        <div class="bg-circle c3"></div>
    </div>

    <div class="welcome-content">
        <?php
        $companyLogo = !empty($settings['company_logo'])
            ? $basePath . '/' . ltrim((string) $settings['company_logo'], '/')
            : $basePath . '/images/logo.png';
        ?>
        <img src="<?= htmlspecialchars($companyLogo, ENT_QUOTES, 'UTF-8') ?>" alt="Logo Instansi" class="welcome-logo" />
        <div>
            <span class="welcome-pill">&#9733; Portal Survei Kepuasan Masyarakat (IKM)</span>
        </div>
        <h1 class="welcome-title">Suara Rakyat &amp; Polling Kualitas Pelayanan</h1>
        <p class="welcome-desc">
            Selamat datang di sistem evaluasi pelayanan publik. Berikan penilaian objektif Anda terhadap kinerja setiap
            <strong>Operator Pelayanan</strong> kami. Hasil survei langsung diakumulasikan menjadi
            <strong>Rating Bintang</strong> sebagai penanda kualitas layanan operator terkait.
        </p>

        <div class="welcome-steps">
            <div class="welcome-step-item">
                <strong>1. Pilih Operator</strong>
                <span>Klik salah satu kartu profil operator di bawah sesuai loket pelayanan.</span>
            </div>
            <div class="welcome-step-item">
                <strong>2. Beri Penilaian</strong>
                <span>Jawab pertanyaan pilihan kepuasan sesuai konfigurasi operator.</span>
            </div>
            <div class="welcome-step-item">
                <strong>3. Catatan Feedback</strong>
                <span>Tulis saran untuk operator di akhir survei (opsional / bisa di-skip).</span>
            </div>
        </div>

        <a href="#daftar-operator" class="btn-scroll-operators">
            <span>Pilih Operator &amp; Mulai Survei</span>
            <span>&darr;</span>
        </a>
    </div>

    <a href="#daftar-operator" class="scroll-hint">
        Gulir ke bawah untuk melihat daftar operator &#8595;
    </a>
</section>

<!-- 2. COMPACT THUMBNAIL GRID OPERATOR -->
<section id="daftar-operator" class="operator-section">
    <div class="section-header">
        <h2>Daftar Target Operator Pelayanan</h2>
        <p>Pilih profil operator untuk mengisi survei. Rating bintang menunjukkan akumulasi penilaian masyarakat.</p>
    </div>

    <?php if (empty($operators)): ?>
        <div class="alert alert-info text-center">
            Belum ada profil Operator yang ditambahkan oleh Admin.
        </div>
    <?php else: ?>
        <div class="thumb-grid">
            <?php foreach ($operators as $op): ?>
                <?php
                $photoUrl = !empty($op['photo'])
                    ? $basePath . '/' . ltrim((string) $op['photo'], '/')
                    : $basePath . '/images/default-operator.svg';
                $starsFilled = (int) ($op['stars_filled'] ?? 0);
                $starRating  = number_format((float) ($op['star_rating'] ?? 0), 1);
                $totalSuara  = (int) ($op['total_suara'] ?? 0);
                $qCount      = (int) ($op['question_count'] ?? 0);
                $stClass     = 'bg-st-' . ($op['status_class'] ?? 'secondary');
                ?>
                <div class="op-thumb">
                    <img src="<?= htmlspecialchars($photoUrl, ENT_QUOTES, 'UTF-8') ?>"
                         alt="<?= htmlspecialchars((string) $op['name'], ENT_QUOTES, 'UTF-8') ?>"
                         class="op-thumb-avatar" />

                    <h3 class="op-thumb-name" title="<?= htmlspecialchars((string) $op['name'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars((string) $op['name'], ENT_QUOTES, 'UTF-8') ?>
                    </h3>
                    <div class="op-thumb-unit" title="<?= htmlspecialchars((string) ($op['address'] ?: '-'), ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars((string) ($op['address'] ?: '-'), ENT_QUOTES, 'UTF-8') ?>
                    </div>

                    <div class="op-thumb-stars" title="Rating <?= $starRating ?> / 5.0">
                        <?php for ($s = 1; $s <= 5; $s++): ?>
                            <span class="<?= $s <= $starsFilled ? 'star-on' : 'star-off' ?>">&#9733;</span>
                        <?php endfor; ?>
                    </div>

                    <div class="op-thumb-rating-row">
                        <span class="op-thumb-score"><?= $starRating ?>/5</span>
                        <span class="op-thumb-badge <?= htmlspecialchars($stClass, ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars((string) ($op['status_label'] ?? 'Belum Dinilai'), ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </div>

                    <div class="op-thumb-meta">
                        <div><strong><?= $totalSuara ?></strong> Disurvei &bull; <strong><?= $qCount ?></strong> Soal</div>
                        <div class="text-truncate" title="<?= htmlspecialchars((string) ($op['mobile'] ?: $op['email'] ?: '-'), ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars((string) ($op['mobile'] ?: $op['email'] ?: '-'), ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    </div>

                    <a href="<?= $basePath ?>/survey?id=<?= urlencode((string) $op['id']) ?>" class="op-thumb-btn">
                        Mulai Survei &rarr;
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- 3. FOOTER DENGAN TOMBOL LOGIN SAMAR DI KANAN -->
<footer class="site-footer">
    <div class="site-footer-inner">
        <div style="flex: 1; min-width: 240px;">
            <div>
                <strong><?= htmlspecialchars((string) ($settings['footer_text'] ?? 'Portal Survei IKM & Suara Rakyat'), ENT_QUOTES, 'UTF-8') ?></strong>
                &copy; <?= date('Y') ?> All Rights Reserved.
            </div>
            <?php if (!empty($settings['marquee_text'])): ?>
                <div style="margin-top: 4px; color: #cbd5e1; font-size: 11.5px;">
                    <marquee scrollamount="5"><?= htmlspecialchars((string) $settings['marquee_text'], ENT_QUOTES, 'UTF-8') ?></marquee>
                </div>
            <?php endif; ?>
        </div>
        <div>
            <?php if (!empty($isAdmin)): ?>
                <a href="<?= $basePath ?>/admin/home" class="btn-login-subtle">Panel Admin</a>
            <?php else: ?>
                <button type="button" class="btn-login-subtle" data-toggle="modal" data-target="#loginModal">
                    Login Admin
                </button>
            <?php endif; ?>
        </div>
    </div>
</footer>

<!-- MODAL LOGIN ADMIN -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header py-2 bg-dark text-white">
                <h6 class="modal-title font-weight-bold mb-0">Login Admin</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= $basePath ?>/login" method="POST">
                <div class="modal-body p-3">
                    <?php if (!empty($loginError)): ?>
                        <div class="alert alert-danger py-1 px-2 small mb-2"><?= htmlspecialchars($loginError) ?></div>
                    <?php endif; ?>
                    <div class="form-group mb-2">
                        <label class="small font-weight-bold mb-1">Username</label>
                        <input type="text" name="username" class="form-control form-control-sm" required autofocus />
                    </div>
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold mb-1">Password</label>
                        <input type="password" name="password" class="form-control form-control-sm" required />
                    </div>
                </div>
                <div class="modal-footer py-2 bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold">Masuk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= $basePath ?>/js/jquery.min.js"></script>
<script src="<?= $basePath ?>/js/popper.min.js"></script>
<script src="<?= $basePath ?>/js/bootstrap.min.js"></script>
<?php if (!empty($loginError)): ?>
<script>
    $(function () {
        $('#loginModal').modal('show');
    });
</script>
<?php endif; ?>
</body>
</html>
