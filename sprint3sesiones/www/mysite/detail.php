<<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
session_start();

// Conexión a la base de datos
$conn = new mysqli("localhost", "manuel", "1234", "mysitedb");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Validar el ID del libro
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID no válido.");
}
$id = intval($_GET['id']);

// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Usar el nombre de usuario de sesión si está logueado
    if (isset($_SESSION['nombre_usuario'])) {
        $usuario = $_SESSION['nombre_usuario'];
    } else {
        $usuario = trim($_POST['usuario'] ?? '');
    }

    $comentario = trim($_POST['comentario'] ?? '');

    // Verificar que los campos no estén vacíos
    if ($usuario === '' || $comentario === '') {
        echo "<p style='color:red;'>Por favor, rellena todos los campos.</p>";
    } else {
        // Preparar la sentencia SQL para evitar inyecciones SQL
        $stmt = $conn->prepare("INSERT INTO comentarios (elemento_id, usuario, comentario) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id, $usuario, $comentario);

        if ($stmt->execute()) {
            // Redirigir para evitar reenvío del formulario
            header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $id);
            exit;
        } else {
            echo "<p style='color:red;'>Error al añadir comentario: " . $conn->error . "</p>";
        }
        $stmt->close();
    }
}

// Obtener los detalles del libro
$sql = "SELECT * FROM tLibros WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Elemento no encontrado.");
}
$elemento = $result->fetch_assoc();

// Obtener los comentarios
$sqlComentarios = "
    SELECT comentario, fecha, usuario 
    FROM comentarios 
    WHERE elemento_id = $id 
    ORDER BY fecha DESC";
$comentarios = $conn->query($sqlComentarios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del libro</title>
    <style>
        img { max-width: 200px; height: auto; }
        form { margin-top: 20px; }
        label { display: block; margin-top: 10px; }
        textarea { width: 300px; height: 100px; }
        input[type="text"] { width: 300px; }
        .comentario { border-bottom: 1px solid #ccc; padding: 10px 0; }
        .logout { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="logout">
        <?php if (isset($_SESSION['nombre_usuario'])): ?>
            <p>¡Hola, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>! 
               <a href="logout.php">Cerrar sesión</a></p>
        <?php else: ?>
            <p><a href="login.html">Iniciar sesión</a></p>
        <?php endif; ?>
    </div>

    <h1>Detalle del libro</h1>

    <?php if (!empty($elemento['url_imagen'])): ?>
        <img src="<?php echo htmlspecialchars($elemento['url_imagen']); ?>" alt="Imagen">
    <?php endif; ?>

    <h2><?php echo htmlspecialchars($elemento['nombre']); ?></h2>
    <p><strong>Autor:</strong> <?php echo htmlspecialchars($elemento['autor']); ?></p>
    <p><strong>Año de publicación:</strong> <?php echo htmlspecialchars($elemento['anio_publicacion']); ?></p>

    <h2>Comentarios</h2>
    <?php if ($comentarios->num_rows > 0): ?>
        <?php while ($comentario = $comentarios->fetch_assoc()): ?>
            <div class="comentario">
                <strong><?php echo htmlspecialchars($comentario['usuario']); ?></strong> 
                (<?php echo htmlspecialchars($comentario['fecha']); ?>):
                <p><?php echo nl2br(htmlspecialchars($comentario['comentario'])); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No hay comentarios.</p>
    <?php endif; ?>

    <h2>Nuevo comentario</h2>
    <form method="post" action="">
        <?php if (!isset($_SESSION['nombre_usuario'])): ?>
            <label for="usuario">Nombre:</label>
            <input type="text" id="usuario" name="usuario" required>
        <?php endif; ?>

        <label for="comentario">Comentario:</label>
        <textarea id="comentario" name="comentario" required></textarea>

        <br>
        <button type="submit">Enviar comentario</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>

