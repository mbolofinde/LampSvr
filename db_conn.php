<?php

$dsn = 'mysql:dbname=student_union; host=192.168.33.12;';
$user = 'admin';
$password = 'pciglb@24';

$pdo = new PDO($dsn, $user, $password);

echo 'connected successfully';


?>