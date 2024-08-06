<?php
include 'koneksi.php';
session_start();

// Ambil data dari tabel qrcode
$baca_kartu = mysqli_query($dbconnect, "SELECT * FROM qrcode");
$data_kartu = mysqli_fetch_array($baca_kartu);
$id_wajah = isset($data_kartu['kode']) ? $data_kartu['kode'] : '';

// Menampilkan gambar default jika $kode kosong atau sama dengan "0"
if ($id_wajah == "" || $id_wajah == "0") {
    echo '
    <div class="container-fluid" style="text-align: center;">
        <img src="images/id.jpg" style="width: 10%"> <br>
        <img src="images/animasi1.gif">
    </div>';
    mysqli_query($dbconnect, "DELETE FROM qrcode");
} elseif ($id_wajah == "Unknown") {
    echo "<h1>Maaf! Anda Tidak Memiliki Akses Apapun di jabatan Ini!</h1>";
    mysqli_query($dbconnect, "DELETE FROM qrcode");
} else {
    // Cek apakah $id_wajah terdaftar dalam tabel karyawan
    $cari_kode = mysqli_query($dbconnect, "SELECT * FROM karyawan WHERE id_wajah='$id_wajah'");
    $jumlah_data = mysqli_num_rows($cari_kode);

    if ($jumlah_data == 0) {
        echo "<h1>Maaf! Anda Tidak Memiliki Akses Apapun di jabatan Ini!</h1>";
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
        $jam = date('H:i:s');
    } else {
        // Ambil data karyawan
        $data_kode = mysqli_fetch_array($cari_kode);
        $nama = $data_kode['nama'];
        $kode = $data_kode['kode'];
        $status = $data_kode['status'];
        $id_wajah = $data_kode['id_wajah'];

        // Ambil nama file gambar dari tabel kondisi
        $baca_kondisi = mysqli_query($dbconnect, "SELECT kondisi FROM kondisi WHERE id=2");
        $data_kondisi = mysqli_fetch_array($baca_kondisi);
        $image_filename = isset($data_kondisi['kondisi']) ? $data_kondisi['kondisi'] . '.jpg' : 'default.jpg';

        // Tampilkan gambar preview
        echo '<div class="container-fluid" style="text-align: center;">';
        echo '<img src="img/' . $image_filename . '" style="width: 50%;">';
        echo '</div>';

        // Tentukan shift dan potongan
        $shift = '';
        $penalty = 6000;
        $potongan = 0;
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
        $jam = date('H:i:s');

        if ($status == 1) {
            // Cek apakah sudah ada record scan untuk hari ini
            $cari_datakode = mysqli_query($dbconnect, "SELECT * FROM scan WHERE id_wajah='$id_wajah' AND tanggal='$tanggal'");
            $jumlah_antrian = mysqli_num_rows($cari_datakode);

            if ($jumlah_antrian == 0) {
                // Jam masuk
                if (strtotime($jam) >= strtotime('09:00:00') && strtotime($jam) <= strtotime('16:00:00')) {
                    $shift = 'Shift 1';
                    if (strtotime($jam) > strtotime('09:05:00')) {
                        $potongan = $penalty;
                    }
                } elseif (strtotime($jam) > strtotime('16:00:00') && strtotime($jam) <= strtotime('23:00:00')) {
                    $shift = 'Shift 2';
                    if (strtotime($jam) > strtotime('16:05:00')) {
                        $potongan = $penalty;
                    }
                }
                
                echo "<h3>Hi! Admin Ada Karyawan Masuk $nama</h3>";
                echo '<script>
                setTimeout(function() {
                    document.querySelector("h3").style.display = "none";
                }, 4000);
            </script>';
                // Insert record scan dengan id_wajah
                mysqli_query($dbconnect, "INSERT INTO scan(nama, kode, id_wajah, shift, tanggal, jam_masuk, potongan) VALUES ('$nama', '$kode', '$id_wajah', '$shift', '$tanggal', '$jam', '$potongan')");
                
            } else {
                // Jam keluar
                $data_scan = mysqli_fetch_array($cari_datakode);
                $jam_masuk = $data_scan['jam_masuk'];
                $shift = $data_scan['shift'];
                $existing_potongan = $data_scan['potongan'];
            
                $start = new DateTime($jam_masuk);
                $end = new DateTime($jam);
                $interval = $start->diff($end);
                $hours_worked = $interval->h + ($interval->i / 60);
            
                $salary = $hours_worked * 6000;
                $salary -= $existing_potongan;
            
                echo "<h3>Hi! Admin Ada Karyawan Keluar $nama</h3>";
                echo '<script>
                    setTimeout(function() {
                        document.querySelector("h3").style.display = "none";
                    }, 4000);
                </script>';
                mysqli_query($dbconnect, "UPDATE scan SET jam_keluar='$jam', jam_kerja='$hours_worked', gaji='$salary' WHERE id_wajah='$id_wajah' AND tanggal='$tanggal'");
            }
        } else {
            echo "<script>alert('Karyawan Tidak Aktif/ Data Pengguna Tidak Dikenal');</script>";
        }
    }
    mysqli_query($dbconnect, "DELETE FROM qrcode");
}
?>
