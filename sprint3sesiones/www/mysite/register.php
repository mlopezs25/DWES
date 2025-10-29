<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "manuel"; // Ajusta estos valores según tu configuración
$password = "1234";
$dbname = "mysitedb"; // Nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: register.html?error=Todos los campos son requeridos.");
        exit();
    }

    // Verificar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        header("Location: register.html?error=Las contraseñas no coinciden.");
        exit();
    }

    // Verificar si el correo electrónico ya está registrado
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: register.html?error=El correo electrónico ya está registrado.");
        exit();
    }

    // Cifrar la contraseña antes de almacenarla
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $hashed_password);

    if ($stmt->execute()) {
        // Redirigir a la página principal (o login) si el registro es exitoso
        header("Location: main.php");  // O cualquier otra página de destino
        exit();
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
