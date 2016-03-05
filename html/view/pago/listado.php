<div class="container">
<table id="tabla" class="table table-bordered table-hover table-responsive clickable col-sm-12">
<legend>Listado de Pagos</legend>
	<thead>
		<tr id="buttons">
			<td colspan="8" class="text-right">
				<div class="form-inline">
					<button class="btn-xs btn-default" id="bEtiquetas" hidden>Ver Etiquetas</button>
					<button class="btn-xs btn-default" id="bRevisados" hidden >Mover a Revisado</button>
					<button class="btn-xs btn-default" id="bEliminados" hidden >Eliminar</button>
					
					<input type="text" id="buscar" class="form-control" placeholder="Texto a buscar"/>
					<button class="btn-sm btn-default glyphicon glyphicon-search" id="bBuscar"></button>
				</div>
			</td>
		</tr>
		<tr>
			<th colspan="3">Cliente</th>
			<th>Teléfono</th>
			<th>Producto</th>
			<th>Envío</th>
			<th colspan="2">Pago</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<div><center><ul id="pagination" class="pagination"></ul></center></div>
</div>

<script type="text/javascript">

(function($,W,D) {
	var lastAction = "#mEnEspera > a";
	var lastPage = 1;
	var isRepeated = false;

	$(D).ready(function($) {
		$("#menu").show();

		if (result.tipo) {
			selId = result.tipo.replace(" ", "");
			$("#m" + selId).addClass("active");
		}

		$.each(result.tipos, function(key, object) {
			$("#m" + object.DESCRIPCION.replace(" ", "") + " > a").click(function(e) {
				e.preventDefault();
				if (!isRepeated) {
					lastPage = 1;
				}
				lastAction = "#m" + object.DESCRIPCION.replace(" ", "") + " > a";
				mAjax("s_listado.php", {t: object.DESCRIPCION, p: lastPage}, handleResponse, true);
				hideButtons();
				$("#m" + result.tipo.replace(" ", "")).removeClass("active");
				$("#m" + object.DESCRIPCION.replace(" ", "")).addClass("active");
				result.tipo = object.DESCRIPCION;
			});
		});

		displayErrors(result, function(r) {
			switch (r.messageId) {
				case "SUCESS":
					fillData(result.pago);
					setPagination(result.pagina);
					break;
				default:
					return false;
			}
			return true;
		});
	});
	
	repeatAction = function() {
		isRepeated = true;
		$(lastAction).click();
		isRepeated = false;
	};

	repeatActionSilent = function() {
		isRepeated = true;
		disableLoadingLayer();
		$(lastAction).click();
		enableLoadingLayer();
		isRepeated = false;
	};

	showButtons = function() {
		$("#bEtiquetas").show();
		$("#bEliminados").show();
		if (result.tipo == "En Espera") {
			$("#bRevisados").show();
		}
	};

	hideButtons = function() {
		$("#bEtiquetas").hide();
		$("#bEliminados").hide();
		if (result.tipo == "En Espera") {
			$("#bRevisados").hide();
		}
	};

	handleResponse = function(r) {
		displayErrors(r, function(r) {
			switch (r.messageId) {
				case "SUCESS":
					fillData(r.list);
					setPagination(r.pagina);
					break;
				default:
					return false;
			}
			return true;
		});
	};

	fillData = function(myList) {
		$('#tabla > tbody').empty();
		if (myList.length == 0) {
			$('#tabla > tbody').append(
				$('<tr>').append(
					$('<td colspan="8">').text("No se encontraron coincidencias")
				)
			)
		} else {
			$.each(myList, function(key, value){
				if (value.PAGO_METODO == "MercadoPago") {
					metodo = value.PAGO_METODO+" ("+cdate(value.PAGO_FECHA)+")";
					metodod = value.PAGO_METODO+". Fecha: "+cdate(value.PAGO_FECHA);
				}
				else {
					metodo = value.PAGO_METODO+" "+value.PAGO_DESTINO+" ("+cdate(value.PAGO_FECHA)+")";
					metodod = "Método: "+value.PAGO_METODO+" desde banco "+value.PAGO_ORIGEN+" al banco "+value.PAGO_DESTINO+". Fecha "+cdate(value.PAGO_FECHA)+". Comprobante No "+value.PAGO_ID;
				}

				myIcon = [];
				myFeatures = [];
				myClass = "";//color to rows

				switch (value.DESCRIPCION) {
					case "En Espera": default:
						myIcon.push($("<span>").addClass("glyphicon glyphicon-time").attr("title", "En Espera"));
						//myClass = "";
						break;
					case "Revisado":
						myIcon.push($("<span>").addClass("glyphicon glyphicon-edit").attr("title", "Revisado"));
						//myClass = "success";
						break;
					case "Enviado":
						myIcon.push($("<span>").addClass("glyphicon glyphicon-ok").attr("title", "Enviado"));
						//myClass = "info";
						break;
					case "Con Errores":
						myIcon.push($("<span>").addClass("glyphicon glyphicon-remove").attr("title", "Con Errores"));
						//myClass = "danger";
						break;
				}

				if (value.PAGO_EXT) {
					myFeatures.push(" ");
					myFeatures.push($("<span>").addClass("glyphicon glyphicon-picture").attr("title", "Ver Comprobante (" + value.PAGO_EXT.split("/")[1] + ")").click(function(e) {
							W.open("comprobante.php?id=" + value.ID_PAGO, "_blank", "menubar=no, scrollbars=yes, width=800, height=480, top=80, left=80");
						})
					);
				}
				
				myFeatures.push(" ");
				myFeatures.push($("<span>").addClass("glyphicon glyphicon-envelope").attr("title", "Enviar Correo a " + value.USUARIO_CORREO).click(function(e) {
						W.open("enviarmail.php?id=" + value.ID_PAGO, "_blank", "menubar=no, scrollbars=yes, width=800, height=480, top=80, left=80");
					})
				);
				myFeatures.push(" ");
				myFeatures.push($("<span>").addClass("glyphicon glyphicon-print").attr("title", "Ver Etiqueta").click(function(e) {
						W.open("etiqueta.php?id=" + value.ID_PAGO, "_blank", "menubar=no, scrollbars=yes, width=800, height=480, top=80, left=80");
					})
				);


				$("#tabla > tbody").append(
					$("<tr>").attr("id", "item_"+value.ID_PAGO).append(
						$("<td>").append($("<input type='checkbox' name='selection[]'>").attr("id", "sel_"+value.ID_PAGO).val(value.ID_PAGO)),
						$("<td>").append(myIcon),
						$("<td class='linked'>").text(value.RECIBE_NAC+"-"+value.RECIBE_ID+" "+value.RECIBE_NOMBRE+" ("+value.USUARIO_MERCADOLIBRE+")").attr("title", value.RECIBE_NAC+"-"+value.RECIBE_ID+" "+value.RECIBE_NOMBRE+" (Pseudónimo: "+value.USUARIO_MERCADOLIBRE+") Correo: "+value.USUARIO_CORREO),
						$("<td class='linked'>").text(value.RECIBE_TELEFONO).attr("title", value.RECIBE_TELEFONO),
						$("<td class='linked'>").text("[x"+value.ARTICULO_CANTIDAD+"] "+value.ARTICULO_NOMBRE).attr("title", "Unidades: "+value.ARTICULO_CANTIDAD+", Producto: "+value.ARTICULO_NOMBRE),
						$("<td class='linked'>").text(value.RECIBE_EMPRESA+": "+value.RECIBE_CIUDAD+" ("+value.RECIBE_ESTADO+")").attr("title", value.RECIBE_EMPRESA+": "+value.RECIBE_CIUDAD+" (Estado "+value.RECIBE_ESTADO+"). Dirección: "+value.RECIBE_DIRECCION),
						$("<td class='linked'>").text(metodo).attr("title", metodod),
						$("<td class='text-right' style='min-width: 64px'>").append(myFeatures)
					).addClass(myClass)
				);

				$("#item_" + value.ID_PAGO + " > td.linked").click(function(e) {
					W.open("detallesdepago.php?id="+value.ID_PAGO, "_blank", "menubar=no, scrollbars=yes, width=800, height=480, top=64, left=64");
				});

				$("#sel_" + value.ID_PAGO).change(function(e) {
					count = $("input[name='selection[]']:checked").length;
					checked = $(this).is(":checked");
					myId = this.value;

					if (count == 1 && checked) {
						showButtons();
					}
					else if (count == 0 && !checked) {
						hideButtons();
					}

					if (checked) {
						$("#item_" + myId).addClass("warning");
					}
					else {
						$("#item_" + myId).removeClass("warning");
					}
				});
			});
		}
	};

	setPagination = function(pagina) {
		//count page pages
		$("#pagination").empty();
		var prevButton = $("<li>");
		var nextButton = $("<li>");

		//prevButton = $("<span>").text("<");
		//nextButton = $("<span>").text(">");
		//numbers = [];
		////new Function("", "showParam(" + arrOptions[i] + ");");
		

		if (lastPage > 1) {
			prevButton.append(
				$("<a>").attr("href", "#").text("«").attr("page", lastPage - 1).click(function(e) {
					changePage($(e.target).attr("page"));
				})
			);
		}
		else {
			prevButton.addClass("disabled").append($("<a>").attr("href", "#").text("«"));
		}

		if (lastPage < pagina.pages) {
			nextButton.append(
				$("<a>").attr("href", "#").text("»").attr("page", lastPage + 1).click(function(e) {
					changePage($(e.target).attr("page"));
				})
			);
		}
		else {
			nextButton.addClass("disabled").append($("<a>").attr("href", "#").text("»"));
		}

		$("#pagination").append(prevButton);

		for(i = 1; i <= pagina.pages; i++) {
			var myItem = $("<li>");
			if (i != lastPage) {
				myItem.append(
					$("<a>").attr("href", "#").text(i).attr("page", i).click(function(e) {
						changePage($(e.target).attr("page"));
					})
				);
			}
			else {
				myItem.addClass("active").append($("<a>").attr("href", "#").text(i));
			}

			$("#pagination").append(myItem);
		}

		$("#pagination").append(nextButton);
	}

	changePage = function(page) {
		lastPage = page;
		repeatAction();
	}

	getSelectionArray = function() {
		idarray = "";
		$.each($("input[name='selection[]']:checked"), function(key, object) {
			idarray += (key == 0) ? object.value : "|" + object.value;
		});
		return idarray;
	};

	$("#buscar").keyup(function(e) {
	    if(e.keyCode == 13) {
	        $("#bBuscar").click();
	    }
	});

	$("#bBuscar").click(function(e) {
		searchstring = $("#buscar").val();
		if (searchstring != "") {
			mAjax("s_buscar.php", {buscar: searchstring}, handleResponse, true);
			lastAction = "#bBuscar";
		}
	});

	$("#bEtiquetas").click(function(e) {
		W.open("etiqueta.php?id=" + getSelectionArray(), "_blank", "menubar=no, scrollbars=yes, width=800, height=480, top=80, left=80");
	});

	$("#bRevisados").click(function(e) {
		swal({
			title: "¿Está Seguro?",
			text: "¿Confirma que desea Mover los Pagos Seleccionados a Revisados? Esta acción es Irreversible.",
			type: "warning",
			showLoaderOnConfirm: true,
			showCancelButton: true,
			cancelButtonText: "Cancelar",
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Sí, Mover los pagos",
			closeOnConfirm: false
		},
		function() {
			mAjax("s_mover.php?id=" + getSelectionArray() + "&a=Revisado", null, function(r) {
				displayErrors(r, function(r) {
					switch (r.messageId) {
						case "SUCESS":
						case "NO_ENVIO":
							swal("Acción Exitosa", "Los pagos seleccionados se han movido correctamente a Revisados.", "success");
							repeatActionSilent();
							break;
						default:
							return false;
					}
					return true;
				});
			});
		});
	});

	$("#bEliminados").click(function() {
		swal({
			title: "¿Está Seguro?",
			text: "¿Confirma que desea Eliminar los Pagos Seleccionados? Esta acción es Irreversible.",
			type: "warning",
			showLoaderOnConfirm: true,
			showCancelButton: true,
			cancelButtonText: "Cancelar",
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Sí, Eliminar los pagos",
			closeOnConfirm: false
		},
		function() {
			mAjax("s_eliminar.php?id=" + getSelectionArray(), null, function(r) {
				displayErrors(r, function(r) {
					switch (r.messageId) {
						case "SUCESS":
						case "NO_ENVIO":
							swal("Acción Exitosa", "Los pagos seleccionados se han eliminado correctamente.", "success");
							repeatActionSilent();
							break;
						default:
							return false;
					}
					return true;
				});
			});
		});
	});
})(jQuery, window, document);
</script>
