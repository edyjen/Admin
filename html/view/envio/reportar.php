<div id="reportarenvio"class="theme-showcase jumbotron">
<form class="form-horizontal opacity" role="form" id="formulario" novalidate="novalidate">
	<legend>Formulario de Reporte de envíos</legend>
	<input type="hidden" name="ID_PAGO" id="id_pago">
	<input type="hidden" name="ID_ENVIO" id="id_envio">

	<fieldset><label>Reporte de Envío</label>

		<div class="form-group">
			<label for="envio_fecha" class="col-sm-3 control-label">Fecha *</label>
			<div class="input-group col-sm-8">
				<input type="date" class="form-control" id="envio_fecha" name="ENVIO_FECHA" placeholder="Fecha del envío" autocomplete="on">
			</div>
		</div>

		<div class="form-group">
			<label for="envio_empresa" class="col-sm-3 control-label">Empresa de Envíos *</label>
			<div class="input-group col-sm-8">
				<select class="form-control" id="envio_empresa" name="ENVIO_EMPRESA">
					<option value="">- Elegir -</option>
					<option value="Domesa">Domesa</option>
					<option value="Grupo Zoom">Grupo Zoom</option>
					<option value="MRW">MRW</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="envio_id" class="col-sm-3 control-label">Número de guía *</label>
			<div class="input-group col-sm-8">
				<input type="text" class="form-control" id="envio_id" name="ENVIO_ID" placeholder="Identificación del envío" autocomplete="off">
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-9">
				<button type="submit" id="bReportar" class="btn btn-default" role="button">Reportar Envío</button>
				<button id="bCancelar" class="btn btn-default" role="button">Cancelar</button>
			</div>
		</div>

	</fieldset>
</form>
</div>

<script src="../lib/js/jquery.validate.min.js"></script>
<script src="../lib/js/extend.validate.js"></script>

<script type="text/javascript">

(function($,W,D) {
	$(D).ready(function($) {
		validacion.configurar();

		displayErrors(result, function(r) {
			switch (result.messageId) {
				case "SUCESS":
					fillData();
					break;
				case "EMPTY":
					swal("Error!", "El registro no existe.", "error");
					break;
				default:
					return false;
			}
			return true;
		});

		$("#envio_fecha").select();
	});

	fillData = function() {
		$("#id_pago").val(result.obj.ID_PAGO);

		$("#bCancelar").click(function() {
			W.close();
		});
	};

	var validacion = validate({
		form: "formulario",
		rules: {
			ENVIO_ID: {
				required: true,
				minlength: 4,
				maxlength: 16
			},
			ENVIO_EMPRESA: {
				required: true,
				maxlength: 32
			},
			ENVIO_FECHA: {
				required: true,
				date: true
			}
		},
		submitHandler: function(form) {
			swal({
				title: "¿Está Seguro?",
				text: "¿Confirma que desea registrar el envío y mover el pago a ENVIADOS? ",
				type: "warning",
				showLoaderOnConfirm: true,
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#1d9c59",
				confirmButtonText: "Confirmar y Reportar",
				closeOnConfirm: false
			},
			function() {
				mAjax("s_mover.php?id=" + result.obj.ID_PAGO + "&a=Enviado", $("#formulario").serialize(), function(r) {
					displayErrors(r, function(r) {
						switch (r.messageId) {
							case "SUCESS":
							case "MAIL_SUCESS":
								swal({title: "Acción Exitosa", text: "El pago ha sido movido satisfactoriamente.", type: "success", confirmButtonText: "Aceptar", confirmButtonColor: "#1d9c59", closeOnConfirm: false }, function() { W.close(); });
								break;
							case "MAIL_FAILED":
								swal({title: "Acción Exitosa", text: "El pago ha sido movido satisfactoriamente. Sin embargo, ha ocurrido un error al enviar el correo electrónico.", type: "warning", confirmButtonText: "Aceptar", confirmButtonColor: "#1d9c59", closeOnConfirm: false }, function() { W.close(); });
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
