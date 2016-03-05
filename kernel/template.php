<?php
/* Gestor de Objetos Guardables en bases de datos.
	@autor: Pedro Parra (edyjen@hotmail.com)
	@ver 1.00
*/

abstract class Template {
	protected $_tableName;
	protected $_tableId;
	protected $data;
	protected $id;
	protected $handler;

	public function __construct($tablename, $keyColumn, $handler) {
		$this->_tableName = $tablename;
		$this->_tableId = $keyColumn;
		$this->id = '';
		$this->handler = $handler;
	}

	private function setDBArray($query) {
		foreach ($this->data as $key => $value) {
			$this->data[$key] = array_key_exists($key, $query) ? $query[$key] : null;
		}
		$this->id = $query[$this->_tableId];
	}

	public function setHtmlArray($array) {
		$this->loadHtml($array);
		$this->id = $this->parseSQL($array[$this->_tableId]);
	}

	public function getId() {
		return $this->id;
	}

	public function getCount() {
		$result = $this->handler->dbQuery("SELECT COUNT($this->_tableId) FROM $this->_tableName");

		if (!$result) {
			return false;
		}

		return $this->handler->db->getCol(0);
	}

	public function getArrayDb($columns, $order, $condition) {
		if (isset($order)) {
			$order = "ORDER BY $order";
		} else {
			$order = "";
		}

		if (isset($condition)) {
			$condition = "WHERE ($condition)";
		} else {
			$condition = "";
		}

		if ($this->handler->dbQuery("SELECT $columns FROM $this->_tableName $condition $order"))
			return $this->handler->dbResult();
		else
			return false;
	}

	public function getFullArrayDb($order, $condition) {
		return $this->getArrayDb("*", $order, $condition);
	}

	public function toArray() {
		$fulldata = $this->data;
		$fulldata[$this->_tableId] = $this->id;
		return $fulldata;
	}

	abstract public function loadHtml($html);

	public function loadDb($columns, $condition) {
		if ($this->handler->dbQuery("SELECT $columns FROM $this->_tableName WHERE ($condition)")) {
			$result = $this->handler->dbResult();
			if ($this->handler->db->getRows() > 0) {
				$this->handler->setMessage("SUCESS", "Load Completed");
				$this->setDBArray($result[0]);
				return true;
			}
			else {
				$this->handler->setMessage("EMPTY", "No se encontraron coincidencias");
			}
		}
		
		return false;
	}

	public function loadDbById($columns, $id) {
		$id = $this->parseSQL($id);
		
		return $this->loadDb($columns, "$this->_tableId='$id'");
	}

	public function fullLoadDb($condition) {
		return $this->loadDb("*", $condition);
	}

	public function fullLoadDbById($id) {
		return $this->loadDbById("*", $id);
	}

	public function parseSQL($sql_query) {
		return $this->handler->db->val($sql_query);
	}

	public function isSaveAllowed($condition) {
		$this->handler->dbQuery("SELECT $this->_tableId FROM $this->_tableName where ($condition)");
		if ($this->handler->db->getRows() > 0) {
			$result = $this->handler->dbResult();
			$resultId = $result[0][$this->_tableId];

			if ($resultId != $this->id)
				return false;
		}

		return true;
	}

	public function addDb() {
		return $this->handler->dbInsert($this->_tableName, $this->data);
	}

	public function saveDb() {
		return ($this->isNotStored()) ? $this->addDb() : $this->updateDb($this->data);
	}

	public function updateDb($array) {
		return ($this->isNotStored()) ? null : $this->handler->dbUpdate($this->_tableName, "$this->_tableId=$this->id", $array);
	}

	public function deleteDb() {
		return ($this->isNotStored()) ? null : $this->handler->dbDelete($this->_tableName, "$this->_tableId=$this->id");
	}

	private function isNotStored() {
		return ($this->id == "");
	}

	public function loadFile($url) {
		$data = $this->data;
		$info = $this->handler->getInfo();
		ob_start();
		require($url);
		return ob_get_clean();
	}
}

function strtotitle($string) {
	return ucwords(strtolower($string));
}

function cdate($datein) {
	$result = preg_split("/[\/\-\.]+/", $datein);
	return ($datein) ? (($result[0] > 1900) ? "$result[2]/$result[1]/$result[0]" : "$result[0]/$result[1]/$result[2]") : "";
}

function dbdate($datein) {
	$result = preg_split("/[\/\-\.]+/", $datein);
	return ($datein) ? (($result[0] <= 1900) ? "$result[2]-$result[1]-$result[0]" : "$result[0]-$result[1]-$result[2]") : "";
}

?>