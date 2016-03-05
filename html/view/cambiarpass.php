<div id="reportarenvio"class="theme-showcase jumbotron">
<form class="form-horizontal opacity" role="form" id="formulario" novalidate="novalidate">
	<legend>Cambiar Contraseña</legend>

	<fieldset>

		<div class="form-group">
			<label for="pass" class="col-sm-3 control-label">Contraseña Actual *</label>
			<div class="input-group col-sm-8">
				<input type="password" class="form-control" id="pass" name="PASS" placeholder="Contraseña Actual" autocomplete="off">
			</div>
		</div>

		<div class="form-group">
			<label for="nueva_pass" class="col-sm-3 control-label">Contraseña Nueva *</label>
			<div class="input-group col-sm-8">
				<input type="password" class="form-control" id="nueva_pass" name="NUEVA_PASS" placeholder="Contraseña Nueva" autocomplete="off">
			</div>
		</div>

		<div class="form-group">
			<div class="input-group col-sm-offset-3 col-sm-8">
				<input type="password" class="form-control" id="nueva_pass2" name="NUEVA_PASS2" placeholder="Confirmar Contraseña Nueva" autocomplete="off">
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-9">
				<button type="submit" id="bSubmit" class="btn btn-default" role="button">Cambiar Contraseña</button>
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
		$("#menu").show();

		displayErrors(result);

		$("#pass").select();
	});

	$("#bCancelar").click(function() {
		W.location.replace("./");
	});

	var validacion = validate({
		form: "formulario",
		rules: {
			PASS: {
				required: true
			},
			NUEVA_PASS: {
				required: true,
				minlength: 4,
				maxlength: 32
			},
			NUEVA_PASS2: {
				equalTo: "#nueva_pass"
			}
		},
		submitHandler: function(form) {
			swal({
				title: "¿Está Seguro?",
				text: "¿Confirma que desea cambiar la contraseña?",
				type: "warning",
				showLoaderOnConfirm: true,
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#1d9c59",
				confirmButtonText: "Cambiar Contraseña",
				closeOnConfirm: false
			},
			function() {
				mAjax("s_cambiarpass.php", $("#formulario").serialize(), function(r) {
					displayErrors(r, function(r) {
						switch (r.messageId) {
							case "SUCESS":
								swal("Acción Exitosa", "La contraseña ha sido cambiada satisfactoriamente.", "success");
								$('#formulario').trigger("reset");
								break;
							case "FAILED_PASS":
								swal("Lo Sentimos!", r.messageText, "error");
								$("#pass").select();
								break;
							case "FAILED_PASS2":
								swal("Lo Sentimos!", r.messageText, "error");
								$("#nueva_pass").select();
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
