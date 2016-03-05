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

$arrayId = explode("|", $_GET["id"]);

foreach ($arrayId as $index => $myId) {
	if (!$obj->loadNoMediaDb($myId)) {
		$h->showData();
		exit();
	}

	$miTipo = $obj->getIdEstado();
	$h->setData("tipo", $miTipo);

	$a = array_key_exists("a", $_GET) ? $_GET["a"] : "";


	if (!$obj->updateEstado($obj->searchIdEstado($a))) {
		$h->setData("obj", $obj->toArray());
		$h->showData();
		exit();
	}

	if ($a == "Revisado") {
		$obj->sendMailAccepted();
	}

	if ($a == "Con Errores") {
		$obj->sendMailError();
	}

	if ($a == "Enviado") {
		if (!$obj->setEnvio($_POST)) {
			$obj->restoreEstado($miTipo);
			$h->setData("obj", $obj->toArray());
			$h->showData();
			return;
		}

		if (!$obj->sendMailDelivered()) {
			$h->setData("envio", $obj->getEnvio());
			$h->setData("obj", $obj->toArray());
			$h->showData();
			return;
		}
	}
}

$h->setData("envio", $obj->getEnvio());
$h->setData("obj", $obj->toArray());
$h->showData();

?>
