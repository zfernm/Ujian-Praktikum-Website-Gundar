<?php
$host = 'localhost';
$user = 'root';
$password = ''; 
$db_name = 'Ujian_Praktikum_Website_Gundar';

$conn = new mysqli($host, $user, $password, $db_name);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
?>