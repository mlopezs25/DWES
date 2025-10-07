<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>

    <form method="post" action="">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" required>
        <br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>
        <br><br>

        <input type="submit" value="Ingresar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        if ($usuario === "admin" && $contrasena === "1234") {
            echo "<p>Acceso concedido</p>";
        } else {
            echo "<p>Acceso denegado</p>";
        }
    }
    ?>
</body>
</html>

