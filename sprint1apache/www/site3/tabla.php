<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla del 7</title>
    <style>
        table {
            border-collapse: collapse;
            width: 200px;
        }
        td, th {
            border: 1px solid #333;
            padding: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Tabla de multiplicar del 7</h1>
    <table>
        <thead>
            <tr>
                <th>Multiplicación</th>
                <th>Resultado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 1; $i <= 10; $i++) {
                echo "<tr>";
                echo "<td>7 x $i</td>";
                echo "<td>" . (7 * $i) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
