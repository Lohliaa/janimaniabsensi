<?php
include 'koneksi.php';
session_start();

// Get the ID from the URL parameter
$id = $_GET['id'];

// Check if ID is set and is a valid number
if (isset($id) && is_numeric($id)) {
    // Fetch the file name of the image associated with this ID
    $sql = "SELECT id_wajah FROM karyawan WHERE id = ?";
    $stmt = mysqli_prepare($dbconnect, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_wajah);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // If there is an image file associated, delete it
    if ($id_wajah) {
        $file_path = 'karyawan/' . $id_wajah;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // Delete the record from the database
    $sql_delete = "DELETE FROM karyawan WHERE id = ?";
    $stmt_delete = mysqli_prepare($dbconnect, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, 'i', $id);
    if (mysqli_stmt_execute($stmt_delete)) {
        echo "<script>alert('Data karyawan dan foto berhasil dihapus.'); window.location.href='datakartu.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data karyawan.'); window.location.href='datakartu.php';</script>";
    }
    mysqli_stmt_close($stmt_delete);
} else {
    echo "<script>alert('ID tidak valid.'); window.location.href='datakartu.php';</script>";
}
?>
