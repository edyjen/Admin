<?php
/* Controlador de Servidor.
	@autor: Pedro Parra (edyjen@hotmail.com)
	@ver 1.01
*/

//start up
date_default_timezone_set('America/Caracas');
ini_set('session.use_trans_sid', '0');

//requeriments
require_once(__DIR__ . "/session.php");
require_once(__DIR__ . "/dbtoken.php");

class Controller {
	//database handler
	public $db;

	//session handler
	public $session;

	//json response
	protected $output;

	//server info
	protected $info;

	//startup errors
	protected $noErrors;


	public function __construct() {
		$this->output = array();
		$this->noErrors = true;

		if (array_key_exists("USE_SESSION", $GLOBALS)) {
			$this->noErrors &= $this->getSessionData();
		}

		if (array_key_exists("USE_DATABASE", $GLOBALS)) {
			$this->noErrors &= $this->connectDatabase();
		}

		$this->info = array(
			"name" => "Crea mi Plantilla",
			"email" => "info@creamiplantilla.com.ve",
			"phone" => "0424-1234567 / 0293-5552222",
			"asunto_mailrecibido" => "Gracias por su compra",
			"asunto_mailrevisado" => "Hemos verificado su pago",
			"asunto_mailenviado" => "Hemos enviado el producto",
			"asunto_mailerrores" => "No hemos podido confirmar su pago"
		);

		$this->info["envios"] = array("Domesa", "Grupo Zoom", "MRW", "Entrega Personal");
		$this->info["bancos"] = array("Banco Banesco", "Banco de Venezuela", "Banco del Tesoro");
		$this->info["metodo"] = array("Depósito", "Transferencia", "MercadoPago");
	}

	public function checkErrors() {
		return !$this->noErrors;
	}

	public function getSessionData() {
		$this->session = new Session();

		$this->output["session"] = array();
		$this->output["session"]["NOMBRE"] = $this->session->getVar("NOMBRE");
		$this->output["session"]["LOGIN"] = $this->session->getVar("LOGIN");
		$this->output["session"]["PRIV"] = checkval($this->session->getVar("PRIV"), 0);
		$this->output["session"]["ACTIVO"] = $this->session->getVar("ACTIVO");
		return true;
	}

	public function connectDatabase() {
		$this->db = new DatabaseHandler($db_server, $db_database, $db_username, $db_password, $db_portnumb);

		$result = $this->db->connect();
		$this->setMessage($this->db->messageId, $this->db->messageId);

		return $result;
	}

	public function checkPermission($n) {
		if ($this->output["session"]["PRIV"] >= $n) {
			$this->setMessage("PERMISSION_GRANTED", "Se ha permitido el acceso");
			return true;
		}
		else {
			$this->setMessage("PERMISSION_DENIED", "Se ha denegado el acceso");
			return false;
		}
	}

	public function getInfo() {
		return $this->info;
	}

	public function setData($key, $value) {
		$this->output[$key] = $value;
	}

	public function showData() {
		echo json_encode($this->output);
	}

	public function dbQuery($sql_query) {
		if ($this->db->query($sql_query)) {
			$this->setMessage("SUCESS", "Datos obtenidos satisfactoriamente");
			return true;
		}
		else {
			$this->setMessage("FAILED", "Error al obtener los datos");
			return false;
		}
	}

	public function dbInsert($table, $values) {
		if ($this->db->insert($table, $values)) {
			$this->setMessage("SUCESS", "Datos registrados satisfactoriamente");
			return true;
		}
		else {
			$this->setMessage("FAILED", "Error al registrar los datos");
			return false;
		}
	}

	public function dbUpdate($table, $condition, $values) {
		if ($this->db->update($table, $condition, $values)) {
			$this->setMessage("SUCESS", "Datos actualizados satisfactoriamente");
			return true;
		}
		else {
			$this->setMessage("FAILED", "Error al actualizar los datos");
			return false;
		}
	}

	public function dbDelete($table, $condition) {
		if ($this->db->delete($table, $condition)) {
			$this->setMessage("SUCESS", "Datos eliminados satisfactoriamente");
			return true;
		}
		else {
			$this->setMessage("FAILED", "Error al eliminar los datos");
			return false;
		}
	}

	public function dbResult() {
		return $this->db->getResult();
	}

	public function loadFile($url) {
		ob_start();
		require($url);
		return ob_get_clean();
	}
	
	public function showPage($template, $title, $file) {
		require("../html/result.php");
		$content = $this->loadFile("../html/view/" . $file . ".php");
		require("../html/" . $template . ".php");
	}

	public function generateCaptcha() {
		$char = strtoupper(substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 4));
		$str = str_shuffle(rand(1, 7) . rand(1, 7) . $char);

		$this->session->registerValue("captcha", $str);
	}

	public function checkCaptcha($text) {
		if (strtoupper($text) == $this->session->getVar("captcha")) {
			$this->setMessage("CAPTCHA_OK", "Captcha correcto");
			return true;
		}
		else {
			$this->setMessage("CAPTCHA_FAILED", "Los Caracteres no coinciden con la imágen");
			return false;
		}
	}

	private function log($string) {
		$file = fopen(__DIR__ . "/../log.txt", "a");
		fputs($file, date("d/m/Y h:i:s a ") . " HW " . $string . "\r\n");
		fclose($file);
	}

	public function setMessage($msgId, $msgText) {
		$this->setData("messageId", $msgId);
		$this->setData("messageText", $msgText);
		//$this->log($msgId . "\t" . $msgText);
	}
}

function checkval($value, $default) {
	if (empty($value) && !is_numeric($value)) {
		return $default;
	}
	else {
		return $value;
	}
}

$h = new Controller();

?>