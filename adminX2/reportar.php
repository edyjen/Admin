<?php
/* Abrir reporte de envíos.
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

if (!$obj->loadNoMediaDb($_GET["id"])) {
	$h->showPage("template_admin", "Administrador", "pago/listado");
	exit();
}

$h->setData("tipo", $obj->getDescripcionEstado());
$h->setData("obj", $obj->toArray());
$h->showPage("template_adminform", "Administrador", "envio/reportar");
exit();

?>
