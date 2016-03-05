<?php
/* Abrir Registro de Pago.
	@autor: Pedro Parra (edyjen@hotmail.com)
	@ver 1.00
*/

require_once("../kernel/controller.php");

if ($h->checkErrors()) {
	$h->showPage("template_form", "Registro de Pago", "pago/registro");
	exit();
}

if (!$h->checkPermission(0)) {
	$h->showPage("template_form", "Registro de Pago", "401");
	exit();
}

$info = $h->getInfo();
$h->setData("bancos", $info["bancos"]);
$h->setData("envios", $info["envios"]);

$h->generateCaptcha();
$h->showPage("template_form", "Registro de Pago", "pago/registro");

?>