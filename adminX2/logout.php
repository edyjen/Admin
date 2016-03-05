<?php
/* Cerrar Sesión.
	@autor: Pedro Parra (edyjen@hotmail.com)
	@ver 1.00
*/

require_once("../kernel/database.php");
require_once("../kernel/controller.php");

if ($h->checkErrors()) {
	$h->showPage("template_adminform", "Administrador", "login");
	exit();
}

if (!$h->checkPermission(0)) {
	$h->showPage("template_admin", "Iniciar Sesión", "401");
	exit();
}

$h->session->destroy();

header("location: ./");

?>
