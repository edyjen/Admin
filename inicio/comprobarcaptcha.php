<?php
/* Comprobar captcha.
	@autor: Pedro Parra (edyjen@hotmail.com)
	@ver 1.00
*/

require_once("../kernel/controller.php");
$isCorrect = $h->checkCaptcha($_GET['captcha']);

if (!$isCorrect) {
	$h->generateCaptcha();
}

echo json_encode($isCorrect);

?>
