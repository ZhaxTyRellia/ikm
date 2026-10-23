<?php

//include koneksi database
include('bridge.php');

//get data dari form
$id = $_POST['id'];
$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$address = $_POST['address'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$role = $_POST['role'];

//query update data ke dalam database berdasarkan ID
$query = "UPDATE user SET name = '$name', username = '$username', password = '$password', address = '$address', email = '$email', mobile = '$mobile', role = '$role' WHERE id = '$id'";

//kondisi pengecekan apakah data berhasil diupdate atau tidak
if ($con->query($query)) {
    echo "<script>alert('Success to Change data'); window.location.href = '../admin/account';</script>";
} else {
    //pesan error gagal update data
    echo "<script>alert('The something is wrong !!!'); window.location.href = '../admin/account_edit';</script>";
}
?>