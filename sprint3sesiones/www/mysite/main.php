<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "1234"; // La contraseña de root que configuraste
$dbname = "mysitedb"; // Nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Catálogo</title>
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 220px;
            margin: 10px;
            padding: 10px;
            text-align: center;
            float: left;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }
        img {
            width: 150px;
            height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .container {
            overflow: hidden; /* Para limpiar floats */
        }
        .logout {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Catálogo</h1>

    <!-- Mostrar mensaje de bienvenida si el usuario está logueado -->
    <div class="logout">
        <?php if (isset($_SESSION['nombre_usuario'])): ?>
            <p>¡Hola, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>! 
               <a href="logout.php">Cerrar sesión</a></p>
        <?php else: ?>
            <p><a href="login.html">Iniciar sesión</a></p>
        <?php endif; ?>
    </div>

    <div class="container">
    <?php
    // Puedes repetir este bloque para otras tablas
    $tabla = "tLibros"; // Cambia a tJuegos, tOtraTabla, etc.

    $sql = "SELECT * FROM $tabla";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<div class='card'>";
            // Enlace al detail.php con el ID
            echo "<a href='/detail.php?id=" . $fila['id'] . "'>";
            if (!empty($fila['imagen'])) {
                echo "<img src='" . htmlspecialchars($fila['imagen']) . "' alt='Imagen'>";
            } else {
                echo "<div style='width:150px; height:200px; background:#eee; display:flex; align-items:center; justify-content:center;'>Sin imagen</div>";
            }
            echo "</a>";

            // Mostrar todas las columnas excepto la imagen
            foreach ($fila as $columna => $valor) {
                if ($columna !== 'imagen') {
                    echo "<p><strong>" . htmlspecialchars($columna) . ":</strong> " . htmlspecialchars($valor) . "</p>";
                }
            }

            echo "</div>";
        }
    } else {
        echo "<p>No hay registros en la tabla $tabla</p>";
    }

    $conn->close();
    ?>
    </div>
</body>
</html>


