<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora Básica</title>
</head>
<body>
    <h2>Calculadora Básica</h2>

    <form method="post" action="">
        <label for="num1">Número 1:</label>
        <input type="number" name="num1" id="num1" step="any" required>
        <br><br>

        <label for="num2">Número 2:</label>
        <input type="number" name="num2" id="num2" step="any" required>
        <br><br>

        <label for="operacion">Operación:</label>
        <select name="operacion" id="operacion" required>
            <option value="sumar">Suma (+)</option>
            <option value="restar">Resta (-)</option>
            <option value="multiplicar">Multiplicación (*)</option>
            <option value="dividir">División (/)</option>
        </select>
        <br><br>

        <input type="submit" value="Calcular">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num1 = $_POST["num1"];
        $num2 = $_POST["num2"];
        $operacion = $_POST["operacion"];
        $resultado = null;
        $simbolo = '';

        switch ($operacion) {
            case "sumar":
                $resultado = $num1 + $num2;
                $simbolo = '+';
                break;
            case "restar":
                $resultado = $num1 - $num2;
                $simbolo = '-';
                break;
            case "multiplicar":
                $resultado = $num1 * $num2;
                $simbolo = '*';
                break;
            case "dividir":
                if ($num2 != 0) {
                    $resultado = $num1 / $num2;
                    $simbolo = '/';
                } else {
                    echo "<p>Error: No se puede dividir entre 0.</p>";
                    exit;
                }
                break;
            default:
                echo "<p>Operación no válida.</p>";
                exit;
        }

        echo "<p>$num1 $simbolo $num2 = $resultado</p>";
    }
    ?>
</body>
</html>
