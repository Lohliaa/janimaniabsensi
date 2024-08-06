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
<title>Data Karyawan</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
</head>
<body>
    <div class="container" id="wrapper">  
    <?php include "menu.php"; ?>  
   <div class="card">
    <div class="panel panel-warning">
        <div class="panel-heading">Data Karyawan</div>
        <div class="panel-body"> 
            <div class="table-responsive"> <!-- Wrap the table inside a div with class "table-responsive" -->
                <table id="dataKaryawan" class="table table-bordered">
                    <thead>
                        <tr style="background-color: black; color: white;">
                            <th style="width: 3%; text-align: center">No.</th>
                            <th style="width: 12%; text-align: center">Kode Akses</th>
                            <th style="width: 12%; text-align: center">ID Wajah</th>
                            <th style="width: 15%; text-align: center">Nama</th>
                            <th style="width: 15%; text-align: center">Jabatan</th>
                            <th style="width: 12%; text-align: center">Aksi</th>
                            <th style="width: 12%; text-align: center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = mysqli_query($dbconnect, "SELECT * FROM karyawan");
                            $no = 0;
                            while($data = mysqli_fetch_array($sql))
                            {
                                $no++;
                        ?>
                        <tr>
                            <td style="width: 3%; text-align: center"> <?php echo $no; ?> </td>
                            <td style="width: 12%; text-align: center"> <?php echo $data['kode']; ?> </td>
                            <td style="width: 12%; text-align: center">
                                <img src="karyawan/<?php echo $data['id_wajah']; ?>" alt="ID Wajah" style="width: 100px; height: auto;">
                            </td>
                            <td style="width: 10%; text-align: center"> <?php echo $data['nama']; ?> </td>
                            <td style="width: 10%; text-align: center"> <?php echo $data['jabatan']; ?> </td>
                            <td style="text-align: center">
                                <a href="edit.php?id=<?php echo $data['id']; ?>"><button class="btn btn-success">Edit</button></a> | <a href="hapus.php?id=<?php echo $data['id']; ?>"> <button class="btn btn-danger">Hapus</button></a>
                            </td>
                            <td style="width: 15%; text-align: center"> 
                            <?php if ($data['status'] == 1) { ?>
                                <a href="status.php?id=<?php echo $data['id']; ?>" class="btn btn-success" type="button">
                                  Aktif <span class="badge"><div class="glyphicon glyphicon-ok"></div></span>
                                </a>
                            <?php } else { ?>
                                <a href="status.php?id=<?php echo $data['id']; ?>" class="btn btn-danger" type="button">
                                  Non-Aktif <span class="badge"><div class="glyphicon glyphicon-remove"></div></span>
                                </a>
                            <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- Button to add new employee data -->
            <a href="tambah.php"><button class="btn btn-warning">Tambah Data Karyawan</button></a>
        </div>
    </div>
</div>
</div>
</div>
<script>
$(document).ready(function() {
    $('#dataKaryawan').DataTable();
});
</script>
</body>
</html>
