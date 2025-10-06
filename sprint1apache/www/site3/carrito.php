<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de la compra</title>
    <style>
        table {
            border-collapse: collapse;
            width: 300px;
        }
        td, th {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        tfoot td {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Carrito de la compra</h1>
    <?php
    $carrito = [
        "Manzana" => 0.50,
        "Pan" => 1.20,
        "Leche" => 0.90,
        "Queso" => 2.30
    ];

    $total = 0;
    echo "<table>";
    echo "<thead><tr><th>Producto</th><th>Precio</th></tr></thead>";
    echo "<tbody>";
    foreach ($carrito as $producto => $precio) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($producto) . "</td>";
        echo "<td>" . number_format($precio, 2) . "€</td>";
        echo "</tr>";
        $total += $precio;
    }
    echo "</tbody>";
    echo "<tfoot><tr><td>TOTAL</td><td>" . number_format($total, 2) . "€</td></tr></tfoot>";
    echo "</table>";
    ?>
</body>
</html>
