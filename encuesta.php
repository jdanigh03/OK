<?php
session_start(); // Iniciar la sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de Satisfacción</title>
    <style>
        body {
            background-color: #002366; 
            color: #ffffff; 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .navbar {
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar img {
            width: 100px;
            height: auto;
        }
        .encuesta {
            margin-top: 50px;
        }
        .emoji {
            display: inline-block;
            margin: 10px;
            cursor: pointer;
        }
        .emoji img {
            width: 60px;
            height: 60px;
            border-radius: 50%; 
            border: 2px solid #002366; 
            transition: transform 0.3s, border-color 0.3s;
        }
        .emoji img:hover {
            transform: scale(1.1);
        }
        .label {
            display: block;
            margin-top: 5px;
            font-weight: bold;
            color: #ffffff; 
        }
        .confirmation-message {
            margin-top: 20px;
            font-size: 20px;
            color: #00FF00; /* Verde */
        }
    </style>
</head>
<body>
    <div class="navbar">
        <img src="img/Logos_Mesa de trabajo 1 copia.png" alt="Logo"> 
    </div>
    <div class="encuesta">
        <h1>Encuesta de Satisfacción</h1>
        <h2>¿Cómo le atendieron en OK?</h2>
        <?php
            $message = ""; // Variable para mostrar el mensaje de confirmación

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Conexión a la base de datos
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "OK";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Guarda el ID_evaluador y el nombre del cliente en la sesión al recibirlos de index.php
                if (isset($_POST['evaluador']) && isset($_POST['nombreCliente'])) {
                    $_SESSION['id_evaluador'] = $_POST['evaluador'];
                    $_SESSION['nombre_cliente'] = $_POST['nombreCliente'];
                }

                // Verifica que el ID_evaluador de la sesión y el nombre del cliente sean válidos
                if (isset($_POST['calificacion']) && isset($_SESSION['id_evaluador']) && isset($_SESSION['nombre_cliente'])) {
                    $id_evaluador = $_SESSION['id_evaluador'];
                    $nombre_cliente = $_SESSION['nombre_cliente'];

                    // Verifica si el ID_evaluador existe en la tabla evaluadores
                    $verificarEvaluador = "SELECT ID FROM evaluadores WHERE ID = '$id_evaluador'";
                    $resultado = $conn->query($verificarEvaluador);

                    if ($resultado->num_rows > 0) {
                        $calificacion = $_POST['calificacion'];
                        $fechaActual = date('Y-m-d');

                        // Inserta la calificación junto con el nombre del cliente
                        $sqlEncuesta = "INSERT INTO encuesta (ID_evaluador, Calificación, Fecha, cliente) VALUES ('$id_evaluador', '$calificacion', '$fechaActual', '$nombre_cliente')";

                        if ($conn->query($sqlEncuesta) === TRUE) {
                            $message = "Calificación registrada, gracias.";
                        } else {
                            $message = "Error al registrar la calificación: " . $conn->error;
                        }
                    } else {
                        $message = "Error: ID_evaluador no válido.";
                    }
                }

                // Cierra la conexión
                $conn->close();
            }
        ?>
        <div class="emoji-section">
            <?php
                // Imprime las opciones de calificación
                $labels = ['Malo', 'Regular', 'Neutral', 'Bueno', 'Excelente'];
                for ($i = 1; $i <= 5; $i++) {
                    echo '<form action="encuesta.php" method="post" style="display:inline-block;">';
                    echo '<input type="hidden" name="calificacion" value="'.$i.'">';
                    echo '<label class="emoji" onclick="this.parentElement.submit()">';
                    echo '<img src="img/'.$i.'-Photoroom.png" alt="Calificación '.$i.'">';
                    echo '<span class="label">'.$labels[$i - 1].'</span>';
                    echo '</label>';
                    echo '</form>';
                }
            ?>
        </div>
        <?php
            // Muestra el mensaje de confirmación si existe
            if (!empty($message)) {
                echo '<div class="confirmation-message">'.$message.'</div>';
            }
        ?>
    </div>
</body>
</html>
