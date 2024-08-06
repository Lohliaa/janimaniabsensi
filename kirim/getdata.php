<?php
include 'koneksi.php';

// Tetapkan id yang akan diambil secara statis
$id = 1;

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM relay WHERE id = ?';

$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);
Database::disconnect();

if ($data) {
    echo $data['relay'];
} else {
    echo "Data Tidak Ada";
}
?>
