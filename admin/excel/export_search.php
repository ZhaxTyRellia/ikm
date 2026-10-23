<!DOCTYPE html>
<?php
session_start();
if (($_SESSION['islogin'] != true) || ($_SESSION["role"] != 'admin')) {
  header('location:../../index.php');
}
$awal = $_GET['awal'];
$akhir = $_GET['akhir'];
include "../../db/bridge.php";
$counter = $_GET['counter'];
?>
<html lang="en">

<head>
  <title>Pusat Perpustakaan - Visitors Satisfaction Survey</title>
</head>

<body>

  <?php
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=survey_Operator$counter/$awal/$akhir.xls");
  ?>
  <h2 align="center"><strong>Data Survey Operator <?php echo $counter ?></strong></h2><br />

  <table border="1">
    <tr>
      <td width="700" align="center"><b><strong>Pertanyaan</strong></b></td>
      <td width="200" align="center"><b><strong>tidak puas</strong></b></td>
      <td width="200" align="center"><b><strong>kurang puas</strong></b></td>
      <td width="100" align="center"><b><strong>puas</strong></b></td>
      <td width="100" align="center"><b><strong>sangat puas</strong></b></td>
    </tr>
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
  </table>
  <br />

  <h2 align="center"><strong>Kritik & Saran</strong></h2><br />
  <table width="830" border="1">
    <tr>
      <td width="500" align="center"><b><strong>Kritik & Saran</strong></b></td>
      <td width="100" align="center"><b><strong>tanggal</strong></b></td>
      <td width="100" align="center"><b><strong><?php
      $sql = "SELECT * from question where id_text='$counter+a'";
      $query = mysqli_query($con, $sql);
      $buff = mysqli_fetch_array($query);
      echo $buff['text']; ?></strong></b></td>
      <!-- <td width="100"align="center"><b><strong>cukup</strong></b></td> -->
      <td width="100" align="center"><b><strong><?php
      $sql = "SELECT * from question where id_text='$counter+b'";
      $query = mysqli_query($con, $sql);
      $buff = mysqli_fetch_array($query);
      echo $buff['text']; ?></strong></b></td>
      <!-- <td width="100"align="center"><b><strong>cukup</strong></b></td> -->
      <td width="100" align="center"><b><strong><?php
      $sql = "SELECT * from question where id_text='$counter+c'";
      $query = mysqli_query($con, $sql);
      $buff = mysqli_fetch_array($query);
      echo $buff['text']; ?></strong></b></td>
      <!-- <td width="100"align="center"><b><strong>cukup</strong></b></td> -->
      <td width="100" align="center"><b><strong><?php
      $sql = "SELECT * from question where id_text='$counter+d'";
      $query = mysqli_query($con, $sql);
      $buff = mysqli_fetch_array($query);
      echo $buff['text']; ?></strong></b></td>
      <!-- <td width="100"align="center"><b><strong>cukup</strong></b></td> -->
      <td width="100" align="center"><b><strong><?php
      $sql = "SELECT * from question where id_text='$counter+e'";
      $query = mysqli_query($con, $sql);
      $buff = mysqli_fetch_array($query);
      echo $buff['text']; ?></strong></b></td>
      <!-- <td width="100"align="center"><b><strong>cukup</strong></b></td> -->
      <td width="100" align="center"><b><strong><?php
      $sql = "SELECT * from question where id_text='$counter+f'";
      $query = mysqli_query($con, $sql);
      $buff = mysqli_fetch_array($query);
      echo $buff['text']; ?></strong></b></td>
      <!-- <td width="100"align="center"><b><strong>cukup</strong></b></td> -->
      <td width="100" align="center"><b><strong><?php
      $sql = "SELECT * from question where id_text='$counter+g'";
      $query = mysqli_query($con, $sql);
      $buff = mysqli_fetch_array($query);
      echo $buff['text']; ?></strong></b></td>
      <!-- <td width="100"align="center"><b><strong>cukup</strong></b></td> -->
      <td width="100" align="center"><b><strong><?php
      $sql = "SELECT * from question where id_text='$counter+h'";
      $query = mysqli_query($con, $sql);
      $buff = mysqli_fetch_array($query);
      echo $buff['text']; ?></strong></b></td>
      <!-- <td width="100"align="center"><b><strong>cukup</strong></b></td> -->
      <td width="100" align="center"><b><strong><?php
      $sql = "SELECT * from question where id_text='$counter+i'";
      $query = mysqli_query($con, $sql);
      $buff = mysqli_fetch_array($query);
      echo $buff['text']; ?></strong></b></td>
    </tr>

    <?php
    $pilih = "select * from data where counter='$counter' && suggestion != ''";
    $hasil = mysqli_query($con, $pilih);
    while ($buff = mysqli_fetch_array($hasil)) {
      ?>
      <tr>
        <td width="500"><?php echo $buff['suggestion']; ?></td>
        <td width="100"><?php echo $buff['time']; ?></td>
        <td width="100"><?php echo $buff['q1']; ?></td>
        <td width="100"><?php echo $buff['q2']; ?></td>
        <td width="100"><?php echo $buff['q3']; ?></td>
        <td width="100"><?php echo $buff['q4']; ?></td>
        <td width="100"><?php echo $buff['q5']; ?></td>
        <td width="100"><?php echo $buff['q6']; ?></td>
        <td width="100"><?php echo $buff['q7']; ?></td>
        <td width="100"><?php echo $buff['q8']; ?></td>
        <td width="100"><?php echo $buff['q9']; ?></td>
      </tr>
      <?php
    }
    ;
    mysqli_close($con);
    ?>

  </table>

</body>

</html>