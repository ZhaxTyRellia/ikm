<section class="ftco-section ftco-section-2">
  <div class="container"><div class="row"></div></div>
</section>

<div class="row justify-content-center mb-5 pb-5">
  <div class="col-md-11 text-center heading-section ftco-animate">
    <h2 class="mb-2">Account &amp; Operator Target List</h2>
    <span class="subheading">Kelola akun Admin serta identitas lengkap Operator penerima suara rakyat</span>
    <div class="account my-3"><a href="<?= $basePath ?>/admin/account_add" class="btn btn-primary px-4">+ Tambah Akun / Operator</a></div>

    <table class="zebra-table" width="1200" border="1" align="center">
      <thead class="huruf">
        <tr>
          <td width="40" align="center"><b><strong>ID</strong></b></td>
          <td width="80" align="center"><b><strong>Foto</strong></b></td>
          <td width="auto" align="center"><b><strong>Nama Lengkap</strong></b></td>
          <td width="auto" align="center"><b><strong>Alamat / Unit</strong></b></td>
          <td width="auto" align="center"><b><strong>No. HP</strong></b></td>
          <td width="auto" align="center"><b><strong>Email</strong></b></td>
          <td width="auto" align="center"><b><strong>Username</strong></b></td>
          <td width="100" align="center"><b><strong>Role</strong></b></td>
          <td colspan="2" align="center"><b><strong>Action</strong></b></td>
        </tr>
      </thead>
      <tbody class="huruf">
        <?php foreach ($users as $user): ?>
          <?php
          $photoUrl = !empty($user['photo'])
              ? $basePath . '/' . ltrim((string) $user['photo'], '/')
              : $basePath . '/images/logo.png';
          ?>
          <tr>
            <td width="40" align="center"><?= htmlspecialchars((string) $user['id'], ENT_QUOTES, 'UTF-8') ?></td>
            <td width="80" align="center">
              <img src="<?= htmlspecialchars($photoUrl, ENT_QUOTES, 'UTF-8') ?>"
                   alt="Foto"
                   style="width:50px;height:50px;border-radius:50%;object-fit:cover;border:2px solid #007bff;">
            </td>
            <td width="160"><?= htmlspecialchars((string) $user['name'], ENT_QUOTES, 'UTF-8') ?></td>
            <td width="260"><?= htmlspecialchars((string) $user['address'], ENT_QUOTES, 'UTF-8') ?></td>
            <td width="120"><?= htmlspecialchars((string) $user['mobile'], ENT_QUOTES, 'UTF-8') ?></td>
            <td width="150"><?= htmlspecialchars((string) $user['email'], ENT_QUOTES, 'UTF-8') ?></td>
            <td width="110"><?= htmlspecialchars((string) $user['username'], ENT_QUOTES, 'UTF-8') ?></td>
            <td width="100"><?= htmlspecialchars((string) $user['role'], ENT_QUOTES, 'UTF-8') ?></td>
            <td width="70"><a href="<?= $basePath ?>/admin/account_edit?id=<?= urlencode((string) $user['id']) ?>">Edit</a></td>
            <td width="70">
              <a onclick="return confirm('Are you sure ?');"
                 href="<?= $basePath ?>/admin/account_delete?id=<?= urlencode((string) $user['id']) ?>">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table><br />
  </div>
</div>
