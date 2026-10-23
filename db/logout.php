<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['islogin']);
unset($_SESSION['id']);
unset($_SESSION['role']);
session_destroy();
header('Location: ' . $uri . '../');
mysqli_close($con);
?>