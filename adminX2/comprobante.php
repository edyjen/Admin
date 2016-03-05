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

if (!$obj->loadMediaDb($_GET["id"])) {
	$h->showPage("template_admin", "Administrador", "pago/listado");
	exit();
}

$obj->showMedia();

?>