<?php
include 'koneksi.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<?php include "header.php"; ?>
<title>Data Karyawan</title>
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
                 <div class="panel-heading">Data Karyawan</div>
                 <div class="panel-body "> 

		<table class="table table-bordered">
			<thead>
				<tr style="background-color: green; color: white;">
					<th style="width: 10%; text-align: center">No.</th>
					<th style="width: 15%; text-align: center">Kode Akses</th>
					<th style="width: 15%; text-align: center">jabatan Akses</th>
					<th style="width: 15%; text-align: center">Nama</th>
					<th style="width: 15%; text-align: center"></th>
					<th style="width: 20%; text-align: center">Aksi</th>
				</tr>
			</thead>
			<tbody>

				<?php
					//koneksi ke database
					include "koneksi.php";

					//baca data karyawan
					$sql = mysqli_query($dbconnect, "select * from karyawan");
					$no = 0;
					while($data = mysqli_fetch_array($sql))
					{
						$no++;
				?>

				<tr>
					<td style="width: 10%; text-align: center"> <?php echo $no; ?> </td>
					<td style="width: 15%; text-align: center"> <?php echo $data['kode']; ?> </td>
					<td style="width: 15%; text-align: center"> <?php echo $data['jabatan']; ?> </td>
					<td style="width: 15%; text-align: center"> <?php echo $data['nama']; ?> </td>
					<td style="width: 15%; text-align: center"> <?php echo $data['']; ?> </td>
					<td style="text-align: center">
						<a href="edit.php?id=<?php echo $data['id']; ?>"><button class="btn btn-success">Edit</button></a> | <a href="hapus.php?id=<?php echo $data['id']; ?>"> <button class="btn btn-success">Hapus</button></a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

		<!-- tombol tambah data karyawan -->
		<a href="tambah.php"> <button class="btn btn-success">Tambah Data ID Card</button></a>
	</div>
</div>
</div>
</div>
</body>
</html>