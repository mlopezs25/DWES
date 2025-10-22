<?php
$servername = "localhost";
$username = "root";
$password = "1234"; // La contraseña de root que configuraste
$dbname = "mysitedb"; // Nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa a la base de datos mysitedb";
?>
