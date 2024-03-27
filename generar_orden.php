<?php
require('fpdf.php');

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

        // Linea divisoria
        $this->SetDrawColor(0, 0, 0);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(10); 
    }

    // Pie de pagina
    function Footer()
    {
        // Texto de pie de pagina
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, '© 2023 HP. Todos los derechos reservados.', 0, 0, 'C');
    }

    // imagenes y las firmas
    function AddImageAndSignatures($image1, $image2, $client_signature, $workshop_signature, $mechanic_name)
    {
        
        $this->Cell(0, 10, '', 0, 1);
        $this->Image($image1, 20, $this->GetY(), 40);
        $this->Image($image2, 70, $this->GetY(), 40);
        $this->Ln(50); 

        // Espacio para nombres
        $this->Cell(40, 10, $client_signature, 0);
        $this->Cell(40, 10, $workshop_signature, 0);
        $this->Cell(40, 10, $mechanic_name, 0);
    }

    // Agregar tabla con bordes para los datos del cliente, datos de la unidad, orden de trabajo y fecha
    function AddDataTables($data_cliente, $data_unidad, $orden_trabajo, $fecha)
    {
        // Datos de Orden de trabajo y fecha
        $data_orden_trabajo_fecha = [
            [['Orden de Trabajo:', $orden_trabajo], ['Fecha:', $fecha]],
        ];

        
        $cell_width = 20;
        $font_size = 7;

        
        $this->SetFont('Arial', '', $font_size);

        foreach ($data_orden_trabajo_fecha as $row) {
            foreach ($row as $item) {
                $this->Cell($cell_width, 10, utf8_decode($item[0]), 1);
                $this->Cell($cell_width, 10, utf8_decode($item[1]), 1);
            }
            $this->Ln()
        }
        $this->Ln(5);

        $this->SetFont('Arial', '', 8);

       
        $cell_width = 50;
        $font_size = 8; 

       
        $this->SetFont('Arial', '', $font_size);

    // Datos de cliente
foreach ($data_cliente as $row) {
    foreach ($row as $item) {
        $this->Cell($cell_width, 8, utf8_decode($item[0]), 1);
        $this->Cell($cell_width, 8, utf8_decode($item[1]), 1);
    }
    $this->Ln(); 
}

$this->Ln(5); 

// Datos de unidad
foreach ($data_unidad as $row) {
    foreach ($row as $item) {
        $this->Cell($cell_width, 8, utf8_decode($item[0]), 1);
        $this->Cell($cell_width, 8, utf8_decode($item[1]), 1);
    }
    $this->Ln(); 
}
$this->Ln(5); 

        // Seccion de descripcion de la falla o problema reportado
        $descripcion_falla = 'Falla ';

        // Generar la seccion de descripcion
        $this->Cell(0, 10, 'Descripcion de la Falla o Problema Reportado', 1, 1);
        $this->MultiCell(0, 10, utf8_decode($descripcion_falla), 1, 1);

        
        $this->Ln(5);

        // Titulo "Inventario Vehicular"
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 5, 'Inventario Vehicular', 0, 1, 'C');

        
        $inventario_items = [
            "RADIO", "ESPEJO RETROVISOR", "LIMPIADORES", "CRISTALES", "ESPEJOS LATERALES",
            "LLANTAS DE REFACCION", "GATO", "TAPON DE GASOLINA", "TAPETES", "CUARTOS",
            "BASTON DE SEGURIDAD", "ANTENA", "MOLDURAS COMPLETAS", "TRIANGULOS DE SEGURIDAD",
            "HERRAMIENTAS", "CALAVERAS", "EXTINTOR", "CABLES PASA CORRIENTE", "EMBLEMAS",
            "ENCENDEDOR", "BIRLOS DE SEGURIDAD", "BATERIA", "TARJETA DE SEGURIDAD"
        ];

      
        $num_columns = 4; 
        $column_width = 50;
$column_height = 30;
        $this->SetFillColor(192, 192, 192); 
        $this->SetDrawColor(0, 0, 0);

        for ($i = 0; $i < count($inventario_items); $i++) {
            if ($i % $num_columns == 0) {
                $this->Ln();
            }
            $this->Cell($column_width, 10, '[_] ' . utf8_decode($inventario_items[$i]), 1, 0, 'L', 1); 
        }

        
        $this->Ln(5);

        
        $image1 = 'image1.jpg'; 
        $image2 = 'image2.jpg';
        $client_signature = 'Firma del Cliente: ____________________';
        $workshop_signature = 'Firma de Recepcion en Taller: ____________________';
        $mechanic_name = 'Mecanico a Cargo de la Unidad: ____________________';

        $this->AddImageAndSignatures($image1, $image2, $client_signature, $workshop_signature, $mechanic_name);
    }

    function Table($data, $cell_width, $cell_height, $border)
    {
        foreach ($data as $row) {
            foreach ($row as $item) {
                $this->Cell($cell_width, $cell_height, utf8_decode($item[0]), $border);
                $this->Cell(0, $cell_height, utf8_decode($item[1]), $border, 1);
            }
        }
        $this->Ln(10);
    }
}


$pdf = new PDF();
$pdf->AddPage();


$pdf->SetFont('Arial', '', 12);


$numero_servicio = '12345';
$fecha = '2023-10-06';


$unidad = 'Jetta';
$placas = 'ABC123';
$costo = '$100.00';


$data_cliente = [
    [['Nombre del Cliente:', 'John Doe']],
    [['Telefono:', '123-456-7890']],
    [['Hora y Fecha de Entrega de la Unidad:', '2023-10-10 10:00 AM']],
];


$data_unidad = [
    [['Unidad:', $unidad]],
    [['Placas:', $placas]],
    [['Costo:', $costo]],
];


$pdf->AddDataTables($data_cliente, $data_unidad, $numero_servicio, $fecha);


$pdf->Output();

