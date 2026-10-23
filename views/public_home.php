<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Portal Polling &amp; Survei IKM - Suara Rakyat</title>
    <link rel="shortcut icon" href="<?= $basePath ?>/images/logo.png">
    <link rel="stylesheet" href="<?= $basePath ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= $basePath ?>/css/style.css" />
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f4f7fb;
            color: #1e293b;
            overflow-x: hidden;
            margin: 0;
        }
        /* Full-Screen Welcome Hero with Animated Background */
        .welcome-hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(-45deg, #0f172a, #1e3a8a, #0d9488, #1e1b4b);
            background-size: 400% 400%;
            animation: gradientBG 14s ease infinite;
            color: #ffffff;
            overflow: hidden;
            padding: 60px 20px 90px;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        /* Animated Floating Orbs */
        .bg-orbs {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 1;
        }
        .orb {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.16) 0%, rgba(255,255,255,0) 70%);
            animation: floatOrb 18s infinite ease-in-out alternate;
        }
        .orb-1 { width: 420px; height: 420px; top: -100px; left: -100px; animation-duration: 16s; }
        .orb-2 { width: 520px; height: 520px; bottom: -160px; right: -120px; animation-duration: 22s; animation-delay: -5s; }
        .orb-3 { width: 300px; height: 300px; top: 25%; right: 15%; animation-duration: 19s; animation-delay: -9s; }
        .orb-4 { width: 240px; height: 240px; bottom: 18%; left: 12%; animation-duration: 15s; animation-delay: -3s; }
        @keyframes floatOrb {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(40px, -35px) scale(1.12); }
            100% { transform: translate(-30px, 30px) scale(0.94); }
        }

        .hero-container {
            position: relative;
            z-index: 2;
            max-width: 1140px;
            width: 100%;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #e0f2fe;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .hero-title {
            font-size: 2.75rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
        }
        .hero-desc {
            font-size: 1.08rem;
            line-height: 1.75;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 24px;
        }
        .step-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 32px;
        }
        .step-pill {
            background: rgba(15, 23, 42, 0.45);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 12px 16px;
            flex: 1 1 200px;
            backdrop-filter: blur(6px);
        }
        .step-pill strong {
            display: block;
            color: #38bdf8;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }
        .step-pill span {
            font-size: 0.83rem;
            color: rgba(255, 255, 255, 0.85);
        }
        .btn-cta-scroll {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #ffffff;
            color: #0f172a;
            font-weight: 700;
            padding: 14px 32px;
            border-radius: 50px;
            font-size: 1rem;
            text-decoration: none !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }
        .btn-cta-scroll:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.35);
            background: #f0f9ff;
            color: #0369a1;
        }
        .hero-illustration-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 24px;
            padding: 28px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }
        .hero-illustration-card img {
            max-height: 250px;
            width: auto;
            filter: drop-shadow(0 12px 20px rgba(0,0,0,0.25));
            margin-bottom: 18px;
        }
        .scroll-down-indicator {
            position: absolute;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none !important;
            font-size: 0.85rem;
            text-align: center;
            animation: bounceDown 2s infinite;
        }
        .scroll-down-indicator:hover {
            color: #ffffff;
        }
        @keyframes bounceDown {
            0%, 20%, 50%, 80%, 100% { transform: translate(-50%, 0); }
            40% { transform: translate(-50%, -8px); }
            60% { transform: translate(-50%, -4px); }
        }

        /* Operator Card Grid Section */
        .operator-section {
            padding: 80px 0 90px;
            background: #f4f7fb;
        }
        .section-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            font-weight: 700;
            font-size: 0.8rem;
            padding: 6px 16px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 10px;
        }
        .operator-card {
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            overflow: hidden;
        }
        .operator-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.1) !important;
        }
        .operator-card-top {
            background: linear-gradient(135deg, #1e3a8a 0%, #0d9488 100%);
            height: 85px;
            position: relative;
        }
        .operator-avatar-wrap {
            margin-top: -48px;
            margin-bottom: 12px;
            position: relative;
            display: inline-block;
        }
        .operator-avatar {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ffffff;
            background: #ffffff;
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.15);
        }
        .rating-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 14px;
            margin: 14px 0;
        }
        .stars-display {
            font-size: 1.35rem;
            letter-spacing: 3px;
            line-height: 1;
            margin-bottom: 6px;
        }
        .star-filled { color: #f59e0b; }
        .star-empty { color: #cbd5e1; }
        .identity-list {
            background: #f8fafc;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 0.85rem;
            text-align: left;
            margin-bottom: 16px;
            border: 1px solid #f1f5f9;
        }
        .identity-list div {
            margin-bottom: 6px;
            color: #475569;
            word-break: break-word;
        }
        .identity-list div:last-child {
            margin-bottom: 0;
        }
        .btn-survey-now {
            border-radius: 50px;
            font-weight: 700;
            padding: 11px 20px;
            background: linear-gradient(135deg, #1e3a8a 0%, #0d9488 100%);
            border: none;
            color: #ffffff !important;
            box-shadow: 0 6px 15px rgba(13, 148, 136, 0.25);
            transition: opacity 0.2s ease, transform 0.2s ease;
        }
        .btn-survey-now:hover {
            opacity: 0.95;
            transform: translateY(-2px);
        }

        /* Footer with subtle right-aligned Login button */
        .public-footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 28px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }
        .btn-login-subtle {
            color: rgba(148, 163, 184, 0.38);
            background: transparent;
            border: 1px solid rgba(148, 163, 184, 0.18);
            font-size: 0.78rem;
            padding: 5px 14px;
            border-radius: 50px;
            text-decoration: none !important;
            transition: all 0.25s ease;
            cursor: pointer;
        }
        .btn-login-subtle:hover, .btn-login-subtle:focus {
            color: #e2e8f0;
            border-color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.06);
            outline: none;
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 2rem; }
            .welcome-hero { padding: 40px 15px 80px; }
        }
    </style>
