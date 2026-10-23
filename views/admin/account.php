<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

  <section class="ftco-section ftco-section-2">
    <div class="container">
      <div class="row">
      </div>
    </div>
  </section>

  <div class="row justify-content-center mb-5 pb-5">
    <div class="col-md-10 text-center heading-section ftco-animate">
      <h2 class="mb-2">Account List</h2>
      <span class="subheading">Satisfaction Survey System</span>
      <div class="account"><a href="<?= $basePath ?>/admin/account_add">+ Account</a></div>

      <table class="zebra-table" width="1200" border="1">
        <thead class="huruf">
          <tr>
            <td width="30" align="center"><b><strong>ID</strong></b></td>
            <td width="auto" align="center"><b><strong>Name</strong></b></td>
            <td width="auto" align="center"><b><strong>Address</strong></b></td>
            <td width="auto" align="center"><b><strong>Mobile</strong></b></td>
            <td width="auto" align="center"><b><strong>Email</strong></b></td>
            <td width="auto" align="center"><b><strong>Username</strong></b></td>
            <td width="130" align="center"><b><strong>role</strong></b></td>
            <td colspan="2" align="center"><b><strong>Action</strong></b></td>
          </tr>
        </thead>
        <tbody class="huruf">
          <?php foreach ($users as $user): ?>
            <tr>
              <td width="30"><?= htmlspecialchars((string) $user['id'], ENT_QUOTES, 'UTF-8') ?></td>
              <td width="100"><?= htmlspecialchars((string) $user['name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td width="300"><?= htmlspecialchars((string) $user['address'], ENT_QUOTES, 'UTF-8') ?></td>
              <td width="100"><?= htmlspecialchars((string) $user['mobile'], ENT_QUOTES, 'UTF-8') ?></td>
              <td width="100"><?= htmlspecialchars((string) $user['email'], ENT_QUOTES, 'UTF-8') ?></td>
              <td width="100"><?= htmlspecialchars((string) $user['username'], ENT_QUOTES, 'UTF-8') ?></td>
              <td width="130"><?= htmlspecialchars((string) $user['role'], ENT_QUOTES, 'UTF-8') ?></td>
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

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
