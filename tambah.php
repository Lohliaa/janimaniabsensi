<?php
include 'koneksi.php';
session_start();

// SQL query to update the `mode` column to '0' where `id` is 1
$sql = "UPDATE `kondisi` SET `mode` = '0' WHERE `id` = 1";
if (mysqli_query($dbconnect, $sql)) {
    echo "Mode updated successfully.";
} else {
    echo "Error updating mode: " . mysqli_error($dbconnect);
}

if (isset($_POST['btnSimpan'])) {
    // Read form input
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $id_wajah = $_POST['id_wajah']; // Get selected image

    // Check for duplicate kode
    $cek_kode = mysqli_query($dbconnect, "SELECT * FROM karyawan WHERE kode = '$kode'");
    if (mysqli_num_rows($cek_kode) > 0) {
        echo "
            <script>
                alert('Gagal: Terdapat kesamaan data');
                location.replace('datakartu.php');
            </script>
        ";
    } else {
        // Move the selected image to the 'karyawan' directory
        $source_file = "img/" . $id_wajah;
        $destination_file = "karyawan/" . $id_wajah;

        if (rename($source_file, $destination_file)) {
            // Save to the karyawan table
            $simpan = mysqli_query($dbconnect, "INSERT INTO karyawan (kode, id_wajah, jabatan, nama, status) VALUES ('$kode', '$id_wajah', '$jabatan', '$nama', '1')");

            // Check if data is saved successfully
            if ($simpan) {
                echo "
                    <script>
                        alert('Tersimpan');
                        location.replace('datakartu.php');
                    </script>
                ";
            } else {
                echo "
                    <script>
                        alert('Gagal Tersimpan');
                        location.replace('datakartu.php');
                    </script>
                ";
            }
        } else {
            echo "
                <script>
                    alert('Gagal memindahkan foto');
                    location.replace('datakartu.php');
                </script>
            ";
        }
    }
}

// Clear the qrcode table
mysqli_query($dbconnect, "DELETE FROM qrcode");

// Clear the img/ folder
$files = glob('img/*'); // get all file names
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file); // delete file
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include "header.php"; ?>
    <title>Tambah Data Karyawan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Automatic card reading -->
    <script type="text/javascript">
        $(document).ready(function(){
            setInterval(function(){
                $("#norfid").load('nokartu.php')
            }, 1000);  // Read nokartu.php every 1 second

            // Function to update the image preview
            function updateImagePreview() {
                var selectedImage = document.getElementById('id_wajah').value;
                document.getElementById('imagePreview').src = 'img/' + selectedImage;
            }

            // Function to fetch and update images list
            function fetchImages() {
                $.ajax({
                    url: 'getimages.php?action=get_images',
                    type: 'GET',
                    success: function(response) {
                        var images = JSON.parse(response);
                        var select = $('#id_wajah');
                        select.empty();
                        images.forEach(function(image) {
                            select.append('<option value="' + image + '">' + image + '</option>');
                        });
                        updateImagePreview();
                    }
                });
            }

            // Fetch images initially and set interval to fetch periodically
            fetchImages();
            setInterval(fetchImages, 2000); // Fetch images every 20 seconds

            // Update image preview when selection changes
            $('#id_wajah').change(updateImagePreview);
        });
    </script>
</head>
<body>
    <div class="container" id="wrapper">  
        <?php include "menu.php"; ?>  
        <div class="card">
            <div class="panel panel-warning">
                <div class="panel-heading">Tambah Data Karyawan</div>
                <div class="panel-body "> 
                    <!-- Input form -->
                    <form method="POST">
                        <div id="norfid"></div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" style="width: 400px" required>
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="Jabatan" style="width: 400px" required>
                        </div>

                        <!-- Image selection -->
                        <div class="form-group">
                            <label>Foto</label>
                            <select class="form-control" name="id_wajah" id="id_wajah" style="width: 400px" required>
                                <!-- Options will be populated dynamically by JavaScript -->
                            </select>
                        </div>

                        <!-- Image preview -->
                        <div class="form-group">
                            <label>Preview Foto</label><br>
                            <img id="imagePreview" src="" alt="Image Preview" style="width: 200px; height: auto;">
                        </div>
                        <button class="btn btn-warning" name="btnSimpan" id="btnSimpan">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
