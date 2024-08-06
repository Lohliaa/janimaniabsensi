<?php
	include 'koneksi.php';
    $json=array();
	$kode = $_POST['kode'];
	//kosongkan tabel 
	mysqli_query($dbconnect, "delete from qrcode");

   mysqli_query($dbconnect, "insert into qrcode(kode)values('$kode')");
 header('Location: ' . $_SERVER['HTTP_REFERER']);
?>