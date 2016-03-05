<?php
/* Usuarios
	@autor: Pedro Parra (edyjen@hotmail.com)
	@ver 1.00
*/

require_once("../kernel/template.php");

class Usuario extends Template {
	public function __construct($handler) {
		parent::__construct("USUARIO", "ID_USUARIO", $handler);
		$this->data["NOMBRE"] = '';
		$this->data["LOGIN"] = '';
		$this->data["PASS"] = '';
		$this->data["PRIV"] = '0';
		$this->data["ACTIVO"] = 1;
	}

	public function loadHtml($datos) {
		$this->data["NOMBRE"] = $this->parseSQL($datos["NOMBRE"]);
		$this->data["LOGIN"] = strtolower($this->parseSQL($datos["LOGIN"]));
		$this->data["PASS"] = md5($this->parseSQL($datos["PASS"]));
		$this->data["PRIV"] = $this->parseSQL($datos["PRIV"]);
		$this->data["ACTIVO"] = $this->parseSQL($datos["ACTIVO"]);
	}

	public function login($datos) {
		$login = strtolower($this->parseSQL($datos["LOGIN"]));
		$pass = md5($this->parseSQL($datos["PASS"]));

		return $this->fullLoadDb("LOGIN='$login' and PASS='$pass'");
	}

	public function changePass($datos) {
		if (!array_key_exists("NUEVA_PASS", $datos)) {
			$this->handler->setMessage("FAILED_PASS2", "No se ha recibido la contraseña nueva");
			return false;
		}

		if (!array_key_exists("PASS", $datos)) {
			$this->handler->setMessage("FAILED_PASS", "No se ha recibido la contraseña actual");
			return false;
		}

		$this->fullLoadDbById($this->handler->session->getVar("ID_USUARIO"));

		if (md5($datos["PASS"]) != $this->data["PASS"]) {
			$this->handler->setMessage("FAILED_PASS", "La contraseña actual es Incorrecta");
			return false;
		}

		$changes = array("PASS" => md5($this->parseSQL($datos["NUEVA_PASS"])));
		return $this->updateDb($changes);
	}

	public function canBeSaved() {
		$login = $this->data["LOGIN"];
		return $this->isSaveAllowed("LOGIN='$login'");
	}
}

?>