</head>
<body>

<!-- FULL-SCREEN WELCOME SCREEN -->
<section class="welcome-hero">
    <div class="bg-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="orb orb-4"></div>
    </div>

    <div class="hero-container">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="hero-badge">
                    &#9733; Sistem Polling &amp; Evaluasi Layanan Publik (IKM)
                </div>
                <h1 class="hero-title">
                    Suara Anda Menentukan Kualitas Pelayanan Kami
                </h1>
                <p class="hero-desc">
                    Selamat datang di <strong>Portal Survei Indeks Kepuasan Masyarakat (IKM) &amp; Polling Suara Rakyat</strong>.
                    Platform ini dihadirkan secara transparan untuk menilai kualitas kinerja setiap <strong>Operator / Loket Pelayanan</strong>
                    secara langsung, objektif, dan terukur. Setiap penilaian yang Anda berikan langsung terakumulasi menjadi
                    <strong>Rating Bintang &amp; Status Kualitas Layanan</strong> masing-masing operator di bawah ini.
                </p>

                <div class="step-pills">
                    <div class="step-pill">
                        <strong>1. Pilih Target Operator</strong>
                        <span>Lihat profil lengkap &amp; rating layanan operator pada daftar di bawah.</span>
                    </div>
                    <div class="step-pill">
                        <strong>2. Jawab Pertanyaan Survei</strong>
                        <span>Berikan penilaian melalui pilihan pernyataan sesuai kebutuhan operator.</span>
                    </div>
                    <div class="step-pill">
                        <strong>3. Tulis Catatan Feedback</strong>
                        <span>Sampaikan saran di akhir survei (opsional / boleh dilewati jika ingin langsung kirim).</span>
                    </div>
                </div>

                <div class="d-flex flex-wrap align-items-center" style="gap: 14px;">
                    <a href="#daftar-operator" class="btn-cta-scroll">
                        <span>Lihat Daftar Operator &amp; Mulai Polling</span>
                        <span>&darr;</span>
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="hero-illustration-card">
                    <img src="<?= $basePath ?>/images/komputer.png" alt="Ilustrasi Survei IKM" class="img-fluid" />
                    <h5 class="font-weight-bold text-white mb-2">Transparan, Cepat &amp; Akuntabel</h5>
                    <p class="small text-light mb-3" style="opacity: 0.85;">
                        Indikator bintang secara otomatis memberi tanda apakah pelayanan seorang Operator tergolong
                        <strong>Sangat Baik</strong>, <strong>Layanan Baik</strong>, <strong>Kurang Baik</strong>, atau <strong>Layanan Buruk</strong>.
                    </p>
                    <div class="d-flex justify-content-around text-white pt-2 border-top" style="border-color: rgba(255,255,255,0.18) !important;">
                        <div>
                            <div class="h4 font-weight-bold mb-0"><?= count($operators ?? []) ?></div>
                            <small style="opacity: 0.8;">Target Operator</small>
                        </div>
                        <div>
                            <?php
                            $totalAllSuara = 0;
                            foreach (($operators ?? []) as $opItem) {
                                $totalAllSuara += (int) ($opItem['total_suara'] ?? 0);
                            }
                            ?>
                            <div class="h4 font-weight-bold mb-0"><?= $totalAllSuara ?></div>
                            <small style="opacity: 0.8;">Total Suara Masuk</small>
                        </div>
                        <div>
                            <div class="h4 font-weight-bold mb-0 text-warning">&#9733; 1–5</div>
                            <small style="opacity: 0.8;">Akumulasi Rating</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="#daftar-operator" class="scroll-down-indicator">
        <div>Gulir ke Bawah untuk Memilih Operator</div>
        <div style="font-size: 1.2rem;">&#8595;</div>
    </a>
