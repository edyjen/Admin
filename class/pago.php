<?php
/* Registro de Pago.
	@autor: Pedro Parra (edyjen@hotmail.com)
	@ver 1.00
*/

require_once("../kernel/template.php");
require_once("../class/envio.php");

class Pago extends Template {
	private $countPerPage = 20;
	private $pages;
	private $page;
	public function __construct($handler) {
		parent::__construct("PAGO", "ID_PAGO", $handler);
		$this->data["USUARIO_MERCADOLIBRE"] = '';
		$this->data["USUARIO_CORREO"] = '';
		$this->data["ARTICULO_NOMBRE"] = '';
		$this->data["ARTICULO_CANTIDAD"] = '';
		$this->data["RECIBE_NAC"] = '';
		$this->data["RECIBE_ID"] = '';
		$this->data["RECIBE_NOMBRE"] = '';
		$this->data["RECIBE_TELEFONO"] = '';
		$this->data["RECIBE_EMPRESA"] = '';
		$this->data["RECIBE_ESTADO"] = '';
		$this->data["RECIBE_CIUDAD"] = '';
		$this->data["RECIBE_MUNICIPIO"] = '';
		$this->data["RECIBE_DIRECCION"] = '';
		$this->data["RECIBE_ASEGURADO"] = '';
		$this->data["PAGO_METODO"] = '';
		$this->data["PAGO_ORIGEN"] = '';
		$this->data["PAGO_DESTINO"] = '';
		$this->data["PAGO_ID"] = '';
		$this->data["PAGO_FECHA"] = '';
		$this->data["PAGO_MONTO"] = '';
		$this->data["PAGO_ARCHIVO"] = '';
		$this->data["PAGO_EXT"] = '';
		$this->data["OBSERVACION"] = '';
		$this->data["ID_ESTADO_PRODUCTO"] = '';
	}

	public function loadHtml($html) {
		$this->data["USUARIO_MERCADOLIBRE"] = $this->parseSQL($html["USUARIO_MERCADOLIBRE"]);
		$this->data["USUARIO_CORREO"] = strtolower($this->parseSQL($html["USUARIO_CORREO"]));
		$this->data["ARTICULO_NOMBRE"] = $this->parseSQL($html["ARTICULO_NOMBRE"]);
		$this->data["ARTICULO_CANTIDAD"] = $this->parseSQL($html["ARTICULO_CANTIDAD"]);
		$this->data["RECIBE_NAC"] = $this->parseSQL($html["RECIBE_NAC"]);
		$this->data["RECIBE_ID"] = $this->parseSQL($html["RECIBE_ID"]);
		$this->data["RECIBE_NOMBRE"] = strtotitle($this->parseSQL($html["RECIBE_NOMBRE"]));
		$this->data["RECIBE_TELEFONO"] = $this->parseSQL($html["RECIBE_TELEFONO"]);
		$this->data["RECIBE_EMPRESA"] = $this->parseSQL($html["RECIBE_EMPRESA"]);
		$this->data["RECIBE_ESTADO"] = $this->parseSQL($html["RECIBE_ESTADO"]);
		$this->data["RECIBE_CIUDAD"] = $this->parseSQL($html["RECIBE_CIUDAD"]);
		$this->data["RECIBE_MUNICIPIO"] = $this->parseSQL($html["RECIBE_MUNICIPIO"]);
		$this->data["RECIBE_DIRECCION"] = ((array_key_exists("AGENCIA", $html)) ? "Agencia: " : "Dirección: ") . $this->parseSQL($html["RECIBE_DIRECCION"]);
		$this->data["RECIBE_ASEGURADO"] = $this->parseSQL($html["RECIBE_ASEGURADO"]);
		$this->data["PAGO_METODO"] = $this->parseSQL($html["PAGO_METODO"]);
		$this->data["PAGO_ORIGEN"] = $this->parseSQL($html["PAGO_ORIGEN"]);
		$this->data["PAGO_DESTINO"] = $this->parseSQL($html["PAGO_DESTINO"]);
		$this->data["PAGO_ID"] = $this->parseSQL($html["PAGO_ID"]);
		$this->data["PAGO_FECHA"] = dbdate($this->parseSQL($html["PAGO_FECHA"]));
		$this->data["PAGO_MONTO"] = $this->parseSQL($html["PAGO_MONTO"]);
		$this->data["PAGO_ARCHIVO"] = (array_key_exists("PAGO_ARCHIVO", $html)) ? $this->parseSQL($html["PAGO_ARCHIVO"]) : "";
		$this->data["PAGO_EXT"] = $this->parseSQL($html["PAGO_EXT"]);
		$this->data["OBSERVACION"] = $this->parseSQL($html["OBSERVACION"]);
		$this->data["ID_ESTADO_PRODUCTO"] = $this->parseSQL($html["ID_ESTADO_PRODUCTO"]);
	}

