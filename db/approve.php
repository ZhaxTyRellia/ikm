<?php

$error = '';

if (isset($_POST['login'])) {
    include "bridge.php";
    $query = mysqli_query($con, "SELECT * from user where (username='" . $_POST['username'] . "') and (password='" . $_POST['password'] . "')");
    $kolom = mysqli_num_rows($query);
    $buff = mysqli_fetch_array($query);
    if ($kolom == 1) {
        session_start();
        $_SESSION['islogin'] = true;
        $_SESSION["username"] = $_POST["username"];
        $_SESSION['password'] = $_POST["password"];
        $_SESSION["id"] = $buff['id'];
        $_SESSION["role"] = $buff['role'];
        if ($buff['role'] == 'admin') {
            header("location:../admin/");
            /*echo "<script>alert('Selamat Datang " . $buff['username'] . "');window.location.href='../admin/';</script>";*/
        } elseif ($buff['role'] == 'operator') {
            header("location:../operator/");
            /*echo "<script>alert('Selamat Datang " . $buff['username'] . "');window.location.href='../operator/';</script>";*/
        } else {
            $error = "Account is not Approve !!!";
        }
    } else {
        $error = "Username or Password wrong !!!";
    }
}
?>