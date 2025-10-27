<?php
$servername = "localhost";
$username = "root";
$password = "1234"; // La contraseña de root que configuraste
$dbname = "mysitedb"; // Nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// Ya no echo el mensaje de conexión, para que no aparezca en la página
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
    </style>
</head>
<body>
    <h1>Catálogo</h1>
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

