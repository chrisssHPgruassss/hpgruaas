<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario CSS M3S3</title>
    <link rel="stylesheet" href="mos.css">
</head>
<body>

    <header>
        <h1>RELACION DE SERVICIOS REALIZADOS</h1>
    </header>

   
    <nav>
        <a href="graficas.html">Ingresar Datos</a>
        <a href="editar.html">Editar</a>
        <a href="borrar.html">Borrar</a>
        <a href="mostrar.html">Mostrar Datos</a>
        <a href="buscar.html">Buscar</a>
    </nav>

    <main>
        <?php
        $server = "localhost";
        $user = "root";
        $pass = "";
        $bd = "servicios";

        $conexion = mysqli_connect($server, $user, $pass, $bd) or die("Error en la conexión");

        $consulta = mysqli_query($conexion, "SELECT * FROM servicios") or die("Error al consultar los datos...");

        echo '<table>';
        echo '<tr>';
        echo '<th>Numero de Servicio</th>';
        echo '<th>Fecha</th>';
        echo '<th>Nombre del Cliente</th>';
        echo '<th>Telefono</th>';
        echo '<th>Falla Detectada</th>';
        echo '<th>Unidad</th>';
        echo '<th>Costo</th>';
        echo '<th>Gasto</th>';
        echo '</tr>';

        $totalCostos = 0;
        $totalGastos = 0;

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

            $totalCostos += $extraido['costo'];
            $totalGastos += $extraido['gasto'];
        }

        $totalNeto = $totalCostos - $totalGastos;

        echo '<tr>';
        echo '<td colspan="6"><b>Total de Costos:</b></td>';
        echo '<td>' . $totalCostos . '</td>';
        echo '<td>' . $totalGastos . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="7"><b>Total Neto:</b></td>';
        echo '<td>' . $totalNeto . '</td>';
        echo '</tr>';
        echo '</table>';
        mysqli_close($conexion);
        ?>

        <div id="chart-container">
            <canvas id="myChart"></canvas>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var ctx = document.getElementById('myChart').getContext('2d');

            var totalCostos = <?php echo $totalCostos; ?>;
            var totalGastos = <?php echo $totalGastos; ?>;
            var totalNeto = <?php echo $totalNeto; ?>;

            var chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Total de Costos', 'Total de Gastos', 'Total Neto'],
                    datasets: [{
                        label: 'Monto',
                        data: [totalCostos, totalGastos, totalNeto],
                        backgroundColor: ['#66c2ff', '#ff9999', '#c2f0c2'],
                        borderColor: ['#3399ff', '#ff6666', '#8fd19e'],
                        borderWidth: 1
                    }]
                }
            });
        </script>
    </main>

</body>
</html>
