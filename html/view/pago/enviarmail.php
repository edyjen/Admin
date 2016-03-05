<div id="reportarenvio"class="theme-showcase jumbotron">
<form class="form-horizontal opacity" role="form" id="formulario" novalidate="novalidate">
	<legend>Enviar un Correo</legend>

	<fieldset>

		<div class="form-group">
			<label for="destino" class="col-sm-3 control-label">Para *</label>
			<div class="input-group col-sm-8">
				<input type="email" class="form-control" id="destino" name="destino" placeholder="Quien recibe el correo" autocomplete="on" disabled>
			</div>
		</div>

		<div class="form-group">
			<label for="asunto" class="col-sm-3 control-label">Asunto *</label>
			<div class="input-group col-sm-8">
				<input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto del correo" autocomplete="on">
			</div>
		</div>
	</fieldset>
	<fieldset><label>Mensaje</label>
		<div class="form-group">
			<div class="input-group col-sm-11">
				<textarea class="form-control" rows="10" id="mensaje" name="mensaje" placeholder="Contenido del Correo"></textarea>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-9">
				<button type="submit" id="bReportar" class="btn btn-default" role="button">Enviar</button>
				<button id="bCancelar" class="btn btn-default" role="button">Cancelar</button>
			</div>
		</div>

	</fieldset>
</form>
</div>

<script type="text/javascript">

(function($,W,D) {
	$(D).ready(function($) {
		validacion.configurar();

		displayErrors(result, function(r) {
			switch (r.messageId) {
				case "SUCESS":
					$("#destino").val(result.obj.USUARIO_CORREO);
					$("#asunto").val("Información Importante");
					break;
				case "EMPTY":
					swal("Error!", "El registro no existe.", "error");
					break;
				default:
					return false;
			}
			return true;
		});

		$("#asunto").select();
	});

	$("#bCancelar").click(function() {
		W.close();
	});

	var validacion = validate({
		form: "formulario",
		rules: {
			asunto: {
				required: false
			},
			mensaje: {
				required: true
			}
		},
		submitHandler: function(form) {
			swal({
				title: "¿Está Seguro?",
				text: "¿Confirma que desea enviar un correo electrónico a "+result.obj.USUARIO_CORREO+"?",
				type: "warning",
				showLoaderOnConfirm: true,
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#1d9c59",
				confirmButtonText: "Enviar Correo",
				closeOnConfirm: false
			},
			function() {
				mAjax("s_enviarmail.php?id=" + result.obj.ID_PAGO, $("#formulario").serialize(), function(r) {
					displayErrors(r, function(r) {
						switch (r.messageId) {
							case "SUCESS":
							case "MAIL_SUCESS":
								W.opener.repeatAction();
								swal({title: "Acción Exitosa", text: "El Correo ha sido enviado satisfactoriamente.", type: "success", confirmButtonText: "Aceptar", confirmButtonColor: "#1d9c59", closeOnConfirm: false }, function() { W.close(); });
								break;
							case "MAIL_FAILED":
								swal("Lo Sentimos!", "Ocurrió un problema al intentar enviar el correo electrónico.", "error");
								break;
							default:
								return false;
						}
						return true;
					});
				});
			});
		}
	});
})(jQuery, window, document);
</script>
