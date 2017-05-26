<?php
//空白發文明細
include("connect.php");
header("Content-type: text/html; charset=utf-8");
require_once ('lib/tcpdf/tcpdf.php');
require_once('lib/tcpdf/config/lang/eng.php');
$IN= $session->getData();
$pdf = new TCPDF('P','mm','A4', true, 'UTF-8', false);
// ---------------------------------------------------------
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('edusongbig5', '', 20, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();
$pdf->setHeaderData(false);
$pdf->setPrintFooter(false);
//信封表頭
$pdf->SetFont('edusongbig5', '', 14, '', true);
$pdf->SetXY(33.0, 15.0);
$pdf->Write(5, '', '');
$pdf->SetXY(90.0, 15.0);
$pdf->Write(5, '先生/小姐  啟', '');
$pdf->SetFont('edusongbig5', '', 12, '', true);
$pdf->SetXY(166.0, 35.0);
$pdf->Write(1, '' ,'');
$pdf->SetFont('edusongbig5', '', 14, '', true);
$pdf->SetXY(33.0, 30.0);
$pdf->Write(5, '', '');
$pdf->SetXY(162.0, 45.0);
$pdf->Write(1, '', '');
$pdf->SetXY(10.0, 55.0);
$pdf->Cell(190, 1, '', 'T', 2, 'L', false);
//發文內容	
$pdf->SetFont('edusongbig5', '', 16, '', true);
$pdf->setxy(10.0,65.0);
$pdf->multicell(195, 1, $IN, 0,'L',0);
$pdf->Output('issued.pdf', 'I');
?>