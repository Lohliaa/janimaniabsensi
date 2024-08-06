<?php
include 'koneksi.php';

if (!empty($_POST)) {
    // Get the value from the POST request
    $kode = $_POST["kode"];
    
    // Connect to the database
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL SELECT statement to check the mode from kondisi table
    $mode_sql = "SELECT mode FROM kondisi WHERE id = 1";
    $q_mode = $pdo->prepare($mode_sql);
    $q_mode->execute();
    $mode_result = $q_mode->fetch(PDO::FETCH_ASSOC);

    if ($mode_result['mode'] == 0) {
        // If mode is 0, insert into qrcode table
        $insert_sql = "INSERT INTO qrcode (kode) VALUES (?)";
        $q_insert = $pdo->prepare($insert_sql);
        $q_insert->execute(array($kode));
        echo "Record inserted into qrcode table successfully";

        // Update the kondisi table for id=1
        $update_sql1 = "UPDATE kondisi SET kondisi = ? WHERE id = 1";
        $q_update1 = $pdo->prepare($update_sql1);
        $q_update1->execute(array($kode));
        echo " and kondisi updated successfully for id=1";

        // Update relay table
        $update_relay_sql = "UPDATE relay SET relay = 'uploaded' WHERE id = 1";
        $q_update_relay = $pdo->prepare($update_relay_sql);
        $q_update_relay->execute();
        echo " and relay updated successfully for id=1";
        
    } else {
        // If mode is 1, proceed with the original logic

        // Prepare the SQL SELECT statement to check if kode exists in the karyawan table
        $check_sql = "SELECT kode FROM karyawan WHERE kode = ?";
        $q_check = $pdo->prepare($check_sql);
        $q_check->execute(array($kode));
        $result = $q_check->fetch(PDO::FETCH_ASSOC);

        // Check if kode exists
        if ($result) {
            // Update the kondisi table for id=1
            $update_sql1 = "UPDATE kondisi SET kondisi = ? WHERE id = 1";
            $q_update1 = $pdo->prepare($update_sql1);
            $q_update1->execute(array($kode));
            echo "Record inserted and kondisi updated successfully for id=1";

            // Update relay table
            $update_relay_sql = "UPDATE relay SET relay = 'RFID Done' WHERE id = 1";
            $q_update_relay = $pdo->prepare($update_relay_sql);
            $q_update_relay->execute();
            echo " and relay updated to 'RFID Done' successfully for id=1";
        } else {
            echo "Failed: kode does not exist in karyawan table";

            // Update relay table
            $update_relay_sql = "UPDATE relay SET relay = 'data kosong' WHERE id = 1";
            $q_update_relay = $pdo->prepare($update_relay_sql);
            $q_update_relay->execute();
            echo " and relay updated to 'data kosong' successfully for id=1";
        }
    }
    
    // Disconnect from the database
    Database::disconnect();
}
?>
