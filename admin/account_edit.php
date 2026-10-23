<!DOCTYPE html>

<?php
session_start();
if (($_SESSION['islogin'] != true) || ($_SESSION["role"] != 'admin')) {
  header('location:../index');
}
include '../db/bridge.php';
$id = $_GET['id'];
$sql = "SELECT * FROM user WHERE id='$id'";
$que = mysqli_query($con, $sql);

while ($data = mysqli_fetch_array($que)) {
  ?>


  <html lang="en">

  <head>
    <title>Edit Account</title>
    <link href="../css/style.css" type="text/css" rel="stylesheet" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/gif" href="../images/favicon.png" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700" rel="stylesheet">

    <link rel="stylesheet" href="../css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="../css/animate.css">

    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../css/magnific-popup.css">

    <link rel="stylesheet" href="../css/aos.css">

    <link rel="stylesheet" href="../css/ionicons.min.css">

    <link rel="stylesheet" href="../css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../css/jquery.timepicker.css">


    <link rel="stylesheet" href="../css/flaticon.css">
    <link rel="stylesheet" href="../css/icomoon.css">
    <link rel="stylesheet" href="../css/style2.css">
  </head>

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
    <div class="container-fluid">
      <div class="row justify-content-center mb-5 pb-5">
        <div class="col-md-7 text-center heading-section ftco-animate">
          <h2 class="mb-2">Edit Data Account</h2>
          <span class="subheading">Satisfaction Survey System</span>

          <form action="../db/update" method="post">
            <table align="center" border="0">
              <input type="hidden" name="id" value="<?php echo $data['id']; ?> " />
              <tr>
                <td align="left">Full Name</td>
                <td align="left"><input type="text" name="name" value="<?php echo $data['name']; ?>"></td>
              </tr>
              <tr>
                <td align="left">username</td>
                <td align="left"><input type="text" name="username" value="<?php echo $data['username']; ?>"></td>
              </tr>
              <tr>
                <td align="left">password</td>
                <td align="left"><input type="password" name="password" value="<?php echo $data['password']; ?>"></td>
              </tr>
              <tr>
                <td align="left">address</td>
                <td align="left"><textarea cols=30 rows=3 name="address"><?php echo $data['address']; ?></textarea></td>
              </tr>
              <tr>
                <td align="left">email</td>
                <td align="left"><input type="text" name="email" value="<?php echo $data['email']; ?>"></td>
              </tr>
              <tr>
                <td align="left">mobile number</td>
                <td align="left"><input type="text" name="mobile" value="<?php echo $data['mobile']; ?>"></td>
              </tr>
              <tr>
                <td align="left">role</td>
                <td align="left"><select name="role" id="role" required=required>
                    <option value="<?php echo $data['role']; ?>"><?php echo $data['role']; ?></option>
                    <option value="admin">admin</option>
                    <option value="operator">operator</option>
                  </select></td>
              </tr>
              <tr>
                <td></td>
                <td align="left" height="130"><input type="submit" value="Submit" /> <input type="reset"
                    value="Reset" />
                </td>
              </tr>
            </table>
          </form>
        </div>
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
  <?php
}
;
mysqli_close($con);
?>