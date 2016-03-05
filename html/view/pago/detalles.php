<div class="container">
<table id="tabla" class="table table-bordered table-hover table-responsive col-sm-12">
<legend>Detalles del Pago</legend>
	<tbody>
		<tr><th colspan="2"><center>Información de Usuario en Mercadolibre</center></th></tr>
		<tr>
			<th>Usuario</th>
			<td id="USUARIO_MERCADOLIBRE"></td>
		</tr>
		<tr>
			<th>Correo</th>
			<td id="USUARIO_CORREO"></td>
		</tr>
		<tr><th colspan="2"><center>Datos de la Compra</center></th></tr>
		<tr>
			<th>Producto</th>
			<td id="ARTICULO_NOMBRE"></td>
		</tr>
		<tr>
			<th>Cantidad</th>
			<td id="ARTICULO_CANTIDAD"></td>
		</tr>
		<tr><th colspan="2"><center>Información del Envío</center></th></tr>
		<tr>
			<th>Destinatario</th>
			<td><span id="RECIBE_NAC"></span>-<span id="RECIBE_ID"></span> <span id="RECIBE_NOMBRE"></span></td>
		</tr>
		<tr>
			<th>Teléfono</th>
			<td id="RECIBE_TELEFONO"></td>
		</tr>
		<tr>
			<th>Empresa de Envíos</th>
			<td id="RECIBE_EMPRESA"></td>
		</tr>
		<tr>
			<th>Dirección</th>
			<td><span id="RECIBE_DIRECCION"></span>, <span>Estado: <span id="RECIBE_ESTADO"></span>, Municipio: <span id="RECIBE_MUNICIPIO"></span>, Ciudad: <span id="RECIBE_CIUDAD"></span></td>
		</tr>
		<tr>
			<th>Envío Asegurado</th>
			<td id="RECIBE_ASEGURADO"></td>
		</tr>
		<tr><th colspan="2"><center>Datos del Pago Realizado</center></th></tr>
		<tr>
			<th>Método de Pago</th>
			<td id="PAGO_METODO"></td>
		</tr>
		<tr>
			<th>Referencia</th>
			<td><span id="PAGO_ID"></span> <span id="PAGO_PRUEBA"></span></td>
		</tr>
		<tr>
			<th>Fecha</th>
			<td id="PAGO_FECHA"></td>
		</tr>
		<tr>
			<th>Monto</th>
			<td id="PAGO_MONTO"></td>
		</tr>
		<tr>
			<th>Observaciones</th>
			<td id="OBSERVACION"></td>
		</tr>
	</tbody>
</table>
</div>

<div class="col-sm-12">
	<button class="btn btn-default" id="bRevisado">Mover a Revisados</button>
	<button class="btn btn-default" id="bConErrores">Mover a Con Errores</button>
	<button class="btn btn-default" id="bEnviado">Mover a Enviados</button>
	<button class="btn btn-default" id="bEtiqueta">Ver Etiqueta</button>
	<button class="btn btn-default" id="bCorreo">Enviar un Correo</button>
	<button class="btn btn-default" id="bEliminar">Eliminar</button>
	<button class="btn btn-default" id="bCancelar">Cancelar</button>
</div>

<script type="text/javascript">

