<html>
<head>
    <title>Formulario de Información</title>
</head>
<body>
    <center><h1>Revisa Disponibilidad</h1>
    <form action="" method="POST">
    <link rel="stylesheet" type="text/css" href="eli.css">
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
    
    
    $sql = "DELETE FROM informacion WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
  echo "<center>";      echo "El registro ha sido eliminado correctamente.";
    } else {
        echo "Error al eliminar el registro: " . $conn->error;   echo "</center>"; 
    }
}

  echo "<center>"; 
echo "<br>";
echo "<a href='pagina.php'>       Regresar</a>";
  echo "</center>"; 

$conn->close();
?>
</body>
</html>