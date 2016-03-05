<?php require(__DIR__ . "/registrotop.php"); ?>
<div class="theme-showcase jumbotron">
<form class="form-horizontal" role="form" id="formulario" novalidate="novalidate" enctype="multipart/form-data" method="post">
	<legend>Formulario de Registro de Pago</legend>
	<input type="hidden" name="ID_PAGO" id="id_pago">
	<input type="hidden" name="ID_ESTADO_PRODUCTO" id="id_estado_producto">
	<input type="hidden" name="PAGO_EXT" id="pago_ext">

	<fieldset><label>Información del Cliente</label>

		<div class="form-group">
			<label for="usuario_mercadolibre" class="col-sm-3 control-label">Usuario *</label>
			<div class="input-group col-sm-8">
				<input type="text" class="form-control" id="usuario_mercadolibre" name="USUARIO_MERCADOLIBRE" placeholder="Nombre de Usuario en Mercadolibre">
			</div>
		</div>

		<div class="form-group">
			<label for="usuario_correo" class="col-sm-3 control-label">Correo *</label>
			<div class="input-group col-sm-8">
				<input type="email" class="form-control" id="usuario_correo" name="USUARIO_CORREO" placeholder="Correo Electrónico">
			</div>
		</div>

	</fieldset>
	<fieldset><label>Datos de la Compra</label>

		<div class="form-group">
			<label for="articulo_nombre" class="col-sm-3 control-label">Nombre del Producto *</label>
			<div class="input-group col-sm-8">
				<input type="text" class="form-control" id="articulo_nombre" name="ARTICULO_NOMBRE" placeholder="Descripción del Producto Comprado">
			</div>
		</div>

		<div class="form-group">
			<label for="articulo_cantidad" class="col-sm-3 control-label">Cantidad *</label>
			<div class="input-group col-sm-8">
				<input type="number" class="form-control" id="articulo_cantidad" name="ARTICULO_CANTIDAD" placeholder="Cantidad del Producto Comprado">
			</div>
		</div>
		
	</fieldset>
	<fieldset><label>Información para el Envío</label>

		<div class="form-group">
			<label for="recibe_id" class="col-sm-3 control-label">Identificación *</label>
			<div class="col-sm-2">
				<select class="form-control" id="recibe_nac" name="RECIBE_NAC">
					<option value="V">V-</option>
					<option value="E">E-</option>
					<option value="J">J-</option>
				</select>
			</div>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="recibe_id" name="RECIBE_ID" placeholder="Número de Identificación">
			</div>
		</div>

		<div class="form-group">
			<label for="recibe_nombre" class="col-sm-3 control-label">Nombre *</label>
			<div class="input-group col-sm-8">
				<input type="text" class="form-control" id="recibe_nombre" name="RECIBE_NOMBRE" placeholder="Nombre de quien recibe">
			</div>
		</div>

		<div class="form-group">
			<label for="recibe_telefono" class="col-sm-3 control-label">Teléfono *</label>
			<div class="input-group col-sm-8">
				<input type="text" class="form-control" id="recibe_telefono" name="RECIBE_TELEFONO" placeholder="Número de Teléfono">
			</div>
		</div>

		<div class="form-group">
			<label for="_recibe_empresa" class="col-sm-3 control-label">Empresa de Envíos *</label>
			<div class="input-group col-sm-8">
				<select class="form-control" id="_recibe_empresa" name="_RECIBE_EMPRESA">
					<option value="">- Elegir -</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="agencia" class="col-sm-3 control-label"></label>
			<div class="input-group col-sm-8">
				<input type="checkbox" id="agencia" value="yes" name="AGENCIA"> ¿Enviar a Agencia?
			</div>
		</div>

		<div class="form-group">
			<label for="_recibe_estado" class="col-sm-3 control-label">Estado *</label>
			<div class="input-group col-sm-8">
				<input type="text" class="form-control" id="_recibe_estado" name="_RECIBE_ESTADO" placeholder="Estado">
			</div>
		</div>

		<div class="form-group">
			<label for="_recibe_ciudad" class="col-sm-3 control-label">Ciudad *</label>
			<div class="input-group col-sm-8">
				<input type="text" class="form-control" id="_recibe_ciudad" name="_RECIBE_CIUDAD" placeholder="Ciudad">
			</div>
		</div>

		<div class="form-group">
			<label for="_recibe_municipio" class="col-sm-3 control-label">Municipio *</label>
			<div class="input-group col-sm-8">
				<input type="text" class="form-control" id="_recibe_municipio" name="_RECIBE_MUNICIPIO" placeholder="Municipio">
			</div>
		</div>

		<div class="form-group">
			<label for="_recibe_direccion" class="col-sm-3 control-label" id="labeldireccion">Dirección Personal *</label>
			<div class="input-group col-sm-8">
				<textarea class="form-control" rows="3" id="_recibe_direccion" name="_RECIBE_DIRECCION" placeholder="Dirección Completa de Destino"></textarea>
			</div>
		</div>

		<div class="form-group">
			<label for="_recibe_asegurado" class="col-sm-3 control-label">¿Envío Asegurado? *</label>
			<div class="col-sm-8">
				<select class="form-control" id="_recibe_asegurado" name="_RECIBE_ASEGURADO">
					<option value="">- Elegir -</option>
					<option id="textoasegurado" value="Si">Sí, Deseo solicitar un envío asegurado</option>
					<option value="No">No</option>
				</select>
			</div>
		</div>

	</fieldset>
	<fieldset><label>Datos del Pago Realizado</label>

		<div class="form-group">
			<label for="_pago_metodo" class="col-sm-3 control-label">Método de Pago *</label>
			<div class="col-sm-8">
				<select class="form-control" id="_pago_metodo" name="_PAGO_METODO">
					<option value="">- Elegir -</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="_pago_origen" class="col-sm-3 control-label">Banco Emisor *</label>
			<div class="input-group col-sm-8">
				<input type="text" class="form-control" id="_pago_origen" name="_PAGO_ORIGEN" placeholder="Banco desde donde emitió el pago">
			</div>
		</div>

		<div class="form-group">
			<label for="_pago_destino" class="col-sm-3 control-label">Banco Destino *</label>
			<div class="col-sm-8">
				<select class="form-control" id="_pago_destino" name="_PAGO_DESTINO">
					<option value="">- Elegir -</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="_pago_id" class="col-sm-3 control-label">Número del Comprobante *</label>
			<div class="input-group col-sm-8">
				<input type="text" class="form-control" id="_pago_id" name="_PAGO_ID" placeholder="Número del Comprobante">
			</div>
		</div>

		<div class="form-group">
			<label for="pago_fecha" class="col-sm-3 control-label">Fecha *</label>
			<div class="input-group col-sm-8">
				<input type="date" class="form-control" id="pago_fecha" name="PAGO_FECHA" placeholder="Fecha del Pago día/mes/año">
			</div>
		</div>

		<div class="form-group">
			<label for="pago_monto" class="col-sm-3 control-label">Monto *</label>
			<div class="input-group col-sm-8">
				<input type="numbers" class="form-control" id="pago_monto" name="PAGO_MONTO" placeholder="Monto Pagado">
			</div>
		</div>

		<div class="form-group">
			<label for="pago_archivo" class="col-sm-3 control-label">Comprobante</label>
			<div class="col-sm-8">
				<input type="file" id="pago_archivo" name="PAGO_ARCHIVO" placeholder="Comprobante">
			</div>
			<p class="help-block col-sm-offset-3 col-sm-8">Seleccione un archivo .jpg .bmp .gif .png o .pdf (max 1MB)</p>
		</div>

		<div class="form-group">
			<label for="observacion" class="col-sm-3 control-label">Observaciones</label>
			<div class="input-group col-sm-8">
				<textarea class="form-control" id="observacion" name="OBSERVACION" placeholder="" rows="5"></textarea>
			</div>
		</div>

		<div id="refreshcaptcha" class="center-block" title="click para cambiar imágen">
		</div>

		<div class="form-group">
			<label for="captcha" class="col-sm-3 control-label">Captcha *</label>
			<div class="input-group col-sm-8">
				<input type="text" class="form-control" id="captcha" name="captcha" placeholder="Escriba los caracteres de la imágen" autocomplete="off">
			</div>
		</div>
		
	</fieldset>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<button type="submit" id="bSubmit" class="btn btn-default">Registrar Pago</button>
		</div>
	</div>