	public function setDefaults() {
		$this->data["ID_ESTADO_PRODUCTO"] = $this->searchIdEstado("En Espera");
		if ($this->data["PAGO_METODO"] == "MercadoPago") {
			$this->data["PAGO_ID"] = time();
		}
	}

	public function sendMailDelivered() {
		$info = $this->handler->getInfo();
		$this->data["envio"] = $this->getEnvio();
		$contenido = $this->loadFile("../html/mail/package_delivered.php");
		return $this->sendMail($contenido, $info["asunto_mailenviado"]);
	}

	public function sendMailAccepted() {
		$info = $this->handler->getInfo();
		$contenido = $this->loadFile("../html/mail/payment_accepted.php");
		return $this->sendMail($contenido, $info["asunto_mailrevisado"]);
	}

	public function sendMailError() {
		$info = $this->handler->getInfo();
		$contenido = $this->loadFile("../html/mail/payment_denied.php");
		return $this->sendMail($contenido, $info["asunto_mailerrores"]);
	}

	public function sendMailReceived() {
		$info = $this->handler->getInfo();
		$contenido = $this->loadFile("../html/mail/payment_registered.php");
		return $this->sendMail($contenido, $info["asunto_mailrecibido"]);
	}

	public function sendMail($mailContent, $mailSubject) {
		$info = $this->handler->getInfo();
		$server = $info["email"];
		$client = $this->data["USUARIO_CORREO"];
		if (mail($client, $mailSubject, $mailContent, "From: $server\nContent-Type: text/html; charset=utf-8\nContent-Transfer-Encoding: 8bit")){
			$this->handler->setMessage("MAIL_SUCESS", "Correo enviado correctamente");
			return true;
		} else {
			$this->handler->setMessage("MAIL_FAILED", "No se pudo enviar el correo");
			return false;
		}
	}

	public function sendCustomMail($html) {
		$mailSubject = $html["asunto"];
		$mailContent = $html["mensaje"];
		return $this->sendMail($mailContent, $mailSubject);
	}

	public function setEnvio($html) {
		$envio = new Envio($this->handler);
		$envio->setHtmlArray($html);
		if (!$envio->canBeSaved()) {
			return false;
		}
		
		return $envio->saveDb();
	}

	public function getEnvio() {
		$envio = new Envio($this->handler);
		if (!$envio->loadDbByPago($this->getId())) {
			$this->handler->setMessage("NO_ENVIO", "No existen datos de envio");
			return false;
		}
		return $envio->toArray();
	}

	public function loadNoMediaDb($id) {
		return $this->loadDbById("ID_PAGO, USUARIO_MERCADOLIBRE, USUARIO_CORREO, ARTICULO_NOMBRE, ARTICULO_CANTIDAD, RECIBE_NAC, RECIBE_ID, RECIBE_NOMBRE, RECIBE_TELEFONO, RECIBE_EMPRESA, RECIBE_ESTADO, RECIBE_CIUDAD, RECIBE_MUNICIPIO, RECIBE_DIRECCION, RECIBE_ASEGURADO, PAGO_METODO, PAGO_ORIGEN, PAGO_DESTINO, PAGO_ID, PAGO_FECHA, PAGO_MONTO, PAGO_EXT, OBSERVACION, ID_ESTADO_PRODUCTO", $id);
	}

	public function loadMediaDb($id) {
		return $this->loadDbById("ID_PAGO, PAGO_ARCHIVO", $id);
	}

