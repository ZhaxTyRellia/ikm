<section class="ftco-section ftco-work">
  <div class="container-fluid">
    <div class="row justify-content-center mb-5 pb-5">
      <div class="col-md-7 text-center heading-section ftco-animate">
        <h1 class="mb-4"><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h1>
        <span class="subheading">Satisfaction Survey System</span>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 ftco-animate">
        <div class="work-entry">
          <a href="<?= $basePath . $targetRoute ?>" class="survey">
            <div class="text d-flex justify-content-center align-items-center">
              <div class="p-3">
                <h3><?= htmlspecialchars($cardTitle, ENT_QUOTES, 'UTF-8') ?></h3>
                <span><?= $cardDescription ?></span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
