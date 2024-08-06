<?php
    include "koneksi.php";
    $sql = mysqli_query($dbconnect, "select * from qrcode");
    $kode = "";
    if ($sql && mysqli_num_rows($sql) > 0) {
        $data = mysqli_fetch_array($sql);
        $kode = $data['kode'];
    }
?>

<div class="form-group">
    <label>No.Kartu</label>
    <input type="text" name="kode" id="kode" placeholder="tempelkan kartu rfid Anda" class="form-control" style="width: 200px" value="<?php echo $kode; ?>">
</div>
