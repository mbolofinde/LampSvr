<?php
$servername = "192.168.33.12";
$username = "root";
$password = "";
$database = "social_media";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
