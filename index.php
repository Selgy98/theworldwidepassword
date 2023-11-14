<?php

// Datos de la base de datos
$host = "localhost";
$puerto = 3306;
$usuario = "TWWPU";
$contrasena = "TWWPU";
$base_de_datos = "TWWPDataBase"; // Reemplaza con el nombre de tu base de datos

// Inicializar el puntaje
$puntaje = 100;

// Intentar establecer la conexión a la base de datos
$conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos, $puerto);

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
} else {
    echo "<p style='color: green; font-weight: bold;'>Estado de la base de datos: <span style='color: green;'>Conectado</span></p>";
}

// Verificar si se ha enviado un formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la entrada del usuario
    $entrada = $_POST["entrada"];

    // Analizar la longitud de la entrada
    $longitud = strlen($entrada);

    // Contar la cantidad de caracteres especiales en la entrada
    $num_caracteres_especiales = preg_match_all('/[!@#$%^&*(),.?":{}|<>]/', $entrada);}

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
    } elseif ($longitud < 32 && $num_caracteres_especiales < 3) {
        $puntaje -= 10;
    }

    // Insertar información en la tabla storedpss
    $entrada_escapada = $conexion->real_escape_string($entrada);
    
    // Verificar si la entrada ya existe en la tabla
$consulta_repetida = "SELECT REPETIDO FROM storedpss WHERE CRED = '$entrada_escapada'";
$resultado_repetida = $conexion->query($consulta_repetida);

if ($resultado_repetida) {
    if ($resultado_repetida->num_rows > 0) {
        // La entrada ya existe, obtener el número de repeticiones
        $fila_repetida = $resultado_repetida->fetch_assoc();
        $num_repeticiones = $fila_repetida['REPETIDO'];

        // Ajustar la columna REPETIDO en consecuencia
        $repetido = $num_repeticiones + 1;

        // Actualizar la entrada existente en la tabla storedpss
        $consulta_actualizar = "UPDATE storedpss SET REPETIDO = $repetido WHERE CRED = '$entrada_escapada'";
        $conexion->query($consulta_actualizar);
    } else {
        // La entrada no existe, insertar en la tabla storedpss
        $consulta_insertar = "INSERT INTO storedpss (CRED, LARGO, SCORE, REPETIDO) VALUES ('$entrada_escapada', $longitud, $puntaje, 1)";
        $conexion->query($consulta_insertar);
    }
} else {
    echo "Error al verificar la repetición de la entrada en la base de datos.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>THE WORLDWIDE PASSWORD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .banner {
            background-color: #3498db;
            color: white;
            padding: 10px;
            text-align: center;
        }

        h1 {
            margin: 0;
            padding: 20px 0;
        }

        form {
            margin: auto;
            width: 50%;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            padding: 8px;
        }

        button {
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }

        p {
            font-size: 18px;
            text-align: center;
        }

        .circle {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 10px;
            background: linear-gradient(to right, green <?php echo $puntaje; ?>%, red <?php echo $puntaje; ?>%);
        }
    </style>
</head>
<body>
    <div class="banner">
    <h1>🔒 THE WORLDWIDE PASSWORD 🔒</h1>
    </div>
        <br/>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="entrada">INTRODUZCA CONTRASEÑA:</label>
        <input type="password" name="entrada" id="entrada" required>
        <br>
        <button type="submit">Calcular Puntaje</button>
    </form>

    <?php
    // Mostrar el puntaje si se ha enviado un formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<p><strong>Puntuación obtenida: $puntaje</strong>";
        echo "<br/>";
        // Mostrar el círculo con el efecto de rellenado en rojo
        echo "<span class='circle'></span>";
        echo "</p>";
    }

// Obtener el promedio de los puntajes
$consulta_promedio = "SELECT AVG(SCORE) as promedio FROM storedpss";
$resultado_promedio = $conexion->query($consulta_promedio);

if ($resultado_promedio) {
    $fila_promedio = $resultado_promedio->fetch_assoc();
    $promedio_puntajes = $fila_promedio['promedio'];

    // Calcular el porcentaje de cuánto más segura es la contraseña actual
    $porcentaje_mas_segura = 0;
    if ($promedio_puntajes > 0) {
        $porcentaje_mas_segura = (($puntaje - $promedio_puntajes) / $promedio_puntajes) * 100;
    }

    // Ajustar el mensaje según el porcentaje
    $mensaje = ($porcentaje_mas_segura >= 0) ? "más segura" : "menos segura";
    $porcentaje_mas_segura = abs($porcentaje_mas_segura);

    // Imprimir el resultado
    echo "<p>Tu contraseña es aproximadamente un " . round($porcentaje_mas_segura, 2) . "% $mensaje que el promedio de las demás contraseñas.</p>";
}

    

?>
</body>
</html>
