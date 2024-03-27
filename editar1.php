<html>
<head>
    <title>Formulario de Información</title>
</head>
<body>
    <form action="" method="POST">
    <link rel="stylesheet" type="text/css" href="edi.css">

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dispo";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    
   
    $sql = "SELECT * FROM informacion WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        
		  echo "<center>";
        echo "<h1>Editar Registro</h1>";
        echo "<form action='guardar_edicion.php' method='POST'>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "Empresa: <input type='text' name='empresa' value='" . $row['empresa'] . "' required><br>";
        echo "Operador: <input type='text' name='operador' value='" . $row['operador'] . "' required><br>";
        echo "Grúa: <input type='text' name='grua' value='" . $row['grua'] . "' required><br>";
        echo "Ubicación: <input type='text' name='ubicacion' value='" . $row['ubicacion'] . "' required><br>";
        echo "Contacto: <input type='text' name='contacto' value='" . $row['contacto'] . "' required><br>";
        echo "<input type='submit' value='Guardar Cambios'>";
        echo "</form>";
    } else {
        echo "No se encontró el registro.";
    }
}
  echo "</center>";

  echo "<center>";
echo "<br>";
echo "<a href='pagina.php'>       Regresar</a>";
  echo "</center>";

$conn->close();
?>
</body>
</html>