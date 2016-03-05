<?php
/* Listado de pagos.
	@autor: Pedro Parra (edyjen@hotmail.com)
	@ver 1.00
*/

require_once("../kernel/controller.php");

if ($h->checkErrors()) {
	$h->showPage("template_adminform", "Administrador", "login");
	exit();
}

if (!$h->checkPermission(1)) {
	$h->showPage("template_adminform", "Iniciar Sesión", "login");
	exit();
}

$h->showPage("template_adminform", "Administrador", "cambiarpass");

?>