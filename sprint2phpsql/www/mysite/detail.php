<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión
$conn = new mysqli("localhost", "root", "1234", "mysitedb");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Validar el ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID no válido.");
}
$id = intval($_GET['id']);

// Procesar formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $comentario = trim($_POST['comentario'] ?? '');

    if ($usuario === '' || $comentario === '') {
        echo "<p style='color:red;'>Por favor, rellena todos los campos.</p>";
    } else {
        // Preparar sentencia para evitar SQL Injection
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

// Obtener elemento
$sql = "SELECT * FROM tLibros WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Elemento no encontrado.");
}
$elemento = $result->fetch_assoc();

// Obtener comentarios
$sqlComentarios = "SELECT * FROM comentarios WHERE elemento_id = $id ORDER BY fecha DESC";
$comentarios = $conn->query($sqlComentarios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del elemento</title>
    <style>
        img { max-width: 200px; height: auto; }
        form { margin-top: 20px; }
        label { display: block; margin-top: 10px; }
        textarea { width: 300px; height: 100px; }
        input[type="text"] { width: 300px; }
        .comentario { border-bottom: 1px solid #ccc; padding: 10px 0; }
    </style>
</head>
<body>
    <h1>Detalle del elemento</h1>

    <?php if (!empty($elemento['imagen'])): ?>
        <img src="<?php echo htmlspecialchars($elemento['imagen']); ?>" alt="Imagen">
    <?php endif; ?>

    <?php foreach ($elemento as $clave => $valor): ?>
        <p><strong><?php echo htmlspecialchars($clave); ?>:</strong> <?php echo htmlspecialchars($valor); ?></p>
    <?php endforeach; ?>

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
        <label for="usuario">Nombre:</label>
        <input type="text" id="usuario" name="usuario" required>

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

