<?php
$servername = "localhost";
$username = "root";        
$password = "";            
$dbname = "OK"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT ID, Nombres, Apellidos FROM evaluadores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Formulario de Evaluación</title>
    <style>
        #nombreCliente {
            width: 95%; 
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #002366;
            color: #ffffff;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        form {
            background-color: #001a4d; 
            border-radius: 15px;
            padding: 20px;
            max-width: 500px;
            margin: 50px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #ffffff; 
            font-weight: bold;
        }
        select, input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #002366; 
            border-radius: 5px;
            background-color: #ffffff; 
            color: #002366; 
            outline: none;
        }
        input[type="submit"] {
            background-color: #ff0000; 
            color: #ffffff; 
            border: none;
            padding: 12px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #cc0000; 
        }
    </style>
</head>
<body>
    <div class="navbar">
        <img src="img/Logos_Mesa de trabajo 1 copia.png" alt="Logo"> 
    </div>
    <h1>Formulario de Evaluación</h1>
    <form action="encuesta.php" method="post">
        <label for="evaluador">Nombre del Evaluador:</label>
        <select name="evaluador" id="evaluador" required>
            <option value="">Seleccione un evaluador</option>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['ID'] . '">' . htmlspecialchars($row['Nombres']) . ' ' . htmlspecialchars($row['Apellidos']) . '</option>';
                }
            } else {
                echo '<option value="">No hay evaluadores disponibles</option>';
            }
            ?>
        </select>

        <label for="nombreCliente">Nombre del Cliente:</label>
        <input type="text" id="nombreCliente" name="nombreCliente" required>

        <input type="submit" value="Enviar">
    </form>

    <?php
    // Cerrar conexión
    $conn->close();
    ?>
</body>
</html>
