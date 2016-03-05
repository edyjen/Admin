<?php ob_start(); ?>
<h1><?php echo $info["asunto_mailrevisado"]; ?></h1>
<p><?php echo "Hola Sr(a) " . $data["RECIBE_NOMBRE"]; ?>,</p>
<p>Su pago ha sido revisado y éste ha sido aprobado. Su producto está siendo preparado para su envío lo más pronto posible.</p>
<p>Una vez realizado el envío, usted recibirá la información correspondiente.</p>
<p>Saludos Cordiales</p>
<p><?php echo $info["name"]; ?></p>
<?php $fileContent = ob_get_clean(); require(__DIR__ . "/style.php"); ?>
