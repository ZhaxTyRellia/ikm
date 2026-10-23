<div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">Daftar Akun Operator &amp; Admin</h3>
            <p class="text-muted mb-0">Kelola seluruh akun Administrator dan identitas lengkap Target Operator.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="<?= $basePath ?>/admin/account_add" class="btn btn-primary font-weight-bold">
                + Tambah Akun / Operator
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 14px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">ID</th>
                            <th class="text-center" style="width: 75px;">Foto</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Unit / Alamat</th>
                            <th>Kontak</th>
                            <th class="text-center" style="width: 100px;">Role</th>
                            <th class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($users ?? []) as $user): ?>
                            <?php
                            $photoUrl = !empty($user['photo'])
                                ? $basePath . '/' . ltrim((string) $user['photo'], '/')
                                : $basePath . '/images/user.png';
                            ?>
                            <tr>
                                <td class="text-center align-middle font-weight-bold"><?= (int) $user['id'] ?></td>
                                <td class="text-center align-middle">
                                    <img src="<?= htmlspecialchars($photoUrl, ENT_QUOTES, 'UTF-8') ?>"
                                         alt="Foto"
                                         style="width: 46px; height: 46px; border-radius: 50%; object-fit: cover; border: 2px solid #1e3a8a;" />
                                </td>
                                <td class="align-middle font-weight-bold text-dark"><?= htmlspecialchars((string) $user['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="align-middle">@<?= htmlspecialchars((string) $user['username'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="align-middle small"><?= htmlspecialchars((string) ($user['address'] ?: '-'), ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="align-middle small">
                                    <div><?= htmlspecialchars((string) ($user['email'] ?: '-'), ENT_QUOTES, 'UTF-8') ?></div>
                                    <div class="text-muted"><?= htmlspecialchars((string) ($user['mobile'] ?: '-'), ENT_QUOTES, 'UTF-8') ?></div>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge badge-<?= ($user['role'] ?? '') === 'admin' ? 'dark' : 'info' ?> px-2 py-1">
                                        <?= htmlspecialchars((string) $user['role'], ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <a href="<?= $basePath ?>/admin/account_edit?id=<?= urlencode((string) $user['id']) ?>"
                                       class="btn btn-outline-primary btn-sm">Edit</a>
                                    <?php if ((int) $user['id'] !== 0): ?>
                                        <a onclick="return confirm('Yakin ingin menghapus akun ini?');"
                                           href="<?= $basePath ?>/admin/account_delete?id=<?= urlencode((string) $user['id']) ?>"
                                           class="btn btn-outline-danger btn-sm">Hapus</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
