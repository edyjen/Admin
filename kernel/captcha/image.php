<?php

session_start();

if(!isset($_SESSION['captcha']))
	$str = 'ERROR!';
else
	$str = $_SESSION['captcha'];

header('Content-Type: image/png');
header('Cache-Control: no-cache');

$image = imagecreatefrompng('background.png');
$colour = imagecolorallocate($image, 183, 178, 152);
$font = 'fonts/Anorexia.ttf';
$rotate = rand(-15, 15);
imagettftext($image, 14, $rotate, 18, 30, $colour, $font, $str);
imagepng($image);

?>