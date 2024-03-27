<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "pagos";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("La conexión a la base de datos ha fallado: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["completarPago"])) {
        
        $idPago = $_POST["idPago"];
        $sqlMoveToCompleted = "INSERT INTO pagos_completados (empresa_persona, monto, motivo, fecha_pago) SELECT empresa_persona, monto, motivo, fecha_pago FROM pagos_pendientes WHERE id = $idPago";
        $conn->query($sqlMoveToCompleted);

        
        $sqlDeleteFromPending = "DELETE FROM pagos_pendientes WHERE id = $idPago";
        $conn->query($sqlDeleteFromPending);

        echo "Pago completado y movido a la tabla de pagos completados.";
    } elseif (isset($_POST["pagosVarios"])) {
       
        $idPago = $_POST["idPago"];
        echo "Lógica de Pagos Varios aún no implementada.";
    } elseif (isset($_POST["editarPago"])) {
        
        $idPago = $_POST["idPago"];
        $sqlEditar = "SELECT * FROM pagos_pendientes WHERE id = $idPago";
        $resultEditar = $conn->query($sqlEditar);
        if ($resultEditar->num_rows > 0) {
            $row = $resultEditar->fetch_assoc();
         
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('editarPagoModal', " . json_encode($row) . ");
                    });
                </script>";
        }
    } else {
        
        $empresaPersona = $_POST["empresaPersona"];
        $monto = $_POST["monto"];
        $motivo = $_POST["motivo"];
        $fechaPago = $_POST["fechaPago"];

        
        $sqlInsert = "INSERT INTO pagos_pendientes (empresa_persona, monto, motivo, fecha_pago) VALUES ('$empresaPersona', $monto, '$motivo', '$fechaPago')";

        if ($conn->query($sqlInsert) === TRUE) {
            echo "Pago agregado con éxito.";
        } else {
            echo "Error al agregar el pago: " . $conn->error;
        }
    }
}


$sqlPending = "SELECT * FROM pagos_pendientes";
$resultPending = $conn->query($sqlPending);


$sqlCompleted = "SELECT * FROM pagos_completados";
$resultCompleted = $conn->query($sqlCompleted);


$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pagos Pendientes</title>
    <link rel="stylesheet" href="pagos.css">
</head>

<body>
    <div id="nav">
        <a href="index.html">Regresar</a>
        <a href="graficas.html">Registro Servicios</a>
        <a href="pagos.php">Pagos</a>
        <a href="pagina.php">Actualiza</a>
    </div>

    <div class="container">
        <h2>Pagos Pendientes H.P</h2>

        <form class="payment-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="empresaPersona">Empresa/Persona:</label>
            <input type="text" id="empresaPersona" name="empresaPersona" required>

            <label for="monto">Monto:</label>
            <input type="number" id="monto" name="monto" required>

            <label for="motivo">Motivo:</label>
            <textarea id="motivo" name="motivo" rows="4" required></textarea>

            <label for="fechaPago">Fecha de pago:</label>
            <input type="date" id="fechaPago" name="fechaPago" required>

            <button type="submit">Agregar Pago</button>
        </form>

        <h3>Pagos Pendientes</h3>
        <table class="payment-table">
            <tr>
                <th>Fecha Generación</th>
                <th>Empresa/Persona</th>
                <th>Monto</th>
                <th>Motivo</th>
                <th>Fecha de Pago</th>
                <th>Acciones</th>
            </tr>
            <?php
            
            if ($resultPending->num_rows > 0) {
                while ($row = $resultPending->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row["fecha_generacion"]}</td>
                            <td>{$row["empresa_persona"]}</td>
                            <td>{$row["monto"]}</td>
                            <td>{$row["motivo"]}</td>
                            <td>{$row["fecha_pago"]}</td>
                            <td>
                                <div class='action-buttons'>
                                    <form method='post' action='{$_SERVER["PHP_SELF"]}'>
                                        <input type='hidden' name='completarPago' value='1'>
                                        <input type='hidden' name='idPago' value='{$row["id"]}'>
                                        <button type='submit'>Completado</button>
                                    </form>
                                    <form method='post' action='{$_SERVER["PHP_SELF"]}'>
                                        <input type='hidden' name='pagosVarios' value='1'>
                                        <input type='hidden' name='idPago' value='{$row["id"]}'>
                                        <button type='submit'>Pagos Varios</button>
                                    </form>
                                    <form method='post' action='{$_SERVER["PHP_SELF"]}'>
                                        <input type='hidden' name='editarPago' value='1'>
                                        <input type='hidden' name='idPago' value='{$row["id"]}'>
                                        <button type='submit'>Editar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay pagos pendientes.</td></tr>";
            }
            ?>
        </table>

        <h3>Pagos Completados</h3>
        <table class="payment-table">
            <tr>
                <th>Fecha Completado</th>
                <th>Empresa/Persona</th>
                <th>Monto</th>
                <th>Motivo</th>
                <th>Fecha de Pago</th>
            </tr>
            <?php
            
            if ($resultCompleted->num_rows > 0) {
                while ($row = $resultCompleted->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row["fecha_completado"]}</td>
                            <td>{$row["empresa_persona"]}</td>
                            <td>{$row["monto"]}</td>
                            <td>{$row["motivo"]}</td>
                            <td>{$row["fecha_pago"]}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay pagos completados.</td></tr>";
            }
            ?>
        </table>
    </div>

    
    <div id="editarPagoModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal('editarPagoModal')">&times;</span>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="editarEmpresaPersona">Empresa/Persona:</label>
                <input type="text" id="editarEmpresaPersona" name="empresaPersona" required>

                <label for="editarMonto">Monto:</label>
                <input type="number" id="editarMonto" name="monto" required>

                <label for="editarMotivo">Motivo:</label>
                <textarea id="editarMotivo" name="motivo" rows="4" required></textarea>

                <label for="editarFechaPago">Fecha de pago:</label>
                <input type="date" id="editarFechaPago" name="fechaPago" required>

                <input type="hidden" name="editarPago" value="1">
                <input type="hidden" name="idPago" id="editarIdPago">
                <button type="submit">Guardar Cambios</button>
            </form>
            <button onclick="hideModal('editarPagoModal')">Cancelar</button>
        </div>
    </div>

    <script>
        function showModal(modalId, rowData) {
            
            document.getElementById(modalId).style.display = "block";

            document.getElementById('editarEmpresaPersona').value = rowData.empresa_persona;
            document.getElementById('editarMonto').value = rowData.monto;
            document.getElementById('editarMotivo').value = rowData.motivo;
            document.getElementById('editarFechaPago').value = rowData.fecha_pago;
            document.getElementById('editarIdPago').value = rowData.id;
        }

        function hideModal(modalId) {
            
            document.getElementById(modalId).style.display = "none";
        }
    </script>
</body>

</html>

