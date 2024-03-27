<html>
<head>
<title>Formulario CSS M3S3</title>
<link rel="stylesheet" href="mos.css">
</head>
<body>
<nav>
        <a href="graficas.html">Ingresar Datos</a>
        <a href="editar.html">Editar</a>
        <a href="borrar.html">Borrar</a>
        <a href="mostrar.html">Mostrar Datos</a>
        <a href="buscar.html">Buscar</a>
    </nav>
<?php
$server = "localhost";
$user = "root";
$pass = "";
$bd = "servicios";

$conexion = mysqli_connect($server, $user, $pass, $bd) or die("Error en la conexion");

$numero_servicio = isset($_POST['numero_servicio']) ? $_POST['numero_servicio'] : "";
$unidad = isset($_POST['unidad']) ? $_POST['unidad'] : "";


$sql = "SELECT * FROM servicios WHERE 1";

if (!empty($numero_servicio)) {
    $sql .= " AND numero_servicio = '$numero_servicio'";
}

if (!empty($unidad)) {
    $sql .= " AND unidad = '$unidad'";
}

$consulta = mysqli_query($conexion, $sql) or die("Error al consultar los datos...");

echo '<table border="1" align="center">';
echo '<tr>';
echo '<th id="numero_servicio">numero_servicio</th>';
echo '<th id="fecha">fecha</th>';
echo '<th id="nombre_cliente">nombre_cliente</th>';
echo '<th id="telefono">telefono</th>';
echo '<th id="falla_detectada">falla_detectada</th>';
echo '<th id="unidad">unidad</th>';
echo '<th id="costo">costo</th>';
echo '<th id="gasto">gasto</th>';
echo '</tr>';

while ($extraido = mysqli_fetch_array($consulta)) {
    echo '<tr>';
    echo '<td>' . $extraido['numero_servicio'] . '</td>';
    echo '<td>' . $extraido['fecha'] . '</td>';
    echo '<td>' . $extraido['nombre_cliente'] . '</td>';
    echo '<td>' . $extraido['telefono'] . '</td>';
    echo '<td>' . $extraido['falla_detectada'] . '</td>';
    echo '<td>' . $extraido['unidad'] . '</td>';
    echo '<td>' . $extraido['costo'] . '</td>';
    echo '<td>' . $extraido['gasto'] . '</td>';
    echo '</tr>';
}
mysqli_close($conexion);
echo '</table>';
?>
</body>
</html>