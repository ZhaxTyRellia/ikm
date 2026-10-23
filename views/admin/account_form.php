<section class="ftco-section ftco-section-2">
  <div class="container"><div class="row"></div></div>
</section>

<div class="container-fluid">
  <div class="row justify-content-center mb-5 pb-5">
    <div class="col-md-7 text-center heading-section ftco-animate">
      <h2 class="mb-2"><?= !empty($isEdit) ? 'Edit Identitas Akun / Operator' : 'Tambah Akun / Target Operator' ?></h2>
      <span class="subheading">Lengkapi foto profil dan identitas lengkap operator sebagai wadah suara rakyat</span>

      <form action="<?= $basePath ?>/admin/<?= !empty($isEdit) ? 'account_edit' : 'account_add' ?>" method="post" enctype="multipart/form-data">
        <?php if (!empty($isEdit)): ?>
          <input type="hidden" name="id" value="<?= htmlspecialchars((string) ($account['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" />
        <?php endif; ?>
        <table align="center" border="0" cellpadding="6">
          <?php if (!empty($isEdit) && !empty($account['photo'])): ?>
            <tr>
              <td align="left">Foto Saat Ini</td>
              <td align="left">
                <img src="<?= $basePath . '/' . ltrim(htmlspecialchars((string) $account['photo'], ENT_QUOTES, 'UTF-8'), '/') ?>"
                     alt="Foto Profil"
                     style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid #007bff;">
              </td>
            </tr>
          <?php endif; ?>
          <tr>
            <td align="left" width="160">Foto Profil</td>
            <td align="left" width="260">
              <input type="file" name="photo" accept="image/*">
            </td>
          </tr>
          <tr>
            <td align="left">Nama Lengkap</td>
            <td align="left">
              <input required="required" type="text" name="name" value="<?= htmlspecialchars((string) ($account['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            </td>
          </tr>
          <tr>
            <td align="left">Username / Kode</td>
            <td align="left">
              <input required="required" type="text" name="username" value="<?= htmlspecialchars((string) ($account['username'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            </td>
          </tr>
          <tr>
            <td align="left">Password</td>
            <td align="left">
              <input required="required" type="password" name="password" value="<?= htmlspecialchars((string) ($account['password'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            </td>
          </tr>
          <tr>
            <td align="left">Alamat / Unit Kerja</td>
            <td align="left">
              <textarea cols="30" rows="3" name="address" required="required"><?= htmlspecialchars((string) ($account['address'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
            </td>
          </tr>
          <tr>
            <td align="left">Email</td>
            <td align="left">
              <input type="email" name="email" value="<?= htmlspecialchars((string) ($account['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            </td>
          </tr>
          <tr>
            <td align="left">No. HP / Mobile</td>
            <td align="left">
              <input type="text" name="mobile" value="<?= htmlspecialchars((string) ($account['mobile'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            </td>
          </tr>
          <tr>
            <td align="left">Role</td>
            <td align="left">
              <select name="role" id="role" required="required">
                <option value="operator" <?= ($account['role'] ?? 'operator') === 'operator' ? 'selected' : '' ?>>operator (Target Survei Suara Rakyat)</option>
                <option value="admin" <?= ($account['role'] ?? '') === 'admin' ? 'selected' : '' ?>>admin (Pengelola Sistem)</option>
              </select>
            </td>
          </tr>
          <tr>
            <td></td>
            <td align="left" height="90">
              <input type="submit" value="Submit" name="submit" />
              <?php if (!empty($isEdit)): ?>
                <input type="reset" value="Reset" />
              <?php endif; ?>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
