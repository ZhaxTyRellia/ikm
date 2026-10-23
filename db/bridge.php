<!-- MTProject -->
 
<?php
$host = "localhost";
$userdb = "root";
$passdb = "";
$db = "survey";
$con = mysqli_connect($host, $userdb, $passdb, $db);
if (!$con) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>