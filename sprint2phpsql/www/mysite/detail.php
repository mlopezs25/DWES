<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Conexión (igual que en main.php)
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "mysitedb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recoger ID del GET y validar
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID no válido.");
}

$id = intval($_GET['id']);

// Obtener datos del elemento (ejemplo: tabla tLibros)
$sql_elemento = "SELECT * FROM tLibros WHERE id = ?";
$stmt = $conn->prepare($sql_elemento);
$stmt->bind_param("i", $id);
$stmt->execute();
$result_elemento = $stmt->get_result();

if ($result_elemento->num_rows === 0) {
    die("Elemento no encontrado.");
}

$elemento = $result_elemento->fetch_assoc();

// Obtener comentarios asociados
$sql_comentarios = "SELECT * FROM comentarios WHERE elemento_id = ? ORDER BY fecha DESC";
$stmt2 = $conn->prepare($sql_comentarios);
$stmt2->bind_param("i", $id);
$stmt2->execute();
$result_comentarios = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Detalle del elemento</title>
    <style>
        img {
            max-width: 300px;
            height: auto;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .atributo {
            margin-bottom: 10px;
        }
        .comentarios {
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
        .comentario {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .comentario:last-child {
            border-bottom: none;
        }
        .usuario {
            font-weight: bold;
        }
        .fecha {
            font-size: 0.9em;
            color: gray;
        }
    </style>
</head>
<body>
    <h1>Detalle del elemento</h1>

    <!-- Mostrar imagen -->
    <?php if (!empty($elemento['imagen'])): ?>
        <img src="<?php echo htmlspecialchars($elemento['imagen']); ?>" alt="Imagen del elemento">
    <?php else: ?>
        <p><em>No hay imagen disponible.</em></p>
    <?php endif; ?>

    <!-- Mostrar atributos -->
    <div>
        <?php foreach ($elemento as $clave => $valor): ?>
            <?php if ($clave !== 'imagen'): ?>
                <div class="atributo"><strong><?php echo htmlspecialchars($clave); ?>:</strong> <?php echo htmlspecialchars($valor); ?></div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Comentarios -->
    <div class="comentarios">
        <h2>Comentarios</h2>
        <?php if ($result_comentarios->num_rows > 0): ?>
            <?php while ($comentario = $result_comentarios->fetch_assoc()): ?>
                <div class="comentario">
                    <div class="usuario"><?php echo htmlspecialchars($comentario['usuario']); ?></div>
                    <div class="fecha"><?php echo htmlspecialchars($comentario['fecha']); ?></div>
                    <div class="texto"><?php echo nl2br(htmlspecialchars($comentario['comentario'])); ?></div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay comentarios para este elemento.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
$stmt->close();
$stmt2->close();
$conn->close();
?>
