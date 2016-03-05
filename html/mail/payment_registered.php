<?php ob_start(); ?>
<h2><?php echo $info["asunto_mailrecibido"]; ?></h2>
<p><?php echo "Gracias por su compra Sr(a)" . $data["RECIBE_NOMBRE"] . ","; ?></p>
<p>Hemos recibido satisfactoriamente su reporte. En este momento, el equipo de <?php echo $info["name"]; ?> está corroborando la información de pago suministrada por usted con nuestras cuentas bancarias.</p>
<p>Su envío se realizará en un periodo no mayor a 24 horas hábiles luego de ser REVISADO el pago. Si reportó el pago antes de la 1:00pm y toda la información está correcta, su producto puede ser enviado el mismo día.</p>
<p>Saludos Cordiales</p>
<p><?php echo $info["name"]; ?></p>
<?php $fileContent = ob_get_clean(); require(__DIR__ . "/style.php"); ?>
