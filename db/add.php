<?php

include 'bridge.php';

$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$address = $_POST['address'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$role = $_POST['role'];


$sql = "INSERT INTO user VALUES('', '$name', '$username', '$password', '$address', '$email', '$mobile', '$role')";
$que = mysqli_query($con, $sql);
//peyimpanan
if ($que) //jika berhasil
{
    header('Location: ' . $uri . '../admin/account');
} else //jika gagal
{
    echo
        "
            <script type='text/javascript'>
                alert('account failed to create !!!');
                window.location='../admin/account_add';
            </script>
        ";
}
//penyimpanan

?>

<!--password_hash($_POST['password'], PASSWORD_DEFAULT);-->