</section>

<!-- DAFTAR OPERATOR CARD GRID SECTION -->
<section id="daftar-operator" class="operator-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">Daftar Target Survei</span>
            <h2 class="font-weight-bold text-dark mb-2">Pilih Profil Operator Pelayanan</h2>
            <p class="text-muted mx-auto mb-0" style="max-width: 680px;">
                Berikut adalah daftar operator pelayanan beserta identitas lengkap, jumlah partisipasi masyarakat yang telah mengisi survei, serta akumulasi rating bintang sebagai indikator mutu layanan.
            </p>
        </div>

        <div class="row">
            <?php if (empty($operators)): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center py-4 shadow-sm rounded">
                        Belum ada data Operator yang ditambahkan oleh Admin.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($operators as $op): ?>
                    <?php
                    $photoUrl = !empty($op['photo'])
                        ? $basePath . '/' . ltrim($op['photo'], '/')
                        : $basePath . '/images/user.png';
                    $starsFilled = (int) ($op['stars_filled'] ?? 0);
                    $starRating  = number_format((float) ($op['star_rating'] ?? 0), 1);
                    $totalSuara  = (int) ($op['total_suara'] ?? 0);
                    $qCount      = (int) ($op['question_count'] ?? 0);
                    ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card operator-card h-100 shadow-sm">
                            <div class="operator-card-top"></div>
                            <div class="card-body text-center d-flex flex-column pt-0 px-4 pb-4">
                                <div class="operator-avatar-wrap">
                                    <img src="<?= htmlspecialchars($photoUrl) ?>"
                                         alt="<?= htmlspecialchars($op['name']) ?>"
                                         class="operator-avatar" />
                                </div>

                                <h5 class="font-weight-bold text-dark mb-1">
                                    <?= htmlspecialchars($op['name']) ?>
                                </h5>
                                <div class="small text-muted mb-2">
                                    Kode / ID Operator: <strong>@<?= htmlspecialchars($op['username']) ?></strong>
                                </div>

                                <!-- Akumulasi Rating Bintang & Indikator Layanan -->
                                <div class="rating-box">
                                    <div class="stars-display" title="Rating <?= $starRating ?> dari 5.0">
                                        <?php for ($s = 1; $s <= 5; $s++): ?>
                                            <span class="<?= $s <= $starsFilled ? 'star-filled' : 'star-empty' ?>">&#9733;</span>
                                        <?php endfor; ?>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center flex-wrap" style="gap: 8px;">
                                        <span class="font-weight-bold text-dark" style="font-size: 0.95rem;">
                                            <?= $totalSuara > 0 ? "{$starRating} / 5.0" : '0.0 / 5.0' ?>
                                        </span>
                                        <span class="badge badge-<?= htmlspecialchars($op['status_class'] ?? 'secondary') ?> px-2 py-1">
                                            <?= htmlspecialchars($op['status_label'] ?? 'Belum Dinilai') ?>
                                        </span>
                                    </div>
                                    <div class="small text-muted mt-1">
                                        Telah disurvei oleh <strong><?= $totalSuara ?></strong> Responden
                                        &bull; <strong><?= $qCount ?></strong> Pertanyaan + Feedback
                                    </div>
                                </div>

                                <!-- Identitas Lengkap Operator -->
                                <div class="identity-list">
                                    <div>
                                        <strong>Unit / Alamat:</strong>
                                        <?= htmlspecialchars($op['address'] ?: '-') ?>
                                    </div>
                                    <div>
                                        <strong>Email:</strong>
                                        <?= htmlspecialchars($op['email'] ?: '-') ?>
                                    </div>
                                    <div>
                                        <strong>No. HP / Telp:</strong>
                                        <?= htmlspecialchars($op['mobile'] ?: '-') ?>
                                    </div>
                                </div>

                                <div class="mt-auto">
                                    <a href="<?= $basePath ?>/survey?id=<?= urlencode((string) $op['id']) ?>"
                                       class="btn btn-survey-now btn-block">
                                        Mulai Survei &amp; Beri Suara &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- FOOTER DENGAN TOMBOL LOGIN SAMAR DI SEBELAH KANAN -->