	public function getPaginationInfo() {
		return array(
			"count" => $this->count,
			"page" => $this->page,
			"pages" => $this->pages
		);
	}

	public function getArrayList($condition, $page) {
		$condition = $this->parseSQL($condition);
		$count = ($this->handler->dbQuery("SELECT COUNT(*) AS COUNT FROM ESTADO_PRODUCTO JOIN $this->_tableName ON ESTADO_PRODUCTO.ID_ESTADO_PRODUCTO=PAGO.ID_ESTADO_PRODUCTO WHERE DESCRIPCION='$condition'")) ? $this->handler->dbResult() : 0;
		$this->count = $count[0]["COUNT"];
		$limit = $this->countPerPage;
		$this->pages = floor(($this->count + $limit - 1) / $limit);
		$this->page = $page;
		$offset = ($page - 1) * $limit;
		return ($this->handler->dbQuery("SELECT ID_PAGO, USUARIO_MERCADOLIBRE, USUARIO_CORREO, ARTICULO_NOMBRE, ARTICULO_CANTIDAD, RECIBE_NAC, RECIBE_ID, RECIBE_NOMBRE, RECIBE_TELEFONO, RECIBE_EMPRESA, RECIBE_ESTADO, RECIBE_CIUDAD, RECIBE_MUNICIPIO, RECIBE_DIRECCION, RECIBE_ASEGURADO, PAGO_METODO, PAGO_ORIGEN, PAGO_DESTINO, PAGO_ID, PAGO_FECHA, PAGO_MONTO, PAGO_EXT, OBSERVACION, ESTADO_PRODUCTO.ID_ESTADO_PRODUCTO AS ID_ESTADO_PRODUCTO, DESCRIPCION FROM ESTADO_PRODUCTO JOIN $this->_tableName ON ESTADO_PRODUCTO.ID_ESTADO_PRODUCTO=PAGO.ID_ESTADO_PRODUCTO WHERE DESCRIPCION='$condition' ORDER BY $this->_tableId DESC LIMIT $limit OFFSET $offset")) ? $this->handler->dbResult() : false;
	}

	public function searchIdEstado($name) {
		$name = $this->parseSQL($name);
		$datos = ($this->handler->dbQuery("SELECT ID_ESTADO_PRODUCTO AS ID FROM ESTADO_PRODUCTO WHERE DESCRIPCION='$name'")) ? $this->handler->dbResult() : false;
		return $datos[0]["ID"];
	}

	public function searchDescripcionEstado($id) {
		$id = $this->parseSQL($id);
		$datos = ($this->handler->dbQuery("SELECT DESCRIPCION FROM ESTADO_PRODUCTO WHERE ID_ESTADO_PRODUCTO='$id'")) ? $this->handler->dbResult() : false;
		return $datos[0]["DESCRIPCION"];
	}

	public function getEstados() {
		return ($this->handler->dbQuery("SELECT * FROM ESTADO_PRODUCTO")) ? $this->handler->dbResult() : false;
	}

	public function searchText($text) {
		if (!$text) {
			return false;
		}

		$text = explode(" ", $this->parseSQL($text));
		$condition = "";
		foreach ($text as $key => $value) {
			if ($key != 0) {
				$condition .= " AND ";
			}
			$condition .= "CONCAT(RECIBE_ID, RECIBE_NOMBRE, RECIBE_TELEFONO, USUARIO_CORREO) LIKE '%" . $value . "%'";
		}

		return ($this->handler->dbQuery("SELECT ID_PAGO, USUARIO_MERCADOLIBRE, USUARIO_CORREO, ARTICULO_NOMBRE, ARTICULO_CANTIDAD, RECIBE_NAC, RECIBE_ID, RECIBE_NOMBRE, RECIBE_TELEFONO, RECIBE_EMPRESA, RECIBE_ESTADO, RECIBE_CIUDAD, RECIBE_MUNICIPIO, RECIBE_DIRECCION, RECIBE_ASEGURADO, PAGO_METODO, PAGO_ORIGEN, PAGO_DESTINO, PAGO_ID, PAGO_FECHA, PAGO_MONTO, PAGO_EXT, OBSERVACION, ESTADO_PRODUCTO.ID_ESTADO_PRODUCTO AS ID_ESTADO_PRODUCTO, DESCRIPCION FROM $this->_tableName JOIN ESTADO_PRODUCTO ON ESTADO_PRODUCTO.ID_ESTADO_PRODUCTO=PAGO.ID_ESTADO_PRODUCTO WHERE $condition")) ? $this->handler->dbResult() : false;
	}
	

