<?php
$servername = "192.168.33.12";
$username = "padmin";
$password = "vagrant";

try {
  $conn = new PDO("mysql:host=$servername;port=3306;dbname=social_media", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>