<?php
session_start();

$servername = "localhost";
$username = "manuel";
$password = "1234";
$dbname = "mysitedb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email = $_POST['f_email'];
    $password = $_POST['f_password'];

    // Comprobar si el email existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // El usuario existe, verificar la contraseña
        $row = $result->fetch_assoc();
        $hashed_password = $row['password']; // Suponemos que la contraseña está hasheada en la base de datos

        // Verificar la contraseña con password_verify
        if (password_verify($password, $hashed_password)) {
            // La contraseña es correcta, redirigir a la página principal
            $_SESSION['email'] = $email;  // Guardamos el email en la sesión
            header("Location: main.php");  // Redirigir a la página principal
            exit();
        } else {
            // Contraseña incorrecta
            echo "<p>Contraseña incorrecta. Intenta de nuevo.</p>";
        }
    } else {
        // El email no existe en la base de datos
        echo "<p>El email no está registrado. Intenta de nuevo o regístrate.</p>";
    }
}

$conn->close();
?>

<!-- HTML del formulario de login (podrías separarlo en un archivo aparte si quieres) -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <input name="f_email" type="email" placeholder="e-mail" required><br>
        <input name="f_password" type="password" placeholder="Contraseña" required><br>
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
