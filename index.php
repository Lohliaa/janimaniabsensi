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

<!DOCTYPE html>
<html>
<head>
    <?php include "header.php"; ?>
    <title>Rekap Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap.min.js"></script>

    <!-- scanning membaca kartu RFID -->
    <script type="text/javascript">
        $(document).ready(function() {
            setInterval(function(){
                $("#cekkartu").load('bacakartu.php');        
            }, 1000);

            $('#rekapTable').DataTable();
        }); 
    </script>
</head>
<body>
<div class="container" id="wrapper">  
    <?php include "menu.php"; ?>  
    <div class="card">
        <div class="panel panel-warning">
            <div class="panel-heading">RFID Scanner</div>
            <div class="panel-body"> 
                <div class="container-fluid">
                    <div id="cekkartu"></div>
                </div>
                <br>
            </div>
        </div>
        <div class="panel panel-warning">
            <div class="panel-heading">Rekap Data</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="rekapTable" class="table table-bordered">
                        <thead>
                            <tr style="background-color: black; color:white">
                                <th style="width: 1%; text-align: center">No.</th>
                                <th style="width: 5%; text-align: center">Nama</th>
                                <th style="width: 5%; text-align: center">Kode RFID</th>
                                <th style="width: 5%; text-align: center">ID_Wajah</th>
                                <th style="width: 5%; text-align: center">Shift</th>                    
                                <th style="width: 4%; text-align: center">Tanggal</th>
                                <th style="width: 4%; text-align: center">Jam Masuk</th>
                                <th style="width: 4%; text-align: center">Jam Keluar</th>
                                <th style="width: 4%; text-align: center">Jam Kerja</th>
                                <th style="width: 4%; text-align: center">Potongan</th>
                                <th style="width: 4%; text-align: center">Gaji</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "koneksi.php";
                            date_default_timezone_set('Asia/Jakarta');
                            $tanggal = date('Y-m-d');

                            // Update kueri SQL untuk memastikan 'id_wajah' diambil dari tabel 'scan'
                            $sql = mysqli_query($dbconnect, "
                                SELECT b.nama, a.kode, a.id_wajah, a.shift, a.tanggal, a.jam_masuk, a.jam_keluar, a.jam_kerja, a.potongan, a.gaji 
                                FROM scan a 
                                JOIN karyawan b ON a.kode = b.kode 
                                WHERE a.tanggal = '$tanggal'
                            ");

                            $no = 0;
                            while($data = mysqli_fetch_array($sql)) {
                                $no++;
                                // Pastikan path gambar dihasilkan dengan benar
                                $image_path = 'scan/' . $data['id_wajah'] . '?v=' . time();
                            ?>
                            <tr>
                                <td style="width: 1%; text-align: center"> <?php echo $no; ?> </td>
                                <td style="width: 5%; text-align: center"> <?php echo $data['nama']; ?> </td>
                                <td style="width: 5%; text-align: center"> <?php echo $data['kode']; ?> </td>
                                <td style="width: 5%; text-align: center"> <img src="<?php echo $image_path; ?>" alt="Image" style="width: 200px; height: auto;"> </td>                                
                                <td style="width: 5%; text-align: center"> <?php echo $data['shift']; ?> </td>
                                <td style="width: 5%; text-align: center"> <?php echo $data['tanggal']; ?> </td>
                                <td style="width: 5%; text-align: center"> <?php echo $data['jam_masuk']; ?> </td>
                                <td style="width: 5%; text-align: center"> <?php echo $data['jam_keluar']; ?> </td>
                                <td style="width: 5%; text-align: center"> <?php echo $data['jam_kerja']; ?> </td>
                                <td style="width: 5%; text-align: center">Rp. <?php echo $data['potongan']; ?> </td>
                                <td style="width: 5%; text-align: center">Rp. <?php echo $data['gaji']; ?> </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
