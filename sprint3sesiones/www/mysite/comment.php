<?php
// Conectar a la base de datos
$db = mysqli_connect('localhost', 'manuel', '1234', 'mysitedb') or die('Error al conectar a la base de datos');

// Iniciar sesión
session_start();

// Verificar si hay un usuario logueado
$user_id_a_insertar = NULL; // Establecemos NULL por defecto
if (isset($_SESSION['user_id'])) {
    $user_id_a_insertar = $_SESSION['user_id']; // Obtener el ID del usuario logueado
}

// Obtener los datos del formulario
$libro_id = $_POST['libro_id'];
$comentario = $_POST['new_comment'];

// Preparar la consulta SQL para evitar inyecciones SQL
$query = "INSERT INTO tComentarios (comentario, libro_id, usuario_id) VALUES (?, ?, ?)";

// Preparar la sentencia SQL
$stmt = mysqli_prepare($db, $query);

// Verificar si la preparación fue exitosa
if ($stmt === false) {
    die('Error al preparar la consulta: ' . mysqli_error($db));
}

// Vincular los parámetros
mysqli_stmt_bind_param($stmt, 'sii', $comentario, $libro_id, $user_id_a_insertar);

// Ejecutar la consulta
$ejecutado = mysqli_stmt_execute($stmt);

// Verificar si la ejecución fue exitosa
if ($ejecutado) {
    echo "<p>Nuevo comentario añadido con éxito.</p>";
    echo "<p>ID del nuevo comentario: " . mysqli_insert_id($db) . "</p>";
} else {
    echo "<p>Error al añadir el comentario: " . mysqli_error($db) . "</p>";
}

// Volver a la página de detalles del libro
echo "<a href='/detail.php?libro_id=" . $libro_id . "'>Volver</a>";

// Cerrar la conexión
mysqli_stmt_close($stmt);
mysqli_close($db);
?>


