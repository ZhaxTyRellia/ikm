<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

  <section class="ftco-section ftco-section-2">
    <div class="container">
      <div class="row">
      </div>
    </div>
  </section>

  <div class="container-fluid">
    <div class="row justify-content-center mb-5 pb-5">
      <div class="col-md-7 text-center heading-section ftco-animate">
        <h2 class="mb-2"><?= !empty($isEdit) ? 'Edit Data Account' : 'Tambah Akun' ?></h2>
        <span class="subheading">Satisfaction Survey System</span>

        <form action="<?= $basePath ?>/admin/<?= !empty($isEdit) ? 'account_edit' : 'account_add' ?>" method="post">
          <?php if (!empty($isEdit)): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars((string) $account['id'], ENT_QUOTES, 'UTF-8') ?>" />
          <?php endif; ?>
          <table align="center" border="0">
            <tr>
              <td align="left" width="150"><?= !empty($isEdit) ? 'Full Name' : 'Name' ?></td>
              <td align="left" width="200">
                <input type="text" name="name" value="<?= htmlspecialchars((string) ($account['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
              </td>
            </tr>
            <tr>
              <td align="left">username</td>
              <td align="left">
                <input required="required" type="text" name="username" value="<?= htmlspecialchars((string) ($account['username'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
              </td>
            </tr>
            <tr>
              <td align="left">password</td>
              <td align="left">
                <input required="required" type="password" name="password" value="<?= htmlspecialchars((string) ($account['password'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
              </td>
            </tr>
            <tr>
              <td align="left">Address</td>
              <td align="left">
                <textarea cols="30" rows="3" name="address"><?= htmlspecialchars((string) ($account['address'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
              </td>
            </tr>
            <tr>
              <td align="left">email</td>
              <td align="left">
                <input type="text" name="email" value="<?= htmlspecialchars((string) ($account['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
              </td>
            </tr>
            <tr>
              <td align="left">mobile Number</td>
              <td align="left">
                <input type="text" name="mobile" value="<?= htmlspecialchars((string) ($account['mobile'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
              </td>
            </tr>
            <tr>
              <td align="left">role</td>
              <td align="left">
                <select name="role" id="role" required="required">
                  <option value=""></option>
                  <option value="admin" <?= ($account['role'] ?? '') === 'admin' ? 'selected' : '' ?>>admin</option>
                  <option value="operator" <?= ($account['role'] ?? '') === 'operator' ? 'selected' : '' ?>>operator</option>
                </select>
              </td>
            </tr>
            <tr>
              <td></td>
              <td align="left" height="130">
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

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
