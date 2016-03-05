<div class="theme-showcase jumbotron">
<form class="form-horizontal center-768 opacity" role="form" id="formulario" novalidate="novalidate">
	<legend>Iniciar Sesión</legend>
	<input type="hidden" name="ID_USUARIO" id="id_usuario">

	<fieldset><label>Información de Inicio de Sesión</label>

		<div class="form-group">
			<label for="login" class="col-sm-3 control-label">Usuario *</label>
			<div class="input-group col-sm-8">
				<input type="text" class="form-control" id="login" name="LOGIN" placeholder="Nombre de Usuario" autocomplete="on">
			</div>
		</div>

		<div class="form-group">
			<label for="pass" class="col-sm-3 control-label">Contraseña *</label>
			<div class="input-group col-sm-8">
				 <input type="password" class="form-control" id="pass" name="PASS" placeholder="Contraseña" autocomplete="off">
			</div>
		</div>

	</fieldset>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<button type="submit" id="bSubmit" class="btn btn-default">Iniciar Sesión</button>
		</div>
	</div>

</form>
</div>

<script type="text/javascript">
(function($,W,D) {
	$(D).ready(function($) {
		validacion.configurar();
		$("#mMain").addClass("active");

		displayErrors(result, function(r) {
			switch (r.messageId) {
				case "PERMISSION_GRANTED":
					W.location.reload();
					break;
				case "PERMISSION_DENIED":
					if (r.session.PRIV < 0) {
						alert("Lo Sentimos. Usted ha sido bloqueado temporalmente para acceder a nuestros servidores.");
					}
					break;
				default:
					return false;
			}
			return true;
		});

		$("#login").select();
	});

	var validacion = validate({
		form: "formulario",
		rules: {
			LOGIN: {
				required: true,
				nick: true,
				minlength: 4,
				maxlength: 16
			},
			PASS: {
				required: true,
				nick: true,
				minlength: 4,
				maxlength: 32
			}
		},
		submitHandler: function(form) {
			swal({
				title: "Iniciando Sesión...",
				text: "Por favor, espere...",
				type: "info",
				showConfirmButton: false,
				showLoaderOnConfirm: true,
				timer: 0
			},
			function() {
				mAjax("s_login.php", $("#formulario").serialize(), function(r) {
					displayErrors(r, function(r) {
						switch (r.messageId) {
							case "FAILED":
								swal("Lo Sentimos!", "Ocurrió un error al intentar leer los datos enviados. Por favor, reintente", "error");
								break;
							case "LOGIN_FAILED":
								swal("Acción Negada", "El nombre de usuario y/o contraseña son incorrectos", "error");
								$("#pass").select();
								break;
							case "SUCESS":
								W.location.reload();
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
