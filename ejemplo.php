<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
ob_start();
require('libreria/barra/code128.php');

//require('libreria/fpdf/fpdf.php');
	
		$pdf=new PDF_Code128('P', 'mm', array(55, 120));
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',8);
		$pdf->SetX(25);
		$pdf->Cell(10,1,'Estacionamiento ');
		$pdf->Ln();
		$pdf->SetX(25);
		$pdf->Cell(40,5,'Av azcuenaga 626');
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,0,'---------------------------------------------');
		//$pdf->Image('fotoAuto.png',2,4,20);
		$pdf->Ln();
		$pdf->SetX(7);
		$pdf->Cell(40,10,'TICKET DE SALIDA');
		$pdf->Ln();
		$pdf->SetX(7);
		$pdf->Cell(40,0,"horaEntrada");
		$pdf->Ln();
		$pdf->SetX(7);
		$pdf->Cell(40,10,"horaSalidaFormatoArgentino");
		$pdf->SetFont('Arial','B',20);
		$pdf->SetX(7);
		$pdf->Cell(40,35,"patente");
		$pdf->Ln();
		$pdf->SetX(10);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,0,"Ubicacion = ");
		$pdf->SetFont('Arial','B',9);
		$pdf->SetX(6);
		$pdf->Cell(40,25,"Total a abonar $");
		$pdf->SetX(2);
		$pdf->SetY(62);
		//$pdf->Cell(40,26,"*Conserve el ticket en buen estado*");
		//A set
		//$codigo = generarCodigoBarras(20);
		//$code='codigoBarra';  --->>> ESTO SI VA
		$pdf->Code128(2,90,"codigo",50,15);
		$pdf->SetXY(0,45);
		//$pdf->Write(5,'A set: "'.$code.'"');
		$pdf->Output();

?>