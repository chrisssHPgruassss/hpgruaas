<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dispo";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empresa = $_POST["empresa"];
    $operador = $_POST["operador"];
    $grua = $_POST["grua"];
    $ubicacion = $_POST["ubicacion"];
    $contacto = $_POST["contacto"];
    $fecha = $_POST["fecha"];

    // Insertar datos en la base de datos
    $sql = "INSERT INTO registros (empresa, operador, grua, ubicacion, contacto, fecha) VALUES ('$empresa', '$operador', '$grua', '$ubicacion', '$contacto', '$fecha')";

    if ($conn->query($sql) === TRUE) {
        echo "Datos almacenados correctamente";

        // Mostrar la tabla con los datos
        $result = $conn->query("SELECT * FROM registros");
        if ($result->num_rows > 0) {
            echo "<br><br><h2>Registros existentes:</h2>";
            echo "<table border='1'><tr><th>ID</th><th>Empresa</th><th>Operador</th><th>Grúa</th><th>Ubicación</th><th>Contacto</th><th>Fecha</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"] . "</td><td>" . $row["empresa"] . "</td><td>" . $row["operador"] . "</td><td>" . $row["grua"] . "</td><td>" . $row["ubicacion"] . "</td><td>" . $row["contacto"] . "</td><td>" . $row["fecha"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No hay registros existentes.";
        }
    } else {
        echo "Error al almacenar datos: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>
