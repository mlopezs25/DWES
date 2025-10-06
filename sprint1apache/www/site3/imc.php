<?php
function calcular_imc($peso, $altura) {
    if ($altura <= 0) {
        return null; // altura inválida
    }
    return $peso / ($altura * $altura);
}

$peso = isset($_GET['peso']) ? floatval($_GET['peso']) : null;
$altura = isset($_GET['altura']) ? floatval($_GET['altura']) : null;

if ($peso === null || $altura === null) {
    echo "Por favor, proporciona los parámetros 'peso' y 'altura' en la URL, por ejemplo: imc.php?peso=70&altura=1.75";
    exit;
}

$imc = calcular_imc($peso, $altura);

if ($imc === null) {
    echo "Altura inválida. Debe ser un número positivo.";
    exit;
}

echo "Peso: $peso kg<br>";
echo "Altura: $altura m<br>";
echo "IMC: " . round($imc, 2) . "<br>";

if ($imc < 18.5) {
    echo "Estado: Bajo peso";
} elseif ($imc < 25) {
    echo "Estado: Normal";
} else {
    echo "Estado: Sobrepeso";
}
?>
