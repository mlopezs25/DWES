<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Conversor de Temperaturas</title>
</head>
<body>
    <h2>Conversor de Temperaturas</h2>

    <form method="post" action="">
        <label for="cantidad">Temperatura:</label>
        <input type="number" step="any" name="cantidad" id="cantidad" required>

        <br><br>

        <input type="radio" name="conversion" value="c_to_f" id="c_to_f" required>
        <label for="c_to_f">Celsius → Fahrenheit</label><br>

        <input type="radio" name="conversion" value="f_to_c" id="f_to_c" required>
        <label for="f_to_c">Fahrenheit → Celsius</label><br><br>

        <input type="submit" value="Convertir">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cantidad = $_POST["cantidad"];
        $conversion = $_POST["conversion"];

        if (is_numeric($cantidad)) {
            if ($conversion == "c_to_f") {
                $resultado = ($cantidad * 9 / 5) + 32;
                echo "<p>$cantidad &deg;C = $resultado &deg;F</p>";
            } elseif ($conversion == "f_to_c") {
                $resultado = ($cantidad - 32) * 5 / 9;
                echo "<p>$cantidad &deg;F = $resultado &deg;C</p>";
            } else {
                echo "<p>Conversión no válida.</p>";
            }
        } else {
            echo "<p>Por favor, introduce una cantidad válida.</p>";
        }
    }
    ?>
</body>
</html>
