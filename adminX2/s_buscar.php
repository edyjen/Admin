<?php
/* Mover Pago de categoría.
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

$h->setData("list", $obj->searchText($_POST["buscar"]));
$h->showData();

?>
