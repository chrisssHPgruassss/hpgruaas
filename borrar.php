<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario CSS M3S3</title>
    <link rel="stylesheet" href="borr2.css">
</head>
<body>

    <header>
        <h1>Formulario CSS M3S3</h1>
    </header>

    <nav>
        <a href="graficas.html">Ingresar Datos</a>
        <a href="editar.html">Editar</a>
        <a href="borrar.html">Borrar</a>
        <a href="mostrar.html">Mostrar Datos</a>
        <a href="buscar.html">Buscar</a>
    </nav>

    <section>
        

        <table>
            <tr>
                <td class="typing-animation success-message">Datos eliminados correctamente....</td>
            </tr>
           
        </table>

        <?php
            $server = "localhost";
            $user = "root";
            $pass = "";
            $bd = "servicios";

            $conexion = mysqli_connect($server, $user, $pass, $bd) or die("Error en la conexion....");

            $numero_servicio = $_POST['numero_servicio'];
            mysqli_query($conexion, "DELETE FROM servicios  WHERE numero_servicio='$numero_servicio'")
            or die("Error al actualizar los datos");

            mysqli_close($conexion);
           
        ?>
    </section>

</body>
</html>