<footer class="public-footer">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="mb-3 mb-md-0 text-center text-md-left">
                <span class="font-weight-bold text-light">Portal Survei IKM &amp; Suara Rakyat</span>
                <span class="mx-2">&bull;</span>
                <small>&copy; <?= date('Y') ?> Indeks Kepuasan Masyarakat. All Rights Reserved.</small>
            </div>
            <div>
                <?php if (!empty($isAdmin)): ?>
                    <a href="<?= $basePath ?>/admin/home" class="btn-login-subtle" title="Dashboard Management Admin">
                        &#9881; Panel Admin
                    </a>
                <?php else: ?>
                    <button type="button" class="btn-login-subtle" data-toggle="modal" data-target="#loginModal" title="Login Pengelola">
                        &#128274; Login Admin
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>

<!-- MODAL LOGIN ADMIN -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #0f172a, #1e3a8a); border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h5 class="modal-title font-weight-bold" id="loginModalLabel">Login Management Admin</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= $basePath ?>/login" method="POST">
                <div class="modal-body p-4">
                    <?php if (!empty($loginError)): ?>
                        <div class="alert alert-danger py-2"><?= htmlspecialchars($loginError) ?></div>
                    <?php endif; ?>
                    <p class="text-muted small mb-3">
                        Masuk sebagai Administrator untuk menambah/mengurangi profil operator dan mengatur 1–10 pertanyaan dinamis.
                    </p>
                    <div class="form-group">
                        <label class="font-weight-bold">Username Admin</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username admin" required autofocus />
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required />
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">Masuk Dashboard</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= $basePath ?>/js/jquery-3.6.0.min.js"></script>
<script src="<?= $basePath ?>/js/bootstrap.bundle.min.js"></script>
<?php if (!empty($loginError)): ?>
<script>
    $(function () {
        $('#loginModal').modal('show');
    });
</script>
<?php endif; ?>
</body>
</html>