</form>
</div>

<script type="text/javascript">
(function($,W,D) {
	$(D).ready(function($) {
		validacion.configurar();

		$("#_recibe_estado").bindTo("RECIBE_ESTADO");
		$("#_recibe_ciudad").bindTo("RECIBE_CIUDAD");
		$("#_recibe_municipio").bindTo("RECIBE_MUNICIPIO");
		$("#_recibe_direccion").bindTo("RECIBE_DIRECCION");
		$("#_recibe_empresa").bindTo("RECIBE_EMPRESA");
		$("#_recibe_asegurado").bindTo("RECIBE_ASEGURADO");
		$("#_pago_metodo").bindTo("PAGO_METODO");
		$("#_pago_destino").bindTo("PAGO_DESTINO");
		$("#_pago_origen").bindTo("PAGO_ORIGEN");
		$("#_pago_id").bindTo("PAGO_ID");

		$.each(result.envios, function(key, value) {
			$("#_recibe_empresa").append(
				$('<option>').val(value).text(value)
			);
		});

		$.each(result.bancos, function(key, value) {
			$("#_pago_destino").append(
				$('<option>').val(value).text(value)
			);
		});

		$.each(result.metodo, function(key, value) {
			$("#_pago_metodo").append(
				$('<option>').val(value).text(value)
			);
		});

		$("#_pago_metodo").change(function(){
			switch ($("#_pago_metodo").val()) {
				case "MercadoPago":
					if ($("#_pago_destino").attr("readonly") === undefined) {
						$("#_pago_destino").attr("readonly", true);
						$("#_pago_destino").append($('<option>').text("Otro Metodo").attr("id", "aOtroMetodo"));
					}
					
					$("#_pago_origen").setBindValue("MercadoPago");
					$("#aOtroMetodo").val("MercadoPago");
					$("#_pago_destino").setBindValue("MercadoPago");
					$("#_pago_id").setBindValue("00000000");
					break;
				case "Paypal":
					if ($("#_pago_destino").attr("readonly") === undefined) {
						$("#_pago_destino").attr("readonly", true);
						$("#_pago_destino").append($('<option>').text("Otro Metodo").attr("id", "aOtroMetodo"));
					}
					
					$("#_pago_origen").setBindValue("Paypal");
					$("#aOtroMetodo").val("Paypal");
					$("#_pago_destino").setBindValue("Paypal");
					$("#_pago_id").loadBindValue();
					break;
				default:
					if ($("#_pago_destino").attr("readonly") !== undefined) {
						$("#_pago_destino").removeAttr("readonly");
						$("#aOtroMetodo").remove();
					}
					$("#_pago_origen").loadBindValue();
					$("#_pago_destino").loadBindValue();
					$("#_pago_id").loadBindValue();
					break;
			}

			switch ($("#_pago_metodo").val()) {
				case "MercadoPago":
					$("#_pago_origen").hideBlock();
					$("#_pago_destino").hideBlock();
					$("#_pago_id").hideBlock();
					break;
				case "Paypal":
					$("#_pago_origen").hideBlock();
					$("#_pago_destino").hideBlock();
					$("#_pago_id").showBlock();
					break;
				default:
					$("#_pago_origen").showBlock();
					$("#_pago_destino").showBlock();
					$("#_pago_id").showBlock();
					break;
			}
		});

		$("#_recibe_empresa").change(function(){
			if ($("#_recibe_empresa").val() == "MRW") {
				$("#textoasegurado").val("Si MRW").text("Sí, Envío asegurado con MRW (1.68% de costo adicional)");
			}
			else {
				$("#textoasegurado").val("Si").text("Sí, Deseo solicitar un envío asegurado");
			}

			if ($("#_recibe_empresa").val() == "Entrega Personal") {
				$("#_recibe_estado").setBindValue("---").hideBlock();
				$("#_recibe_ciudad").setBindValue("---").hideBlock();
				$("#_recibe_municipio").setBindValue("---").hideBlock();
				$("#_recibe_direccion").setBindValue("Entrega Personal").hideBlock();
				$("#_recibe_asegurado").setBindValue("No").hideBlock();
				$("#agencia").hideBlock();
			}
			else {
				$("#_recibe_estado").loadBindValue().showBlock();
				$("#_recibe_ciudad").loadBindValue().showBlock();
				$("#_recibe_municipio").loadBindValue().showBlock();
				$("#_recibe_direccion").loadBindValue().showBlock();
				$("#_recibe_asegurado").loadBindValue().showBlock();
				$("#agencia").showBlock();
			}
		});

		$("#agencia").change(function(){
			if ($("#agencia").is(":checked")) {
				$("#labeldireccion").text("Dirección de Agencia *");
			}
			else {
				$("#labeldireccion").text("Dirección Personal *");
			}
		});

		$("#refreshcaptcha").click(function(e) {
			$("#refreshcaptcha").load("cambiarcaptcha.php");
		});

		$("#refreshcaptcha").click();
		$("#usuario_mercadolibre").select();

		switch (result.messageId) {
			case "PERMISSION_GRANTED":
			case "SUCESS":
				break;
			case "DATABASE_CONNECTION_ERROR":
				alert("Error al conectar a la base de datos.");
				break;
			case "PERMISSION_DENIED":
				alert("Acceso Denegado.");
				break;
			case "FAILED":
				alert(result.messageText);
				break;
			default:
				alert("Error: " + result.messageText);
		}
	});

	$("#bSubmit").click(function(e) {
		$("#formulario").valid();
		if (!$("#captcha").valid()) {
			if ($("#captcha").val()) {
				$("#refreshcaptcha").click();
			}
		}
	});

	var validacion = validate({
		form: "formulario",
		rules: {
			USUARIO_MERCADOLIBRE: {
				required: true,
				nicks: true,
				minlength: 3,
				maxlength: 32
			},
			USUARIO_CORREO: {
				required: true,
				email: true,
				maxlength: 32
			},
			USUARIO_TELEFONO: {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 12
			},
			ARTICULO_NOMBRE: {
				required: true,
				minlength: 3,
				maxlength: 64
			},
			ARTICULO_CANTIDAD: {
				required: true,
				number: true,
				maxlength: 7
			},
			RECIBE_NAC: {
				required: true
			},
			RECIBE_ID: {
				required: true,
				number: true,
				minlength: 6,
				maxlength: 10
			},
			RECIBE_TELEFONO: {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 12
			},
			_RECIBE_EMPRESA: {
				required: true
			},
			_RECIBE_ESTADO: {
				required: true,
				minlength: 3,
				maxlength: 32
			},
			_RECIBE_CIUDAD: {
				required: true,
				minlength: 3,
				maxlength: 32
			},
			_RECIBE_MUNICIPIO: {
				required: true,
				minlength: 3,
				maxlength: 32
			},
			_RECIBE_DIRECCION: {
				required: true,
				minlength: 4,
				maxlength: 255
			},
			_RECIBE_ASEGURADO: {
				required: true
			},
			_PAGO_METODO: {
				required: true
			},
			_PAGO_ORIGEN: {
				required: true,
				minlength: 3,
				maxlength: 32
			},
			_PAGO_DESTINO: {
				required: true
			},
			_PAGO_ID: {
				required: true,
				minlength: 4,
				maxlength: 16
			},
			PAGO_FECHA: {
				required: true,
				date: true
			},
			PAGO_MONTO: {
				required: true,
				number: true,
				minlength: 1,
				maxlength: 8
			},
			PAGO_ARCHIVO: {
				required: false,
				fileSize: 1048575,
				fileExt: "bmp|jpg|jpeg|png|gif|pdf"
			},
			OBSERVACION: {
				required: false,
				minlength: 3,
				maxlength: 256
			},
			captcha: {
				required: true,
				remote: "comprobarcaptcha.php"
			}
		},
		submitHandler: function(form) {
			if (confirm("¿Confirma que desea enviar los datos suministrados?")) {
				data = new FormData($("#formulario")[0]);
				fAjax("s_submit.php", data, function(r) {
					switch (r.messageId) {
						case "MAIL_FAILED":
							alert("Hemos recibido sus datos satisfactoriamente. Sin embargo, hubo un problema al enviar el correo al email especificado.");
							W.location.reload();
							break;
						case "MAIL_SUCESS":
						case "SUCESS":
							alert("Hemos recibido sus datos satisfactoriamente.");
							W.location.reload();
							break;
						case "DATABASE_CONNECTION_ERROR":
							alert("Error al conectar a la base de datos.");
							break;
						case "PERMISSION_DENIED":
							alert("Acceso Denegado.");
							break;
						case "FAILED":
							alert(r.messageText);
							break;
						case "SAVE_NOT_ALLOWED":
							alert("Disculpe, La información de este reporte ya se encuentra registrada en nuestros servidores.");
							break;
						default:
							alert("Error: " + r.messageText);
					}
				}, true);
				$("#refreshcaptcha").click();
			}
		},
		messages: {
			captcha: {
				remote: "Los caracteres no coinciden con la imágen"
			}
		}
	});

})(jQuery, window, document);
</script>
