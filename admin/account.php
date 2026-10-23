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
      <a class="navbar-brand" href="home">home</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
        aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="data" class="nav-link">Data</a></li>
          <li class="nav-item"><a href="question" class="nav-link">Question</a></li>
          <li class="nav-item active"><a href="account" class="nav-link">Account</a></li>

          <li class="nav-item cta"><a href="../db/logout"
              class="nav-link" data-target="#modalRequest"><span>logout</span></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->
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
      <div class="account"><a href="account_add">+ Account</a></div>

      <?php
      // $nama=$_SESSION['nama'];
      include "../db/bridge.php";
      $select = "select * from user";
      $hasil = mysqli_query($con, $select);

      ?>

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

          <?php
          while ($buff = mysqli_fetch_array($hasil)) {
            ?>

            <tr>
              <td width="30"><?php echo $buff['id']; ?></td>
              <td width="100"><?php echo $buff['name']; ?></td>
              <td width="300"><?php echo $buff['address']; ?></td>
              <td width="100"><?php echo $buff['mobile']; ?></td>
              <td width="100"><?php echo $buff['email']; ?></td>
              <td width="100"><?php echo $buff['username']; ?></td>
              <td width="130"><?php echo $buff['role']; ?></td>
              <td width="70"><a href="account_edit?id=<?php echo $buff['id']; ?>">Edit</a></td>
              <td width="70"><a onclick="return confirm('Are you sure ?');"
                  href="../db/delete?id=<?php echo $buff['id']; ?>">Delete</a></td>
            </tr>

            <?php
          }
          ;
          mysqli_close($con);
          ?>
        </tbody>
      </table><br />
    </div>
  </div>



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