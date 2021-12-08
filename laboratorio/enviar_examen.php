<?php
require_once 'conexion.php';
require_once 'autorizacion.php';

$examen_id = mysqli_real_escape_string($conexion, $_GET['id']);

$resultado = mysqli_query($conexion,
    "SELECT e.*, pac.email, pac.cedula, pac.nombre, pac.apellido FROM examenes e JOIN pacientes pac ON e.paciente_id = pac.id WHERE e.id = '$examen_id'");

if (!$resultado) {
    $_SESSION['mensaje'] = mysqli_error($conexion);
    header('Location: index.php');
    die();
}

$examen = mysqli_fetch_assoc($resultado);

if (!$examen) {
    header('Location: index.php');
    die();
}

// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;

// attachment name
$filename = "{$examen['cedula']}-{$examen['fecha']}.pdf";

// a random hash will be necessary to send mixed content
$separator = md5(time());


require_once 'fpdf184/fpdf.php';

$fpdf = new FPDF();
$fpdf->AddPage();
$fpdf->SetFont('Arial','B', 12);
$y = $fpdf->GetY();
$x = $fpdf->GetX();
$fpdf->Cell(160, 25, "Paciente: {$examen['nombre']} {$examen['apellido']}");
$fpdf->SetXY($x, $y +5);
$fpdf->Cell(85, 25, utf8_decode("Cédula: {$examen['cedula']}"));
$fpdf->SetFont('Arial','B', 12);
$fpdf->SetXY(0, $y+10);
$fpdf->Cell(210, 25, "RESULTADOS DEL EXAMEN #{$examen['id']} ({$examen['tipo_examen']})",
    0, 0, 'C');
$fpdf->SetXY(0, $y+20);
$fpdf->SetFont('Arial','B', 10);
$fpdf->Cell(10, 25);
$fpdf->Cell(80, 25, utf8_decode('PROCEDIMIENTO'));
$fpdf->SetXY(0, $y+35);
$fpdf->SetFont('Arial','', 10);
$fpdf->Cell(10, 25);
$fpdf->MultiCell(80, 25, utf8_decode($examen['procedimiento']), 'R');
$fpdf->SetFont('Arial','B', 10);
$fpdf->SetXY(80, $y+20);
$fpdf->Cell(80, 10);
$fpdf->Cell(110, 25, utf8_decode('RESULTADOS'));
$y = $fpdf->GetY();
$fpdf->SetFont('Arial','', 10);
$fpdf->SetXY(105, $y+25);
$fpdf->Cell(10, 25);
$fpdf->SetFillColor(235, 233, 233);
$fpdf->MultiCell(110, 25, utf8_decode($examen['resultados']), 0, 'J', true);
$pdf = $fpdf->Output('', 'S');

$attachment = chunk_split(base64_encode($pdf));

$message = '';

$from = 'luisaranaga13@gmail.com';

$body = "--" . $separator . $eol;
$body .= "Content-Transfer-Encoding: 7bit" . $eol . $eol;
$body .= "Hola, {$examen['nombre']} {$examen['apellido']} ! Estos son los resultados de su examen." . $eol;

// message
$body .= "--" . $separator . $eol;
$body .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
$body .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
$body .= $message . $eol;

// attachment
$body .= "--" . $separator . $eol;
$body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
$body .= "Content-Transfer-Encoding: base64" . $eol;
$body .= "Content-Disposition: attachment" . $eol . $eol;
$body .= $attachment . $eol;
$body .= "--" . $separator . "--";

// main header
$headers  = "From: " . $from . $eol;
$headers .= "MIME-Version: 1.0" . $eol;
$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"";

$resultado = mail(
    $examen['email'],
    "RESULTADOS DE EXAMEN DEL {$examen['fecha']}",
    $body,
    $headers
);

if (!$resultado) {
    $_SESSION['mensaje'] = "Resultados no pudieron ser enviados";
    header('Location: index.php');
    die();
}

$_SESSION['mensaje'] = "Resultados enviados";
header('Location: index.php');
die();