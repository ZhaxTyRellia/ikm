<?php
include "bridge.php";
session_start();
if (($_SESSION['islogin'] != true) || ($_SESSION["role"] != 'admin')) {
  header('location:logout.php');
}
$counter = $_GET['counter'];
if (isset($_POST['counter'])) {
  $edit = "update question set text='$_POST[q1]' where id_text='$counter+a'";
  $edit2 = "update question set text='$_POST[q2]' where id_text='$counter+b'";
  $edit3 = "update question set text='$_POST[q3]' where id_text='$counter+c'";
  $edit4 = "update question set text='$_POST[q4]' where id_text='$counter+d'";
  $edit5 = "update question set text='$_POST[q5]' where id_text='$counter+e'";
  $edit6 = "update question set text='$_POST[q6]' where id_text='$counter+f'";
  $edit7 = "update question set text='$_POST[q7]' where id_text='$counter+g'";
  $edit8 = "update question set text='$_POST[q8]' where id_text='$counter+h'";
  $edit9 = "update question set text='$_POST[q9]' where id_text='$counter+i'";
  $hasil = mysqli_query($con, $edit);
  $hasil2 = mysqli_query($con, $edit2);
  $hasil3 = mysqli_query($con, $edit3);
  $hasil4 = mysqli_query($con, $edit4);
  $hasil5 = mysqli_query($con, $edit5);
  $hasil6 = mysqli_query($con, $edit6);
  $hasil7 = mysqli_query($con, $edit7);
  $hasil8 = mysqli_query($con, $edit8);
  $hasil9 = mysqli_query($con, $edit9);
  if ($hasil9) {
    header('Location: ' . $uri . '../admin/question');
  }
} ?>