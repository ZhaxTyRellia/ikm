<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h3 class="font-weight-bold text-dark mb-1">
                        <?= !empty($isEdit) ? 'Edit Profil Operator / Admin' : 'Tambah Target Operator / Admin Baru' ?>
                    </h3>
                    <p class="text-muted small mb-0">
                        Lengkapi foto profil dan identitas lengkap operator untuk ditampilkan pada beranda survei publik.
                    </p>
                </div>
                <a href="<?= $basePath ?>/admin/home" class="btn btn-outline-secondary btn-sm font-weight-bold">
                    &larr; Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-body p-4">
                    <form action="<?= $basePath ?>/admin/<?= !empty($isEdit) ? 'account_edit' : 'account_add' ?>" method="post" enctype="multipart/form-data">
                        <?php if (!empty($isEdit)): ?>
                            <input type="hidden" name="id" value="<?= htmlspecialchars((string) ($account['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" />
                        <?php endif; ?>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Nama Lengkap Operator / Loket</label>
                                <input type="text" name="name" class="form-control" required
                                       placeholder="Contoh: Budi Santoso - Loket 1"
                                       value="<?= htmlspecialchars((string) ($account['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Username / Kode Unik</label>
                                <input type="text" name="username" class="form-control" required
                                       placeholder="Contoh: operator1"
                                       value="<?= htmlspecialchars((string) ($account['username'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Password</label>
                                <input type="password" name="password" class="form-control" required
                                       value="<?= htmlspecialchars((string) ($account['password'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Role Akun</label>
                                <select name="role" id="roleSelect" class="form-control font-weight-bold" required>
                                    <option value="operator" <?= ($account['role'] ?? 'operator') === 'operator' ? 'selected' : '' ?>>
                                        operator (Target Survei Suara Rakyat)
                                    </option>
                                    <option value="admin" <?= ($account['role'] ?? '') === 'admin' ? 'selected' : '' ?>>
                                        admin (Pengelola Dashboard)
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Unit Kerja / Alamat</label>
                            <textarea name="address" rows="2" class="form-control" required
                                      placeholder="Contoh: Loket Pelayanan Terpadu Lt. 1"><?= htmlspecialchars((string) ($account['address'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Email</label>
                                <input type="email" name="email" class="form-control"
                                       placeholder="operator@ikm.local"
                                       value="<?= htmlspecialchars((string) ($account['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">No. HP / WhatsApp</label>
                                <input type="text" name="mobile" class="form-control"
                                       placeholder="0812xxxxxxxx"
                                       value="<?= htmlspecialchars((string) ($account['mobile'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" />
                            </div>
                        </div>

                        <div class="form-row align-items-center">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Foto Profil Operator</label>
                                <?php if (!empty($isEdit) && !empty($account['photo'])): ?>
                                    <div class="mb-2">
                                        <img src="<?= $basePath . '/' . ltrim(htmlspecialchars((string) $account['photo'], ENT_QUOTES, 'UTF-8'), '/') ?>"
                                             alt="Foto Profil"
                                             style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid #1e3a8a;" />
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="photo" accept="image/*" class="form-control-file" />
                            </div>

                            <?php if (empty($isEdit)): ?>
                            <div class="form-group col-md-6" id="initialQuestionCountGroup">
                                <label class="font-weight-bold">Jumlah Pertanyaan Awal (1–10)</label>
                                <select name="question_count" class="form-control font-weight-bold">
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?= $i ?>" <?= $i === 4 ? 'selected' : '' ?>>
                                            <?= $i ?> Pertanyaan Radio (+ 1 Feedback Akhir)
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <small class="form-text text-muted">Dapat diubah kapan saja di menu Pertanyaan Dinamis.</small>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-end pt-3 border-top mt-3" style="gap: 10px;">
                            <a href="<?= $basePath ?>/admin/home" class="btn btn-secondary px-4">Batal</a>
                            <button type="submit" name="submit" value="Submit" class="btn btn-primary px-4 font-weight-bold">
                                <?= !empty($isEdit) ? 'Simpan Perubahan' : 'Tambahkan Operator' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
