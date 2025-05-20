<?php
$host = 'localhost';
$db = 'webapp_db';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}
?>