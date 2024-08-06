<!-- proses penyimpanan -->
<?php
include 'koneksi.php';
session_start();
?>

<?php 
	include "koneksi.php";

	//baca ID data yang akan di edit
	$id = $_GET['id'];

	//baca data karyawan berdasarkan id
	$cari = mysqli_query($dbconnect, "select * from karyawan where id='$id'");
	$hasil = mysqli_fetch_array($cari);


	//jika tombol simpan diklik
	if(isset($_POST['btnSimpan']))
	{
		//baca isi inputan form
		$kode    = $_POST['kode'];
		$jabatan    = $_POST['jabatan'];
		$nama    = $_POST['nama'];

		$simpan = mysqli_query($dbconnect, "update karyawan set kode='$kode', jabatan='$jabatan', nama='$nama' where id='$id'");
		//jika berhasil tersimpan, tampilkan pesan Tersimpan,
		//kembali ke data karyawan
		if($simpan)
		{
			echo "
				<script>
					alert('Tersimpan');
					location.replace('datakartu.php');
				</script>
			";
		}
		else
		{
			echo "
				<script>
					alert('Gagal Tersimpan');
					location.replace('datakartu.php');
				</script>
			";
		}

	}
?>

<!DOCTYPE html>
<html>
<head>
<?php include "header.php"; ?>
<title>Edit Data Karyawan</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="./css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container" id="wrapper">  
	<?php include "menu.php"; ?>  
<div class="card" >
    <div class="panel panel-success">
                 <div class="panel-heading">Edit Data Karyawan</div>
                 <div class="panel-body "> 
		<!-- form input -->
		<form method="POST">
		<div class="form-group">
				<label>Kode jabatan</label>
				<input type="text" name="kode" id="kode"  class="form-control" style="width: 400px" value="<?php echo $hasil['kode']; ?>">
			</div>

			<div class="form-group">
				<label>jabatan Akses</label>
				<input class="form-control" name="jabatan" id="jabatan" style="width: 400px"  value="<?php echo $hasil['jabatan']; ?>">
			</div>
			<div class="form-group">
				<label>Nama</label>
				<input type="text" class="form-control" name="nama" id="nama" style="width: 400px"  value="<?php echo $hasil['nama']; ?>">  
			</div>
			<button class="btn btn-success" name="btnSimpan" id="btnSimpan">Simpan</button>
		</form>
	</div>
	</div>
	</div>
	</div>
</body>
</html>