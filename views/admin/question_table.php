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
        <h2 class="tittle">Edit Question Survey Operator <?= htmlspecialchars($counter, ENT_QUOTES, 'UTF-8') ?></h2><br />
        <form action="<?= $basePath ?>/admin/question_edit?counter=<?= urlencode($counter) ?>" method="post">
          <input type="hidden" name="counter" value="<?= htmlspecialchars($counter, ENT_QUOTES, 'UTF-8') ?>" />
          <table align="center">
            <?php foreach ($questions as $num => $text): ?>
              <tr>
                <td>Pertanyaan <?= (int) $num ?> : </td>
                <td width="auto">
                  <textarea required="required" cols="50" rows="2" name="q<?= (int) $num ?>"><?= htmlspecialchars($text, ENT_QUOTES, 'UTF-8') ?></textarea>
                </td>
              </tr>
            <?php endforeach; ?>
            <tr>
              <td height="68" align="right"></td>
              <td><input type="submit" value="Submit" /> <input type="reset" value="Reset" /></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
