<!DOCTYPE html>
<?php
session_start();
if (($_SESSION['islogin'] != true) || ($_SESSION["role"] != 'admin')) {
  header('location:../index');
}
include "../db/bridge.php";
$awal = $_POST['awal'];
$akhir = $_POST['akhir'];
$counter = $_GET['counter'];
?>
<html lang="en">

<head>
  <title>Pusat Perpustakaan - Visitors Satisfaction Survey</title>
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
    <div class="col-md-7 text-center heading-section ftco-animate">
      <h2 align="center"><strong>Data Survey <?php echo $counter ?></strong></h2><br />
      <form action="export_search?counter=<?php echo $counter ?>" method="post" name="postform">
        <table border="0" align="center">
          <tr>
            <td width="250"><b>Dari Tanggal</b></td>
            <td width="250">: <input type="date" name="awal" size="16" required value="<?php echo $awal; ?>" />
            </td>
            <td width="250"><b>Sampai Tanggal</b></td>
            <td width="250">: <input type="date" name="akhir" size="16" required value="<?php echo $akhir; ?>" />
            </td>
            <td width="125"><input type="submit" value="Cari" name="pencarian" /></td>
            <td width="125"><input type="reset" value="Reset" /></td>
            <td><a
                href="excel/export_search.php?awal=<?php echo $awal; ?>&akhir=<?php echo $akhir; ?>&counter=<?php echo $counter; ?>"
                class="export">Export</a></td>
          </tr>
        </table>
      </form>

      <table border="1" style="background-color:yellow;">
        <thead>
          <tr>
            <td width="700" align="center"><b><strong>Pertanyaan</strong></b></td>
            <td width="100" align="center"><b><strong>Tidak Puas</strong></b></td>
            <td width="100" align="center"><b><strong>Kurang Puas</strong></b></td>
            <!-- <td width="100"align="center"><b><strong>cukup</strong></b></td> -->
            <td width="100" align="center"><b><strong>Puas</strong></b></td>
            <td width="100" align="center"><b><strong>Sangat Puas</strong></b></td>
          </tr>
        </thead>


        <tbody>
          <tr>
            <td width="700"><?php
            $sql = "SELECT text from question where id_text='$counter+a'";
            $query = mysqli_query($con, $sql);
            $buff = mysqli_fetch_array($query);
            echo $buff['text']; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q1) AS jumlah FROM `data` WHERE q1='tidak puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q1) AS jumlah FROM `data` WHERE q1='kurang puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>

            <td width="100"><?php
            $sql = "SELECT COUNT(q1) AS jumlah FROM `data` WHERE q1='puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q1) AS jumlah FROM `data` WHERE q1='sangat puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
          </tr>
          <tr>
            <td width="700"><?php
            $sql = "SELECT * from question where id_text='$counter+b'";
            $query = mysqli_query($con, $sql);
            $buff = mysqli_fetch_array($query);
            echo $buff['text']; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q2) AS jumlah FROM `data` WHERE q2='tidak puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q2) AS jumlah FROM `data` WHERE q2='kurang puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>

            <td width="100"><?php
            $sql = "SELECT COUNT(q2) AS jumlah FROM `data` WHERE q2='puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q2) AS jumlah FROM `data` WHERE q2='sangat puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
          </tr>
          <tr>
            <td width="700"><?php
            $sql = "SELECT text from question where id_text='$counter+c'";
            $query = mysqli_query($con, $sql);
            $buff = mysqli_fetch_array($query);
            echo $buff['text']; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q3) AS jumlah FROM `data` WHERE q3='tidak puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q3) AS jumlah FROM `data` WHERE q3='kurang puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>

            <td width="100"><?php
            $sql = "SELECT COUNT(q3) AS jumlah FROM `data` WHERE q3='puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q3) AS jumlah FROM `data` WHERE q3='sangat puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
          </tr>
          <tr>
            <td width="700"><?php
            $sql = "SELECT text from question where id_text='$counter+d'";
            $query = mysqli_query($con, $sql);
            $buff = mysqli_fetch_array($query);
            echo $buff['text']; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q4) AS jumlah FROM `data` WHERE q4='tidak puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q4) AS jumlah FROM `data` WHERE q4='kurang puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>

            <td width="100"><?php
            $sql = "SELECT COUNT(q4) AS jumlah FROM `data` WHERE q4='puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q4) AS jumlah FROM `data` WHERE q4='sangat puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
          </tr>
          <tr>
            <td width="700"><?php
            $sql = "SELECT text from question where id_text='$counter+e'";
            $query = mysqli_query($con, $sql);
            $buff = mysqli_fetch_array($query);
            echo $buff['text']; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q5) AS jumlah FROM `data` WHERE q5='tidak puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q5) AS jumlah FROM `data` WHERE q5='kurang puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>

            <td width="100"><?php
            $sql = "SELECT COUNT(q5) AS jumlah FROM `data` WHERE q5='puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q5) AS jumlah FROM `data` WHERE q5='sangat puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
          </tr>
          <tr>
            <td width="700"><?php
            $sql = "SELECT text from question where id_text='$counter+f'";
            $query = mysqli_query($con, $sql);
            $buff = mysqli_fetch_array($query);
            echo $buff['text']; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q6) AS jumlah FROM `data` WHERE q6='tidak puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q6) AS jumlah FROM `data` WHERE q6='kurang puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>

            <td width="100"><?php
            $sql = "SELECT COUNT(q6) AS jumlah FROM `data` WHERE q6='puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q6) AS jumlah FROM `data` WHERE q6='sangat puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
          </tr>
          <tr>
            <td width="700"><?php
            $sql = "SELECT text from question where id_text='$counter+g'";
            $query = mysqli_query($con, $sql);
            $buff = mysqli_fetch_array($query);
            echo $buff['text']; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q7) AS jumlah FROM `data` WHERE q7='tidak puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q7) AS jumlah FROM `data` WHERE q7='kurang puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>

            <td width="100"><?php
            $sql = "SELECT COUNT(q7) AS jumlah FROM `data` WHERE q7='puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q7) AS jumlah FROM `data` WHERE q7='sangat puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
          </tr>
          <tr>
            <td width="700"><?php
            $sql = "SELECT text from question where id_text='$counter+h'";
            $query = mysqli_query($con, $sql);
            $buff = mysqli_fetch_array($query);
            echo $buff['text']; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q8) AS jumlah FROM `data` WHERE q8='tidak puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q8) AS jumlah FROM `data` WHERE q8='kurang puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>

            <td width="100"><?php
            $sql = "SELECT COUNT(q8) AS jumlah FROM `data` WHERE q8='puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q8) AS jumlah FROM `data` WHERE q8='sangat puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
          </tr>
          <tr>
            <td width="700"><?php
            $sql = "SELECT text from question where id_text='$counter+i'";
            $query = mysqli_query($con, $sql);
            $buff = mysqli_fetch_array($query);
            echo $buff['text']; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q9) AS jumlah FROM `data` WHERE q9='tidak puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q9) AS jumlah FROM `data` WHERE q9='kurang puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>

            <td width="100"><?php
            $sql = "SELECT COUNT(q9) AS jumlah FROM `data` WHERE q9='puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
            <td width="100"><?php
            $sql = "SELECT COUNT(q9) AS jumlah FROM `data` WHERE q9='sangat puas' && counter='$counter'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($query);
            echo "{$result['jumlah']}"; ?></td>
          </tr>
        </tbody>
      </table>
      <br />

      <h2 align="center"><strong>Kritik & Saran</strong></h2><br />
      <table border="1" style="background-color:yellow;">
        <thead>
          <tr>
            <td width="170" align="center"><b><strong>date</strong></b></td>
            <td width="100" align="center"><b><strong>ask 1</strong></b></td>
            <td width="100" align="center"><b><strong>ask 2</strong></b></td>
            <td width="100" align="center"><b><strong>ask 3</strong></b></td>
            <td width="100" align="center"><b><strong>ask 4</strong></b></td>
            <td width="100" align="center"><b><strong>ask 5</strong></b></td>
            <td width="100" align="center"><b><strong>ask 6</strong></b></td>
            <td width="100" align="center"><b><strong>ask 7</strong></b></td>
            <td width="100" align="center"><b><strong>ask 8</strong></b></td>
            <td width="100" align="center"><b><strong>ask 9</strong></b></td>
            <td width="700" align="center"><b><strong>Kritik & Saran</strong></b></td>
          </tr>
        </thead>
        <tbody>
          <?php
          $pilih = "select * from data where counter='$counter' && suggestion!=''";
          $hasil = mysqli_query($con, $pilih);
          while ($buff = mysqli_fetch_array($hasil)) {
            ?>
            <tr>
              <td width="170"><?php echo $buff['time']; ?></td>
              <td width="100"><?php echo $buff['q1']; ?></td>
              <td width="100"><?php echo $buff['q2']; ?></td>
              <td width="100"><?php echo $buff['q3']; ?></td>
              <td width="100"><?php echo $buff['q4']; ?></td>
              <td width="100"><?php echo $buff['q5']; ?></td>
              <td width="100"><?php echo $buff['q6']; ?></td>
              <td width="100"><?php echo $buff['q7']; ?></td>
              <td width="100"><?php echo $buff['q8']; ?></td>
              <td width="100"><?php echo $buff['q9']; ?></td>
              <td width="700"><?php echo $buff['suggestion']; ?></td>
            </tr>
            <?php
          }
          ;
          mysqli_close($con);
          ?>
        </tbody>
      </table>



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