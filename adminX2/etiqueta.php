<?php
/* Generar etiqueta en pdf.
	@autor: Pedro Parra (edyjen@hotmail.com)
	@ver 1.00
*/

require_once("../kernel/database.php");
require_once("../kernel/controller.php");

if ($h->checkErrors()) {
	$h->showPage("template_adminform", "Administrador", "login");
	exit();
}

if (!$h->checkPermission(1)) {
	$h->showPage("template_adminform", "Administrador", "login");
	exit();
}

require_once("../class/pago.php");

$obj = new Pago($h);

$arrayId = explode("|", $_GET["id"]);

require_once("../class/fpdf.php");

$fontFamily = "Arial";
$titleFontSize = 14;
$fontSize = 12;
$titleStyle = "B";
$textStyle = "";
$textHeight = 6;

$pdf = new FPDF();

foreach ($arrayId as $index => $myId) {
	if ($index % 4 == 0) {
		$pdf->AddPage();
		$pdf->SetY(26);
	}
	
	if (!$obj->loadNoMediaDb($myId)) {
		$h->showPage("template_admin", "Administrador", "pago/listado");
		exit();
	}

	$data = $obj->toArray();

	$pdf->SetFont($fontFamily, $titleStyle, $titleFontSize);
	$pdf->CellWrite(0, $textHeight, "Etiqueta para envíos", 0, 0, "C");

	$pdf->SetFont($fontFamily, $titleStyle, $fontSize);
	$pdf->Write($textHeight, "Nombre: ");
	$pdf->SetFont($fontFamily, $textStyle, $fontSize);
	$pdf->Write($textHeight, $data["RECIBE_NAC"] . "-" . $data["RECIBE_ID"] . " " . $data["RECIBE_NOMBRE"]);
	$pdf->Ln();

	$pdf->SetFont($fontFamily, $titleStyle, $fontSize);
	$pdf->Write($textHeight, "Usuario de Mercadolibre: ");
	$pdf->SetFont($fontFamily, $textStyle, $fontSize);
	$pdf->Write($textHeight, $data["USUARIO_MERCADOLIBRE"]);
	$pdf->Ln();

	$pdf->SetFont($fontFamily, $titleStyle, $fontSize);
	$pdf->Write($textHeight, "Producto: ");
	$pdf->SetFont($fontFamily, $textStyle, $fontSize);
	$pdf->Write($textHeight, "(" . $data["ARTICULO_CANTIDAD"] . ") " . $data["ARTICULO_NOMBRE"]);
	$pdf->Ln();

	$pdf->SetFont($fontFamily, $titleStyle, $fontSize);
	$pdf->Write($textHeight, "Teléfono: ");
	$pdf->SetFont($fontFamily, $textStyle, $fontSize);
	$pdf->Write($textHeight, $data["RECIBE_TELEFONO"]);
	$pdf->Ln();

	$pdf->SetFont($fontFamily, $titleStyle, $fontSize);
	$pdf->Write($textHeight, "Dirección: ");
	$pdf->SetFont($fontFamily, $textStyle, $fontSize);
	$pdf->Write($textHeight, $data["RECIBE_DIRECCION"] . " Estado " . $data["RECIBE_ESTADO"] . ", Ciudad " . $data["RECIBE_CIUDAD"] . ", Municipio " . $data["RECIBE_MUNICIPIO"]);
	$pdf->Ln();

	$pdf->SetFont($fontFamily, $titleStyle, $fontSize);
	$pdf->Write($textHeight, "Agencia de Envíos: ");
	$pdf->SetFont($fontFamily, $textStyle, $fontSize);
	$pdf->Write($textHeight, $data["RECIBE_EMPRESA"]);
	$pdf->Ln();

	$pdf->SetFont($fontFamily, $titleStyle, $fontSize);
	$pdf->Write($textHeight, "Envío Asegurado: ");
	$pdf->SetFont($fontFamily, $textStyle, $fontSize);
	$pdf->Write($textHeight, $data["RECIBE_ASEGURADO"]);
	$pdf->Ln();
}

$pdf->Output("etiqueta.pdf", "I");

?>