<?php
include 'koneksi.php';
session_start();

// SQL query to update the `mode` column to '1' where `id` is 1
$sql = "UPDATE `kondisi` SET `mode` = '1' WHERE `id` = 1";
if (mysqli_query($dbconnect, $sql)) {
    echo "Mode updated successfully.";
} else {
    echo "Error updating mode: " . mysqli_error($dbconnect);
}
?>

<?php 
	include "koneksi.php";
	$cari = mysqli_query($dbconnect, "select * from user where id='1'");
	$hasil = mysqli_fetch_array($cari);

		//jika tombol simpan diklik
		if(isset($_POST['btnSimpan']))
		{
			//baca isi inputan form
			$nama    = $_POST['nama'];
			$email    = $_POST['email'];
			$jk    = $_POST['jk'];
			$alamat    = $_POST['alamat'];
			$divisi    = $_POST['divisi'];
			$level    = $_POST['level'];
			$jabatan    = $_POST['jabatan'];
			$username    = $_POST['username'];
			$password    = $_POST['password'];	
			$simpan = mysqli_query($dbconnect, "update user set nama='$nama', email='$email', jk='$jk', alamat='$alamat', divisi='$divisi', level='$level', jabatan='$jabatan', username='$username', password='$password' where id='1'");
			if($simpan)
			{
				echo "
					<script>
						alert('Tersimpan');
						location.replace('admin.php');
					</script>
				";
			}
			else
			{
				echo "
					<script>
						alert('Gagal Tersimpan');
						location.replace('admin.php');
					</script>
				";
			}
	
		}
?>

<!DOCTYPE html>
<html>
<head>
<?php include "header.php"; ?>
<title>Data Admin</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="./css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container" id="wrapper">  
	<?php include "menu.php"; ?>  
<div class="card" >
    <div class="panel panel-warning">
                 <div class="panel-heading">Admin</div>
                 <div class="panel-body "> 
		<!-- form input -->
		<form method="POST" class="form-horizontal">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="nama" class="col-sm-4 control-label">Nama Lengkap</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="nama" id="nama" value="<?php echo $hasil['nama']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-4 control-label">Email</label>
						<div class="col-sm-8">
							<input type="email" class="form-control" name="email" id="email" value="<?php echo $hasil['email']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="jk" class="col-sm-4 control-label">Jenis Kelamin</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="jk" id="jk" value="<?php echo $hasil['jk']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="alamat" class="col-sm-4 control-label">Alamat</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="alamat" id="alamat" value="<?php echo $hasil['alamat']; ?>">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="divisi" class="col-sm-4 control-label">Divisi</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="divisi" id="divisi" value="<?php echo $hasil['divisi']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="level" class="col-sm-4 control-label">Level</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="level" id="level" value="<?php echo $hasil['level']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="jabatan" class="col-sm-4 control-label">Jabatan</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="jabatan" id="jabatan" value="<?php echo $hasil['jabatan']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="username" class="col-sm-4 control-label">Username</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="username" id="username" value="<?php echo $hasil['username']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-4 control-label">Password</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="password" id="password" value="<?php echo $hasil['password']; ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" class="btn btn-warning" name="btnSimpan" id="btnSimpan">Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	</div>
	</div>
	</div>
	</div>
</body>
</html>
