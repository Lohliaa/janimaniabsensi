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

	//baca ID data yang akan di edit
	$id = $_GET['id'];

	//baca data karyawan berdasarkan id
	$query = mysqli_query($dbconnect, "select * from karyawan where id='$id'");
	$data		=	$query->fetch_row();



	//jika tombol simpan diklik
	
		//baca isi inputan form
		if ($data[5] == 0) {
            $simpan = mysqli_query($dbconnect, "update karyawan set status=1 where id='$id'");
           
			echo "
				<script>
					
					location.replace('datakartu.php');
				</script>
			";
		

        } else {
            $simpan = mysqli_query($dbconnect, "update karyawan set status=0 where id='$id'");

            echo "
            <script>
                
                location.replace('datakartu.php');
            </script>
        ";

        }
        
		
		//jika berhasil tersimpan, tampilkan pesan Tersimpan,
		//kembali ke data karyawan
		
	
?>
