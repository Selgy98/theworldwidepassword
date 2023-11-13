<?php

// Inicializar el puntaje
$puntaje = 100;

// Verificar si se ha enviado un formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la entrada del usuario
    $entrada = $_POST["entrada"];

    // Analizar la longitud de la entrada
    $longitud = strlen($entrada);

    // Contar la cantidad de caracteres especiales en la entrada
    $num_caracteres_especiales = preg_match_all('/[!@#$%^&*(),.?":{}|<>]/', $entrada);

    // Verificar las condiciones y ajustar el puntaje
    if ($num_caracteres_especiales == 0) {
        $puntaje -= 30;
    } elseif ($num_caracteres_especiales == 1) {
        $puntaje -= 15;
    }

    // Verificar las condiciones adicionales y ajustar el puntaje
    if ($longitud < 8) {
        $puntaje -= 50;
    } elseif ($longitud < 12) {
        $puntaje -= 20;
    } elseif ($longitud < 32) {
        // No se resta nada si hay al menos 3 caracteres especiales
        if ($num_caracteres_especiales < 3) {
            $puntaje -= 10;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Puntaje</title>
</head>
<body>
    <h1>Calculadora de Puntaje</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="entrada">Entrada del usuario:</label>
        <input type="text" name="entrada" id="entrada" required>
        <br>
        <button type="submit">Calcular Puntaje</button>
    </form>

    <?php
    // Mostrar el puntaje si se ha enviado un formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<p>Puntaje final: $puntaje</p>";
    }
    ?>
</body>
</html>
