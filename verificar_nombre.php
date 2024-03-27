
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dispo";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}


$nombre = strtolower($_GET['nombre']);

$sql = "SELECT operador FROM informacion WHERE LOWER(operador) = '$nombre'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   
    echo 'encontrado';
} else {
   
    echo 'no encontrado';
}

$conn->close();
?>
