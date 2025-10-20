<?php
require_once '../fpdf/fpdf.php';
require_once '../FPDI/src/autoload.php';




$file = '../SCI/test2.pdf'; 
$text_image = '../assets/img/certifiedV7.png'; 
 
// Set source PDF file 
$pdf = new \setasign\Fpdi\Fpdi();
if(file_exists("./".$file)){ 
    $pagecount = $pdf->setSourceFile($file); 
}else{ 
    die('Source PDF not found!'); 
} 
 
// Add watermark image to PDF pages 
for($i=1;$i<=$pagecount;$i++){ 
    $tpl = $pdf->importPage($i); 
    $size = $pdf->getTemplateSize($tpl); 
    $pdf->addPage(); 
    $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], TRUE); 
     
    //Put the watermark 
    $xxx_final = ($size['width']-137); 
    $yyy_final = ($size['height']-210); 
    $pdf->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png'); 
} 
 
// Output PDF with watermark 
$pdf->Output();
/*$pdf->Output('F', $file);*/
?>