<?php ob_start(); ?>
<h1><?php echo $info["asunto_mailerrores"]; ?></h1>
<p><?php echo "Sr(a). " . $data["RECIBE_NOMBRE"] . ","; ?></p>
<p>No hemos podido comprobar su pago. Es posible que haya pagado a una entidad bancaria diferente a la entidad donde tenemos nuestras cuentas. También es posible que no haya especificado correctamente el número de referencia del pago.</p>
<p>Es necesario que envíe un soporte para confirmar su pago, éste puede ser una imágen escaneada del bauche, una fotografía, una captura de pantalla u otro comprobante válido que confirme que realizó el pago.</p>
<p>Quedamos en la espera para aprobar su pago y realizar el envío del producto correspondiente lo más pronto posible.</p>
<p>Saludos Cordiales</p>
<p><?php echo $info["name"]; ?></p>
<?php $fileContent = ob_get_clean(); require(__DIR__ . "/style.php"); ?>