<?php
include 'koneksi.php';
session_start();
?>
<?php
mysqli_query($dbconnect, "delete from scan");
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>