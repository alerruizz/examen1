<?php
require_once('tcpdf/tcpdf.php'); // Ajusta la ruta si es necesario

// Crear instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator('Creator');
$pdf->SetAuthor('Author');
$pdf->SetTitle('Lista de Expedientes (PDF)');
$pdf->SetSubject('Lista de Expedientes');
$pdf->SetKeywords('TCPDF, PDF, expedientes');

// Agregar una página
$pdf->AddPage();

// Contenido del PDF
$html = '<h1 style="text-align: center;">Lista de Expedientes</h1>';
$html .= '<table style="border-collapse: collapse; width: 100%;" border="1">';
$html .= '<tr>';
$html .= '<th style="padding: 8px; text-align: left;">Apellido 1</th>';
$html .= '<th style="padding: 8px; text-align: left;">Apellido 2</th>';
$html .= '<th style="padding: 8px; text-align: left;">Nombre</th>';
$html .= '<th style="padding: 8px; text-align: left;">Email</th>';
$html .= '<th style="padding: 4px; text-align: left;">Foto</th>';
$html .= '</tr>';

// Conexión a la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bdTarea2";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener los expedientes
    $sql = "SELECT * FROM Expedientes";
    $stmt = $conn->query($sql);

    // Llenar la tabla con datos
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nombres = $row['nombres'];
        $datosNombres = explode(' ', $nombres); // Dividir el campo nombres en un array
    
        // Definir variables para apellidos y nombres
        $apellido1 = isset($datosNombres[0]) ? $datosNombres[0] : '-';
        $apellido2 = isset($datosNombres[1]) ? $datosNombres[1] : '-';
        $nombresIndividuales = isset($datosNombres[2]) ? implode(' ', array_slice($datosNombres, 2)) : '-';


        $html .= '<tr>';
        $html .= '<td style="border: 1px solid #dddddd; padding: 8px;">' . $nombresIndividuales. '</td>';
        $html .= '<td style="border: 1px solid #dddddd; padding: 8px;">' . $apellido2 . '</td>';
        $html .= '<td style="border: 1px solid #dddddd; padding: 8px;">' . $apellido1 . '</td>';
        $html .= '<td style="border: 1px solid #dddddd; padding: 8px;">' . $row['email'] . '</td>';
        $html .= '<td style="border: 1px solid #dddddd; padding: 4px; text-align: center;">';
        $imagePath = $row['foto']; // Ruta de la imagen
        $html .= '<img src="' . $imagePath . '" style="width: 30px; height: 30px; margin: 0; padding: 0;">'; // Ajusta el tamaño si es necesario
        $html .= '</td>';
        $html .= '</tr>';
    }

    $conn = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$html .= '</table>';

// Escribir el contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Nombre del archivo PDF generado
$filename = 'lista_expedientes.pdf';

// Salida del PDF (descarga o visualización)
$pdf->Output($filename, 'D'); // 'D' para descargar, 'I' para mostrar en el navegador