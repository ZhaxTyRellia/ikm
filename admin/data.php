<!DOCTYPE html>
<?php
session_start();
if (($_SESSION['islogin'] != true) || ($_SESSION["role"] != 'admin')) {
  header('location:../index');
}
include "../db/bridge.php";
include "../admin/main.php";

?>

<html lang="en">

<body>
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="home">Home</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
        aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active"><a href="data" class="nav-link">Data</a></li>
          <li class="nav-item"><a href="question" class="nav-link">Question</a></li>
          <li class="nav-item"><a href="account" class="nav-link">Account</a></li>
          <li class="nav-item cta"><a href="../db/logout"
              class="nav-link" data-target="modalRequest"><span>logout</span></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <section class="ftco-section ftco-work">
    <div class="container-fluid">
      <div class="row justify-content-center mb-5 pb-5">
        <div class="col-md-7 text-center heading-section ftco-animate">
          <h1 class="mb-4">Hasil Survey Data</h1>
          <span class="subheading">Satisfaction Survey System</span>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 ftco-animate">
          <div class="work-entry">
            <a href="data_table?counter=1" class="survey">
              <div class="text d-flex justify-content-center align-items-center">
                <div class="p-3">
                  <h3>operator 1</h3>
                  <span>Hasil data survey dalam lingkup menyeluruh,<br />Buka untuk melihat hasil survey skala global.
                  </span>
                </div>
              </div>
            </a>
          </div>
        </div>
        <!--
        <div class="col-md-4 ftco-animate">
          <div class="work-entry">
            <a href="data_table?counter=xxxxxxx" class="survey">
              <div class="text d-flex justify-content-center align-items-center">
                <div class="p-3">
                  <h3>example</h3>
                  <span>Hasil data survey dalam lingkup menyeluruh,<br />Buka untuk melihat hasil survey skala global.
                  </span>
                </div>
              </div>
            </a>
          </div>
        </div>
        -->
      </div>
    </div>
  </section>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/jquery-migrate-3.0.1.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/jquery.easing.1.3.js"></script>
  <script src="../js/jquery.waypoints.min.js"></script>
  <script src="../js/jquery.stellar.min.js"></script>
  <script src="../js/owl.carousel.min.js"></script>
  <script src="../js/jquery.magnific-popup.min.js"></script>
  <script src="../js/aos.js"></script>
  <script src="../js/jquery.animateNumber.min.js"></script>
  <script src="../js/bootstrap-datepicker.js"></script>
  <script src="../js/jquery.timepicker.min.js"></script>
  <script src="../js/scrollax.min.js"></script>
  <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="../js/google-map.js"></script>
  <script src="../js/mainoperator.js"></script>
</body>

</html>