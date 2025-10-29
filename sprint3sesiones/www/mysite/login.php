<?php
session_start(); // Inicia la sesión

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "1234"; // Tu contraseña de la base de datos
$dbname = "mysitedb"; // Nombre de tu base de datos

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
    $sql = "SELECT * FROM tUsuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // El usuario existe, verificar la contraseña
        $row = $result->fetch_assoc();
        $hashed_password = $row['contraseña']; // Suponemos que la contraseña está hasheada en la base de datos

        // Verificar la contraseña con password_verify
        if (password_verify($password, $hashed_password)) {
            // La contraseña es correcta, redirigir a la página principal
            $_SESSION['user_id'] = $row['id']; // Guardamos el ID del usuario en la sesión
            $_SESSION['nombre'] = $row['nombre']; // Guardamos el nombre del usuario en la sesión
            $_SESSION['email'] = $email;  // También guardamos el email, si es necesario

            // Redirigir a la página principal (main.php)
            header("Location: main.php"); 
            exit(); // Aseguramos que no se ejecute más código
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


