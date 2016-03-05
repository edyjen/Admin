<?php
/* Listado de pagos.
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
	$h->showPage("template_adminform", "Iniciar Sesión", "login");
	exit();
}

require_once("../class/pago.php");

$obj = new Pago($h);

$t = array_key_exists("t", $_GET) ? $_GET["t"] : "";
$p = array_key_exists("p", $_GET) ? $_GET["p"] : 1;

switch ($t) {
	default:
		$t = "En Espera";
		break;
	case "En Espera":
	case "Revisado":
	case "Enviado":
	case "Con Errores":
		break;
}

$h->setData("pago", $obj->getArrayList($t, $p));
$h->setData("tipo", $t);
$h->setData("pagina", $obj->getPaginationInfo());
$h->setData("tipos", $obj->getEstados());
$h->showPage("template_admin", "Administrador", "pago/listado");

?>