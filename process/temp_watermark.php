<?php
require_once '../fpdf/fpdf.php';
require_once '../FPDI/src/autoload.php';

function addWatermark($x, $y, $watermarkText, $angle, $pdf)
{
    $angle = $angle * M_PI / 180;
    $c = cos($angle);
    $s = sin($angle);
    $cx = $x * 1;
    $cy = (350 - $y) * 1;
    $pdf->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, - $s, $c, $cx, $cy, - $cx, - $cy));
    $pdf->Text($x, $y, $watermarkText);
    $pdf->_out('Q');
}

$pdf = new \setasign\Fpdi\Fpdi();
$fileInput = "../SCI/PT/Abolished/SCI-PT-1220/SCI-PT-1220-00.pdf";
$pages_count = $pdf->setSourceFile($fileInput);
for ($i = 1; $i <= $pages_count; $i ++) {
    $pdf->AddPage('O');
    $tplIdx = $pdf->importPage($i);
    $pdf->useTemplate($tplIdx, 0, 0);
    $pdf->SetFont('Times', 'B', 70);
    $pdf->SetTextColor(245, 17, 17);
    $watermarkText = 'ABOLISHED';
    addWatermark(80, 220, $watermarkText, 45, $pdf);
    $pdf->SetXY(25, 25);
}
$pdf->Output('F', $fileInput);
$pdf->close();
?>