(function($,W,D) {
	$(D).ready(function($) {
		displayErrors(result, function(r) {
			switch (r.messageId) {
				case "SUCESS":
				case "NO_ENVIO":
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
	});

	fillData = function() {
		$.each(result.obj, function(key, value){
			if (value) {
				$("#"+key).text(value);
			}
		});

		if (result.obj.PAGO_EXT) {
			$("#PAGO_PRUEBA").append(
				$("<a>").text("(Ver Comprobante)").attr("href", "#").click(function(e) {
					e.preventDefault();
					W.open("comprobante.php?id=" + result.obj.ID_PAGO, "_blank", "menubar=no, scrollbars=yes, width=800, height=480, top=80, left=80");
				})
			);
		}
		else {
			$("#PAGO_PRUEBA").text("(Sin Comprobante)");
		}

		if (result.envio) {
			$("#tabla > tbody").append(
				$('<tr>').append(
					$('<th colspan="2"">').append(
						$('<center>').text("Información del envío")
					)
				),
				$('<tr>').append(
					$('<th>').text("Empresa de Envíos"),
					$('<td>').text(result.envio.ENVIO_EMPRESA)
				),
				$('<tr>').append(
					$('<th>').text("Fecha del envío"),
					$('<td>').text(result.envio.ENVIO_FECHA)
				),
				$('<tr>').append(
					$('<th>').text("Número de Comprobante"),
					$('<td>').text(result.envio.ENVIO_ID)
				)
			);
		}

		$("#PAGO_FECHA").text(cdate(result.obj.PAGO_FECHA));

		if (result.obj.PAGO_METODO == "MercadoPago") {
			$("#PAGO_METODO").text("MercadoPago");
		}
		else {
			$("#PAGO_METODO").text(result.obj.PAGO_METODO + " de " + result.obj.PAGO_ORIGEN + " a " + result.obj.PAGO_DESTINO);
		}

		if (result.tipo == "En Espera" || result.tipo == "Enviado" || result.tipo == "Con Errores") {
			$("#bEnviado").hide();
		}


		if (result.tipo == "Revisado" || result.tipo == "Enviado" || result.tipo == "Con Errores") {
			$("#bRevisado").hide();
			$("#bConErrores").hide();
		}
	}

	$("#bRevisado").click(function() {
		swal({
			title: "¿Está Seguro?",
			text: "¿Confirma que desea Mover el Pago a REVISADOS? Esta acción es Irreversible.",
			type: "warning",
			showLoaderOnConfirm: true,
			showCancelButton: true,
			cancelButtonText: "Cancelar",
			confirmButtonText: "Confirmar y Reportar",
			confirmButtonColor: "#1d9c59",
			closeOnConfirm: false
		},
		function() {
			mAjax("s_mover.php?id=" + result.obj.ID_PAGO + "&a=Revisado", null, function(r) {
				displayErrors(result, function(r) {
					switch (r.messageId) {
						case "SUCESS":
						case "NO_ENVIO":
							W.opener.repeatAction();
							swal({title: "Acción Exitosa", text: "El pago ha sido movido correctamente.", type: "success", confirmButtonText: "Aceptar", confirmButtonColor: "#1d9c59", closeOnConfirm: false }, function() { W.close(); });
							break;
						default:
							return false;
					}
					return true;
				});
			});
		});
	});

	$("#bConErrores").click(function() {
		swal({
			title: "¿Está Seguro?",
			text: "¿Confirma que desea Mover el Pago a CON ERRORES? Esta acción es Irreversible.",
			type: "warning",
			showLoaderOnConfirm: true,
			showCancelButton: true,
			cancelButtonText: "Cancelar",
			confirmButtonText: "Confirmar y Reportar",
			confirmButtonColor: "#1d9c59",
			closeOnConfirm: false
		},
		function() {
			mAjax("s_mover.php?id=" + result.obj.ID_PAGO + "&a=Con Errores", null, function(r) {
				displayErrors(result, function(r) {
					switch (r.messageId) {
						case "SUCESS":
						case "NO_ENVIO":
							W.opener.repeatAction();
							swal({title: "Acción Exitosa", text: "El pago ha sido movido correctamente.", type: "success", confirmButtonText: "Aceptar", confirmButtonColor: "#1d9c59", closeOnConfirm: false }, function() { W.close(); });
							break;
						default:
							return false;
					}
					return true;
				});
			});
		});
	});

	$("#bEnviado").click(function() {
		W.open("reportar.php?id=" + result.obj.ID_PAGO + "&a=Enviado", "_blank", "menubar=no, scrollbars=yes, width=800, height=480, top=80, left=80");
	});

	$("#bEliminar").click(function() {
		swal({
			title: "¿Está Seguro?",
			text: "¿Confirma que desea Eliminar el Pago Seleccionado? Esta acción es Irreversible.",
			type: "warning",
			showLoaderOnConfirm: true,
			showCancelButton: true,
			cancelButtonText: "Cancelar",
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Sí, Eliminar el pago",
			closeOnConfirm: false
		},
		function() {
			mAjax("s_eliminar.php?id=" + result.obj.ID_PAGO, null, function(r) {
				displayErrors(r, function(r) {
					switch (r.messageId) {
						case "SUCESS":
						case "NO_ENVIO":
							W.opener.repeatAction();
							swal({title: "Acción Exitosa", text: "El pago ha sido eliminado correctamente.", type: "success", confirmButtonText: "Aceptar", confirmButtonColor: "#1d9c59", closeOnConfirm: false }, function() { W.close(); });
							break;
						default:
							return false;
					}
					return true;
				});
			});
		});
	});

	$("#bEtiqueta").click(function() {
		W.open("etiqueta.php?id=" + result.obj.ID_PAGO, "_blank", "menubar=no, scrollbars=yes, width=800, height=480, top=80, left=80");
	});

	$("#bCorreo").click(function() {
		W.open("enviarmail.php?id=" + result.obj.ID_PAGO, "_blank", "menubar=no, scrollbars=yes, width=800, height=480, top=80, left=80");
	});

	$("#bCancelar").click(function() {
		W.close();
	});
})(jQuery, window, document);
</script>
