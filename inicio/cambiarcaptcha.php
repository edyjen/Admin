<?php
/* Registrar Pago.
	@autor: Pedro Parra (edyjen@hotmail.com)
	@ver 1.00
*/

require_once("../kernel/controller.php");
$h->generateCaptcha();

echo '<img src="../kernel/captcha/image.php?' . time() . '" width="132" height="46" alt="Captcha">';

?>
