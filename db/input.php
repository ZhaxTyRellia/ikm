<?php
session_start();
$id = $_GET['id'];
include "bridge.php";
$user = $_SESSION["id"];
if ($_POST['q1'] == "logout") {
	echo "<script>window.location.href='logout.php';</script>";
} else {
	$mysql = "INSERT INTO data
(id_user, counter, q1, q2, q3, q4, q5, q6, q7, q8, q9, suggestion) VALUES
('$user', '$id', '$_POST[q1]','$_POST[q2]','$_POST[q3]','$_POST[q4]','$_POST[q5]','$_POST[q6]','$_POST[q7]','$_POST[q8]','$_POST[q9]','$_POST[suggestion]')";

	if (!mysqli_query($con, $mysql))
		die(mysqli_error($con));

	echo "<script>alert('Terima Kasih anda telah berpartisipasi untuk memberikan saran dan masukan yang terbaik bagi Kami.');window.location.href='../operator/survey';</script>";
}
mysqli_close($con);
?>