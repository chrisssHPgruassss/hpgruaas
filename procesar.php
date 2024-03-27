<?php

require('fpdf.php');
$elementosInventario = [
    'RADIO', 'ESPEJO RETROVISOR', 'LIMPIADORES', 'CRISTALES', 'ESPEJOS LATERALES', 'LLANTAS DE REFACCION',
    'GATO', 'TAPON DE GASOLINA', 'TAPETES', 'CUARTOS', 'BASTON DE SEGURIDAD', 'ANTENA', 'MOLDURAS COMPLETAS',
    'TRIANGULOS DE SEGURIDAD', 'HERRAMIENTAS', 'CALAVERAS', 'EXTINTOR', 'CABLES PASA CORRIENTE', 'EMBLEMAS',
    'ENCENDEDOR', 'BIRLOS DE SEGURIDAD', 'BATERIA', 'TARJETA DE SEGURIDAD'
];

class PDF extends FPDF
{
    
    function Header()
    {
        // Logo de HP
        $this->Image('hp_logo.jpg', 10, 10, 40);

        // Titulo principal
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'ORDEN DE TRABAJO DE SERVICIOS', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, 'DE REPARACION Y MANTENIMIENTO DE VEHICULOS', 0, 1, 'C');

        // Direccion de la sucursal
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 5, 'Sucursal carretera km 7.5 Amomolulco Xonacatlan Col.Simulacro', 0, 1, 'C');
        $this->Cell(0, 5, 'Sta. Ma. Atarasquillo, Edo. de, Lerma, Mexico', 0, 1, 'C');

        // Horarios y telefonos
        $this->Cell(0, 5, 'Horarios de Atencion: Lunes a Viernes 9:00 am - 6:00 pm, Sabado 9:00 am - 4:00 pm', 0, 1, 'C');
        $this->Cell(0, 5, 'Telefonos de Atencion: 7282811816, 7223301175', 0, 1, 'C');

        $this->SetDrawColor(0, 0, 0);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5); 
    }
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "servicios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['guardar'])) {
        
        $numero_servicio = $_POST["numero_servicio"];
        $fecha = $_POST["fecha"];
        $nombre_cliente = $_POST["nombre_cliente"];
        $telefono = $_POST["telefono"];
        $falla_detectada = $_POST["falla_detectada"];
        $unidad = $_POST["unidad"];
        $costo = $_POST["costo"];
        $gasto = $_POST["gasto"];

        
        $sql = "INSERT INTO servicios (numero_servicio, fecha, nombre_cliente, telefono, falla_detectada, unidad, costo, gasto) VALUES ('$numero_servicio', '$fecha', '$nombre_cliente', '$telefono', '$falla_detectada', '$unidad', $costo, $gasto)";

        if ($conn->query($sql) === TRUE) {
            
            echo "Los datos se han guardado correctamente en la base de datos.";
        } else {
            
            echo "Error al guardar los datos en la base de datos: " . $conn->error;
        }
    } elseif (isset($_POST['generar_pdf'])) {
       
        $pdf = new PDF();

$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);


$pdf->Cell(0, 1, '', 0, 1);


$pdf->Cell(20, 7, 'N0. de Servicio:', 1, 0);
$pdf->Cell(20, 7, $_POST["numero_servicio"], 1, 0);


$pdf->Cell(20, 7, 'Fecha:', 1, 0);
$pdf->Cell(20, 7, $_POST["fecha"], 1, 1);


$pdf->Cell(0, 8, 'Informacion del Cliente:', 0, 1);

$pdf->Cell(44, 8, 'Nombre:', 1, 0);
$pdf->Cell(44, 8, $_POST["nombre_cliente"], 1, 1);

$pdf->Cell(44, 8, 'Telefono:', 1, 0);
$pdf->Cell(44, 8, $_POST["telefono"], 1, 1);



$pdf->Cell(88, 8, 'Hora de entrega de la unidad:', 1, 1, 'C');
$pdf->Cell(88, 8, $_POST["hora_entrega"], 1, 1, 'C');


$pdf->SetY($pdf->GetY() -30); 
$pdf->SetX(10);

$pdf->SetY($pdf->GetY() - 10); 
$pdf->SetX(100); 
$pdf->Cell(0, 8, 'Datos de la unidad:', 0, 1);
$pdf->SetX(100); 
$pdf->Cell(76, 8, 'Unidad:', 1, 1, 'C');
$pdf->SetX(100); 
$pdf->Cell(76, 8, $_POST["unidad"], 1, 1, 'C');

$pdf->SetX(100); 
$pdf->Cell(38, 8, 'Costo:', 1, 0);
$pdf->Cell(38, 8, $_POST["costo"], 1, 1);

$pdf->SetX(100); 
$pdf->Cell(38, 8, 'Placas:', 1, 0);
$pdf->Cell(38, 8, $_POST["placas"], 1, 1);




$pdf->Cell(0, 2, '', 0, 1);




$pdf->Cell(190, 8, 'Falla Detectada:', 1, 1, 'C');

$pdf->MultiCell(190, 8, $_POST["falla_detectada"], 1, 1,);


$pdf->Cell(0, 10, 'Elementos del Inventario:', 0, 1, 'C');

$numColumnas = 4; 
$columnWidth = 50; 
$font_size = 7; 

foreach ($elementosInventario as $key => $elemento) {
    if ($key % $numColumnas == 0 && $key > 0) {
        $pdf->Ln();
    }
    $marcado = in_array($elemento, $_POST["inventario"]) ? 'X' : ''; 
    $pdf->SetFont('Arial', '', $font_size);
    $pdf->Cell($columnWidth, 10, '[' . $marcado . '] ' . $elemento, 0, 0);
}


$pdf->Image('C:\xampp\htdocs\xampp\pruebas/image1.jpg', 50, 190, 50, 0); 
$pdf->Image('C:\xampp\htdocs\xampp\pruebas/image2.jpg', 110, 200, 50, 0);

$pdf->Cell(0, 60, '', 0, 1);
$pdf->Cell(0, 10, '', 0, 1);
$pdf->Cell(55, 16, 'Firma del Cliente: ____________________', 0, 0);
$pdf->Cell(70, 16, 'Firma de Recepcion en Taller: ____________________', 0, 0);
$pdf->Cell(55, 16, 'Mecanico a Cargo de la Unidad: ____________________', 0, 0);


$pdf->Output('D', 'orden_trabajo.pdf');


    }
}


$conn->close();
?>
