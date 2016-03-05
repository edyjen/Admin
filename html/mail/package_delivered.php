<?php ob_start(); ?>
<h1><?php echo $info["asunto_mailenviado"]; ?></h1>
<p><?php echo "Hola Sr(a)" . $data["RECIBE_NOMBRE"]; ?>,</p>
<p><?php echo "Su producto fue enviado por " . $data["envio"]["ENVIO_EMPRESA"] . " el día " . $data["envio"]["ENVIO_FECHA"] ?>.</p>
<p>Número de Guía: <?php echo $data["envio"]["ENVIO_ID"]; ?></p>
<p>Saludos Cordiales</p>
<p><?php echo $info["name"]; ?></p>
<?php $fileContent = ob_get_clean(); require(__DIR__ . "/style.php"); ?>
