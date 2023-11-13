<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la entrada del usuario
    $entrada = $_POST["entrada"];

    // Validar la entrada (puedes agregar más validaciones según tus necesidades)
    if (strlen($entrada) > 0) {
        // Escapar la entrada para evitar inyecciones
        $entrada = escapeshellarg($entrada);

        // Ejecutar el script de bash y obtener la salida
        exec("bash tu_script.sh $entrada", $output, $status);

        // Verificar el estado de ejecución
        if ($status === 0) {
            // Éxito
            $puntaje = intval($output[0]);
            echo "Puntaje: $puntaje";
        } else {
            // Error en la ejecución del script
            echo "Error al ejecutar el script.";
        }
    } else {
        echo "Por favor, proporciona una entrada.";
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
</body>
</html>
