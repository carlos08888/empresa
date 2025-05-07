<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // senha em branco no XAMPP por padrão
$db = 'login_tutorial';

$conn = new mysqli($host, $user, $pass, $db);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
