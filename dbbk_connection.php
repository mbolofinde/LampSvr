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

<?php
$dsn = "mysql:host=127.0.0.1;dbname=Chapter5;port=3309;charset=utf8";
$username = "root";
$password = "pciglb2024";
$pdo = new PDO($dsn, $username, $password);
 
// Use $pdo to perform database operations
echo "Connected Successfully";

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>

<?php
$servername = "localhost";
$username = "admin";
$password = "";
$database = "social_media";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

