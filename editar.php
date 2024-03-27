<html>
<head>
<title>Formulario CSS M3S3</title>
<link rel="stylesheet" href="A.css">
</head>
<body>

    <img src="3.png" height="30" width="30" alt="Imagen" id="toggleButton" onclick="toggleDropdown()">
    
   
    <form>
        <label for="colors"></label>
        <select id="colors" name="colors" onchange="redirectToPage()">}
		<option value="">Selecciona una página</option>
            <option value="graficas.html">Ingresar Datos</option>
            <option value="editar.html">Editar</option>
            <option value="borrar.html">Borrar</option>
            <option value="mostrar.html">Mostrar Datos</option>
            <option value="buscar.html">Buscar</option>
        </select>
    </form>

    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("colors");
            if (dropdown.style.display === "none" || dropdown.style.display === "") {
                dropdown.style.display = "block"; 
            } else {
                dropdown.style.display = "none"; 
            }
        }

        function redirectToPage() {
            var selectedPage = document.getElementById("colors").value;
            if (selectedPage !== "") {
                window.location.href = selectedPage;
            }
        }
    </script>
<?php
$server="localhost";
$user="root";
$pass="";
$bd="servicios";

$conexion = mysqli_connect($server,$user,$pass,$bd)
or die("Error en la conexion...");
$numero_servicio = $_POST["numero_servicio"];
$fecha = $_POST["fecha"];
$nombre_cliente = $_POST["nombre_cliente"];
$telefono = $_POST["telefono"];
$falla_detectada = $_POST["falla_detectada"];
$unidad = $_POST["unidad"];
$costo = $_POST["costo"];
$gasto = $_POST["gasto"];

mysqli_query ($conexion, "UPDATE servicios set fecha='$fecha', nombre_cliente='$nombre_cliente',
telefono='$telefono', falla_detectada='$falla_detectada', unidad='$unidad', costo='$costo', gasto='$gasto' WHERE numero_servicio='$numero_servicio'") or die ("Error al actualizar los datos");

mysqli_close($conexion);
echo"Datos actualizados correctamente....";
?>
</body>
</html>