	public function getDescripcionEstado() {
		return $this->searchDescripcionEstado($this->data["ID_ESTADO_PRODUCTO"]);
	}

	public function getIdEstado() {
		return $this->data["ID_ESTADO_PRODUCTO"];
	}

	public function updateEstado($id_estado) {
		$id_estado = $this->parseSQL($id_estado);
		$from = $this->getDescripcionEstado();

		if (!$from) {
			$this->handler->setMessage("FAILED", "No se puede leer el estado de origen");
			return false;
		}

		$to = $this->searchDescripcionEstado($id_estado);

		if (!$to) {
			$this->handler->setMessage("FAILED", "No se puede leer el estado destino");
			return false;
		}

		if ($from == $to) {
			$this->handler->setMessage("ABORTED", "El pago ya se encuentra en " . $from);
			return false;
		}

		if ($from == "Enviado" || $from == "Con Errores") {
			$this->handler->setMessage("ABORTED", "El pago no se puede mover de " . $from);
			return false;
		}

		if ($from == "Revisado" && ($to == "En Espera" || $to == "Con Errores")) {
			$this->handler->setMessage("ABORTED", "El pago no se puede mover de " . $from . " a " . $to);
			return false;
		}

		if ($from == "En Espera" && $to == "Enviado") {
			$this->handler->setMessage("ABORTED", "El pago no se puede mover de " . $from . " a " . $to);
			return false;
		}

		$changes = array("ID_ESTADO_PRODUCTO" => $id_estado);

		return $this->updateDb($changes);
	}

	public function restoreEstado($id_estado) {
		$id_estado = $this->parseSQL($id_estado);
		$changes = array("ID_ESTADO_PRODUCTO" => $id_estado);
		return $this->updateDb($changes);
	}

	public function addMedia($filedata) {
		if ($filedata["size"] == 0) {
			$this->handler->setMessage("MEDIA_FAILED", "Ha ocurrido un error con el comprobante de pago");
			return false;
		}

		switch ($filedata["type"]) {
			case "image/jpeg":
			case "image/png":
			case "image/gif":
			case "image/bmp":
			case "application/pdf":
				break;
			default:
				$this->handler->setMessage("MEDIA_NOT_ALLOWED", "Formato de Archivo Incorrecto. Sólo se permiten las extensiones .jpg .png .gif .bmp .pdf");
				return false;
		}

		if ($filedata["size"] > 1048575) {
			$this->handler->setMessage("MEDIA_SIZE_LIMIT", "Tamaño de imágen máximo es de 1024kb. Su archivo es de " . floor($filedata["size"] / 1024) . "kb");
			return false;
		}

		$filename = $filedata["tmp_name"];

		$f = fopen($filedata["tmp_name"], "r");
		$this->data["PAGO_ARCHIVO"] = $this->parseSQL(fread($f, $filedata["size"]));
		$this->data["PAGO_EXT"] = $filedata["type"];
		return true;
	}

	public function showMedia() {
		header("Content-Type: " . $this->data["PAGO_EXT"]);
		echo $this->data["PAGO_ARCHIVO"];
	}

	public function canBeSaved() {
		$cedula = $this->data["RECIBE_ID"];
		$pago = $this->data["PAGO_ID"];
		if ($this->isSaveAllowed("RECIBE_ID='$cedula' AND PAGO_ID='$pago'")) {
			$this->handler->setMessage("SAVE_ALLOWED", "El registro es guardable");
			return true;
		}
		else {
			$this->handler->setMessage("SAVE_NOT_ALLOWED", "El registro ya existe");
			return false;
		}
	}

	public function deleteFromDb() {
		$id = $this->getId();
		if (!$this->handler->dbDelete("ENVIO", "ID_PAGO=$id")) {
			return false;
		}

		return $this->deleteDb();
	}
}

?>