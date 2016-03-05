<?php
/* Listado de pagos.
	@autor: Pedro Parra (edyjen@hotmail.com)
	@ver 1.00
*/

require_once("../kernel/database.php");
require_once("../kernel/controller.php");

if ($h->checkErrors()) {
	$h->showData();
	exit();
}

if (!$h->checkPermission(1)) {
	$h->showData();
	exit();
}

require_once("../class/pago.php");

$obj = new Pago($h);

$t = array_key_exists("t", $_POST) ? $_POST["t"] : "";
$p = array_key_exists("p", $_POST) ? $_POST["p"] : 1;

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

$h->setData("list", $obj->getArrayList($t, $p));
$h->setData("pagina", $obj->getPaginationInfo());
$h->setData("tipo", $t);
$h->showData();

?>