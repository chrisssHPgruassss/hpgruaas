<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Información</title>
    <style>
        
        .luz-verde {
            width: 20px;
            height: 20px;
            background-color: green;
            display: inline-block;
            border-radius: 50%;
        }

        .luz-roja {
            width: 20px;
            height: 20px;
            background-color: red;
            display: inline-block;
            border-radius: 50%;
        }
    </style>
    <link rel="stylesheet" href="gs.css">
</head>
<body>
    <div id="nav">
        <a href="index.html">Regresar</a>
        <a href="graficas.html">Registro Servicios</a>
        <a href="pagos.php">Pagos</a>
        <a href="pagina.php">Actualiza</a>
    </div>

    <div id="nombres">
        <h2></h2>
        <table border='1'>
            <tr><th>Nombre</th><th>Estado</th></tr>
            <?php
            
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "dispo";

            $conn = new mysqli($servername, $username, $password, $dbname);

           
            if ($conn->connect_error) {
                die("La conexión a la base de datos falló: " . $conn->connect_error);
            }

         
            $sql_nombres = "SELECT operador FROM informacion"; 
            $result_nombres = $conn->query($sql_nombres);

            
            $nombres_db = array();
            while ($row = $result_nombres->fetch_assoc()) {
                $nombres_db[] = strtolower($row['operador']);
            }

            
            $nombres_fijos = array('idealfonso', 'ponce', 'gustavo', 'carlos', 'gamaniel', 'miguel', 'luis', 'ivan');

            foreach ($nombres_fijos as $nombre) {
                echo "<tr><td>$nombre</td><td>" . estadoLuz(strtolower($nombre), $nombres_db) . "</td></tr>";
            }

            
            $conn->close();
            ?>
        </table>
    </div>

    <div id="formulario">
        <h1></h1>
        <form action="" method="POST">
            <label for="empresa">Empresa:</label>
            <input type="text" id="empresa" name="empresa" required><br><br>

            <label for="operador">Operador:</label>
            <input type="text" id="operador" name="operador" required><br><br>

            <label for="grua">Grúa:</label>
            <input type="text" id="grua" name="grua" required><br><br>

            <label for="ubicacion">Ubicación:</label>
            <input type="text" id="ubicacion" name="ubicacion" required><br><br>

            <label for="contacto">Contacto:</label>
            <input type="text" id="contacto" name="contacto" required><br><br>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required><br><br>

            <label for="precio">Dinero:</label>
            <input type="text" id="precio" name="precio" required><br><br>

            <input type="submit" value="Guardar">
        </form>
    </div>

    <div id="datos-almacenados">
        <?php
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dispo";

        $conn = new mysqli($servername, $username, $password, $dbname);

        $total = 0;
      
        if ($conn->connect_error) {
            die("La conexión a la base de datos falló: " . $conn->connect_error);
        }

        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $empresa = $_POST['empresa'];
            $operador = $_POST['operador'];
            $grua = $_POST['grua'];
            $ubicacion = $_POST['ubicacion'];
            $contacto = $_POST['contacto'];

            
            $sql = "INSERT INTO informacion (empresa, operador, grua, ubicacion, contacto)
                    VALUES ('$empresa', '$operador', '$grua', '$ubicacion', '$contacto')";

            if ($conn->query($sql) === TRUE) {
                echo "Los datos se han guardado correctamente en la base de datos.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        
        $sql = "SELECT * FROM informacion";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Datos almacenados:</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Empresa</th><th>Operador</th><th>Grúa</th><th>Ubicación</th><th>Contacto</th><th>Acciones</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['empresa'] . "</td>";
                echo "<td>" . $row['operador'] . "</td>";
                echo "<td>" . $row['grua'] . "</td>";
                echo "<td>" . $row['ubicacion'] . "</td>";
                echo "<td>" . $row['contacto'] . "</td>";
                echo "<td><a href='editar1.php?id=" . $row['id'] . "'>Editar</a> | <a href='eliminar.php?id=" . $row['id'] . "'>Eliminar</a></td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No hay datos almacenados en la base de datos.";
        }

        
        function estadoLuz($nombre, $nombres_db) {
            if (in_array($nombre, $nombres_db)) {
                return "<div class='luz-roja'></div>"; 
            } else {
                return "<div class='luz-verde'></div>";
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $empresa = $_POST['empresa'];
            $operador = $_POST['operador'];
            $grua = $_POST['grua'];
            $ubicacion = $_POST['ubicacion'];
            $contacto = $_POST['contacto'];
            $fecha = $_POST['fecha'];
            $precio = $_POST['precio'];
        
            $sql = "INSERT INTO registros (empresa, operador, grua, ubicacion, contacto, fecha, precio)
                    VALUES ('$empresa', '$operador', '$grua', '$ubicacion', '$contacto', '$fecha', '$precio')";
        
            if ($conn->query($sql) === TRUE) {
                echo "Los datos se han guardado correctamente en la tabla de registros.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        
        echo "<h2>Datos almacenados (registros):</h2>";
        $sql_registros = "SELECT empresa, operador, grua, ubicacion, contacto, fecha, precio FROM registros";
        $result_registros = $conn->query($sql_registros);
        
        if ($result_registros->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Empresa</th><th>Operador</th><th>Grúa</th><th>Ubicación</th><th>Contacto</th><th>Fecha</th><th>Precio</th></tr>";

    // Inicializar un array para almacenar la suma individual por nombre
    $suma_por_nombre = array();

    while ($row = $result_registros->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['empresa'] . "</td>";
        echo "<td>" . $row['operador'] . "</td>";
        echo "<td>" . $row['grua'] . "</td>";
        echo "<td>" . $row['ubicacion'] . "</td>";
        echo "<td>" . $row['contacto'] . "</td>";
        echo "<td>" . $row['fecha'] . "</td>";  
        echo "<td>" . $row['precio'] . "</td>";

        // Suma el valor del precio al total general
        $total += floatval($row['precio']);

        // Suma el valor del precio al total individual por nombre
        $nombre = strtolower($row['operador']);
        if (!isset($suma_por_nombre[$nombre])) {
            $suma_por_nombre[$nombre] = 0;
        }
        $suma_por_nombre[$nombre] += floatval($row['precio']);

        echo "</tr>";
    }

    // Muestra el total al final de la tabla
    echo "</table>";

    // Muestra la suma individual por nombre
    echo "<div style='background-color: #c5cae9; padding: 10px; margin-top: 10px;'>";
    echo "<h3>Totales:</h3>";

    foreach ($nombres_fijos as $nombre) {
        $nombre = strtolower($nombre);
        $suma = isset($suma_por_nombre[$nombre]) ? $suma_por_nombre[$nombre] : 0;
        echo "<p><strong>$nombre:</strong> $" . number_format($suma, 2) . "</p>";
    }

    echo "<h3>Total general:</h3>";
    echo "<p>$" . number_format($total, 2) . "</p>";
    echo "</div>";

} else {
    echo "No hay datos almacenados en la tabla de registros.";
}
        $conn->close();
        ?>
    </div>
</body>
</html>