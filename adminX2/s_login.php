<?php
/* Iniciar Sesión.
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

require_once("../class/usuario.php");

$obj = new Usuario($h);

if (!$obj->login($_POST)) {
	$h->session->loginFailed();
	$h->setMessage("LOGIN_FAILED", "El nombre de usuario y/o contraseña no coinciden");
	$h->showData();
	exit();
}

$h->session->registerArray($obj->toArray());
$h->showData();

?>
