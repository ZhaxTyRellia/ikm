<?php
include"bridge.php";
session_start();
if(($_SESSION['islogin']!=true)||($_SESSION["role"]!='admin')){
  header ('location:logout.php');
}
$id=$_GET['id'];
$delete="delete from user where id='$id'";
$hasil=mysqli_query($con,$delete);
if($delete){
  header('Location: ' . $uri . '../admin/account');
}?>
