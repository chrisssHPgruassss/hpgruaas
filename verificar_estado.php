
<?php
$nombre = $_GET['nombre'];
$estado = in_array($nombre, $nombres_db) ? "roja" : "verde";
$response = array("nombre" => $nombre, "estado" => $estado);
header('Content-Type: application/json');
echo json_encode($response);
?>

