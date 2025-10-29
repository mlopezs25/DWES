<?php
session_start();
$servername = "localhost";
$username = "manuel";
$password = "1234"; // La contraseña de root que configuraste
$dbname = "mysitedb"; // Nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar que el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo "No estás logueado.";
    exit();
}

// Si el formulario de comentario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize y obtener los datos
    $comentario = htmlspecialchars($_POST['comentario']); // El comentario del usuario
    $usuario_id = $_SESSION['user_id']; // Obtener el ID del usuario logueado
    $libro_id = $_POST['libro_id']; // Obtener el ID del libro

    // Insertar el comentario en la base de datos
    $sql = "INSERT INTO tComentarios (comentario, usuario_id, libro_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $comentario, $usuario_id, $libro_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Comentario enviado exitosamente.";
    } else {
        echo "Error al enviar el comentario.";
    }

    $stmt->close();
}

$conn->close();
?>

