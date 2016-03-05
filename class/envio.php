<?php
/* Envio de un producto.
    @autor: Pedro Parra (edyjen@hotmail.com)
    @ver 1.00 (enero 26, 2016)
*/

require_once("../kernel/template.php");

class Envio extends Template {
	public function __construct($handler) {
		parent::__construct("ENVIO", "ID_ENVIO", $handler);
		$this->data["ID_PAGO"] = '';
		$this->data["ENVIO_ID"] = '';
		$this->data["ENVIO_FECHA"] = '';
		$this->data["ENVIO_EMPRESA"] = '';
	}

	public function loadHtml($html) {
		$this->data["ID_PAGO"] = $this->parseSQL($html["ID_PAGO"]);
		$this->data["ENVIO_ID"] = $this->parseSQL($html["ENVIO_ID"]);
		$this->data["ENVIO_FECHA"] = dbdate($this->parseSQL($html["ENVIO_FECHA"]));
		$this->data["ENVIO_EMPRESA"] = $this->parseSQL($html["ENVIO_EMPRESA"]);
	}

	public function canBeSaved() {
		$pago = $this->data["ID_PAGO"];
		if ($this->isSaveAllowed("ID_PAGO='$pago'")) {
			 $this->handler->setMessage("SAVE_ALLOWED", "El registro es guardable");
			return true;
		}
		else {
			 $this->handler->setMessage("SAVE_NOT_ALLOWED", "Ya contiene un envío registrado");
			return false;
		}
	}

	public function loadDbByPago($id_pago) {
		$id_pago = $this->parseSQL($id_pago);
		return $this->fullLoadDb("ID_PAGO='$id_pago'");
	}
}

?>