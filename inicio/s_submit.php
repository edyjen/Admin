<?php
/* Registrar Pago.
	@autor: Pedro Parra (edyjen@hotmail.com)
	@ver 1.00
*/

require_once("../kernel/database.php");
require_once("../kernel/controller.php");

if ($h->checkErrors()) {
	$h->showData();
	exit();
}

if (!$h->checkPermission(0)) {
	$h->showData();
	exit();
}

if (!$h->checkCaptcha($_POST["captcha"])) {
	$h->generateCaptcha();
	$h->showData();
	exit();
}

if (!array_key_exists("ID_PAGO", $_POST)) {
	$h->generateCaptcha();
	$h->showData();
	exit();
}

require_once("../class/pago.php");

$obj = new Pago($h);

$obj->setHtmlArray($_POST);
$obj->setDefaults();

$h->setData("form", $obj->toArray());

if ($_POST["PAGO_EXT"] != "") {
	if (!$obj->addMedia($_FILES["PAGO_ARCHIVO"])) {
		$h->generateCaptcha();
		$h->showData();
		exit();
	}
}

if ($obj->canBeSaved()) {
	if ($obj->saveDb()) {
		$obj->sendMailReceived();
	}
}

$h->generateCaptcha();
$h->showData();

?>
