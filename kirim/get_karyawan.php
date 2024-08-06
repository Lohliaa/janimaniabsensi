<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "janimani";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SELECT statement
$sql = "SELECT `kondisi` FROM `kondisi` WHERE `id` = 1";
$result = $conn->query($sql);

if ($result === false) {
  die("Error: " . $conn->error);
}

if ($result->num_rows > 0) {
  // Output data of the row
  $row = $result->fetch_assoc();
  echo $row["kondisi"];

  // Prepare and execute the UPDATE statement
  $update_sql = "UPDATE `kondisi` SET `kondisi` = 0 WHERE `id` = 1";
  if ($conn->query($update_sql) === false) {
    die("Error updating record: " . $conn->error);
  }
} else {
  echo "0 results";
}

$conn->close();
?>
