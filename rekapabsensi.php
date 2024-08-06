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
   <div class="card" >
    <div class="panel panel-warning">
                 <div class="panel-heading">Data Karyawan</div>
                 <div class="panel-body "> 
        <div class="table-responsive"> <!-- Wrap the table inside a div with class "table-responsive" -->
            <!-- Add Month and Year Selection Dropdowns -->
            <form method="get">
                <div class="form-inline">
                    <label for="month">Pilih Bulan:</label>
                    <select class="form-control" id="month" name="month">
                        <?php
                        // Generate options for months
                        for ($i = 1; $i <= 12; $i++) {
                            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                            echo "<option value='$month' " . ($month == $selected_month ? 'selected' : '') . ">$month</option>";
                        }
                        ?>
                    </select>
                    <label for="year">Pilih Tahun:</label>
                    <select class="form-control" id="year" name="year">
                        <?php
                        // Generate options for years (assuming data spans from 2020 to current year)
                        $currentYear = date('Y');
                        for ($year = 2020; $year <= $currentYear; $year++) {
                            echo "<option value='$year' " . ($year == $selected_year ? 'selected' : '') . ">$year</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-warning">Filter</button>
                </div>
            </form>
            <table id="dataKaryawan" class="table table-bordered">
                <thead>
                    <tr style="background-color: black; color: white;">
                        <th style="width: 3%; text-align: center">No.</th>
                        <th style="width: 12%; text-align: center">Kode Akses</th>
                        <th style="width: 12%; text-align: center">ID Wajah</th>
                        <th style="width: 15%; text-align: center">Nama</th>
                        <th style="width: 15%; text-align: center">Total Jam Kerja</th>
                        <th style="width: 5%; text-align: center">Gaji</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Get selected month and year from dropdowns
                        $selected_month = isset($_GET['month']) ? $_GET['month'] : date('m');
                        $selected_year = isset($_GET['year']) ? $_GET['year'] : date('Y');

                        // Debug: Check the selected month and year
                        echo "<!-- Selected Month: $selected_month, Selected Year: $selected_year -->";

                        $sql = mysqli_query($dbconnect, "
                            SELECT k.*, 
                                   IFNULL(SUM(s.gaji), 0) as total_gaji,
                                   IFNULL(SUM(s.jam_kerja), 0) as total_jam_kerja
                            FROM karyawan k
                            LEFT JOIN scan s ON k.kode = s.kode
                            WHERE MONTH(s.tanggal) = '$selected_month' 
                              AND YEAR(s.tanggal) = '$selected_year'
                            GROUP BY k.id
                        ");

                        // Debug: Check if the query was successful
                        if (!$sql) {
                            echo "<!-- Error: " . mysqli_error($dbconnect) . " -->";
                        }

                        $no = 0;
                        while($data = mysqli_fetch_array($sql))
                        {
                            $no++;
                            $image_url = !empty($data['id_wajah']) ? 'karyawan/' . $data['id_wajah'] : 'img/default.jpg';

                            // Debug: Check the generated image URL
                            echo "<!-- Image URL: $image_url -->";
                    ?>
                    <tr>
                        <td style="width: 3%; text-align: center"> <?php echo $no; ?> </td>
                        <td style="width: 12%; text-align: center"> <?php echo $data['kode']; ?> </td>
                        <td style="width: 12%; text-align: center">
                            <img src="<?php echo $image_url; ?>" alt="ID Wajah" style="width: 100px; height: auto;">
                        </td>
                        <td style="width: 15%; text-align: center"> <?php echo $data['nama']; ?> </td>
                        <td style="width: 15%; text-align: center"> <?php echo number_format($data['total_jam_kerja'], 0, ',', '.'); ?> </td>
                        <td style="width: 15%; text-align: center"> <?php echo number_format($data['total_gaji'], 0, ',', '.'); ?> </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
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
