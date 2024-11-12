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
            // Conexión a la base de datos
            $servername = "localhost"; 
            $username = "root";        
            $password = "";            
            $dbname = "OK"; 

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $sql = "SELECT ID, Nombres, Apellidos FROM evaluadores";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['ID'] . '">' . htmlspecialchars($row['Nombres']) . ' ' . htmlspecialchars($row['Apellidos']) . '</option>';
                }
            } else {
                echo '<option value="">No hay evaluadores disponibles</option>';
            }

            $conn->close();
            ?>
        </select>

        <label for="nombreCliente">Nombre del Cliente:</label>
        <input type="text" id="nombreCliente" name="nombreCliente" required>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>
