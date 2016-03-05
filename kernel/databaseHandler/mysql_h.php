<?php
/* Gestor de Base de Datos MySQL.
	@autor: Pedro Parra (edyjen@hotmail.com)
	@ver 1.00
*/

class DatabaseHandler {
	protected $connection_id;
	protected $result;
	protected $rows;
	public $sql_error;
	public $messageId;
	public $messageText;
	protected $db_server;
	protected $db_database;
	protected $db_username;
	protected $db_password;
	protected $db_port;

	public function __construct($server, $database, $username, $password, $port) {
		$this->db_server = $server;
		$this->db_database = $database;
		$this->db_username = $username;
		$this->db_password = $password;
		$this->db_port = $port;
		$this->sql_error = "";
	}

	private function _query($query) {
		try {
			$this->result = @mysql_query($query, $this->connection_id);
			
			if($this->result) {
				$this->messageId = "QUERY_SUCESS";
				$this->messageText = $query;
				//$this->log();
			}
			else {
				$this->messageId = "QUERY_SYNTAX_ERROR";
				$this->messageText = "Cannot execute query: " . $query;
				throw new Exception(mysql_error($this->connection_id));
			}
			
		}
		catch(Exception $e) {   
			$this->sql_error = $e->getMessage();
			$this->log();
			return false;
		}

		return true;
	}

	public function connect() {
		try {
			$this->connection_id = @mysql_connect($this->db_server, $this->db_username, $this->db_password);

			if(!$this->connection_id) {
				$this->messageId = "DATABASE_CONNECTION_ERROR";
				$this->messageText = "Cannot access MySQL Server: " . $this->db_server;
				throw new Exception("No Database Access");
			}
			else if (!@mysql_select_db($this->db_database, $this->connection_id)) {
				$this->messageId = "DATABASE_SELECTION_ERROR";
				$this->messageText = "Cannot access MySQL database: " . $this->db_database;
				throw new Exception(mysql_errno());
			}
			else {
				$this->messageId = "DATABASE_CONNECTION_SUCESS";
				$this->messageText = $this->db_server . "/" . $this->db_database;
			}
		}
		catch(Exception $e) {
			$this->sql_error = $e->getMessage();
			$this->log();
			return false;
		}

		return true;
	}

	public function query($query) {
		if ($this->_query($query)) {
			$this->rows = @mysql_num_rows($this->result);
			return true;
		}
		else {
			$this->rows = 0;
			return false;
		}
	}

	public function insert($table, $values) {
		$cols = implode(",", array_keys($values));

		foreach ($values as $key => $value)
			$values[$key] = "'$value'";

		$values = implode(",", $values);
		$values = str_replace("''", "NULL", $values);

		if ($this->_query("INSERT INTO $table($cols) VALUES ($values)")) {
			$this->rows = @mysql_affected_rows($this->result);
			return true;
		}
		else {
			$this->rows = 0;
			return false;
		}
	}

	public function update($table, $condition, $values) {
		foreach ($values as $key => $value)
			$values[$key] = "$key='$value'";

		$values = implode(",", $values);
		$values = str_replace("''", "NULL", $values);

		if ($this->_query("UPDATE $table SET $values WHERE $condition")) {
			$this->rows = @mysql_affected_rows($this->result);
			return true;
		}
		else {
			$this->rows = 0;
			return false;
		}
	}

	public function delete($table, $condition) {
		if ($this->_query("DELETE FROM $table WHERE $condition")) {
			$this->rows = @mysql_affected_rows($this->result);
			return true;
		}
		else {
			$this->rows = 0;
			return false;
		}
	}

	public function getResult() {
		$rows = array();
		while ($data = @mysql_fetch_assoc($this->result)) {
			$rows[] = $data;
		}
		return $rows;
	}

	public function getCol($no) {
		return @mysql_result($this->result, $no);
	}

	public function getRows() {
		return $this->rows;
	}

	public function val($query) {
		return mysql_real_escape_string($query);
	}

	public function executeFile($filename) {
		$f = file_get_contents($filename);
		$sqlArray = explode(';',$f);
		$result = true;

		foreach ($sqlArray as $stmt) {
			if (strlen($stmt) > 3) {
				if (!$this->_query(end(explode('*/', $stmt)))) {
					$result = false;
				}
			}
		}
		return true;
	}

	private function log() {
		$file = fopen(__DIR__ . "/../../log.txt", "a");
		fputs($file, date("d/m/Y h:i:s a ") . " DB " . $this->messageId . " @ " . $this->messageText . " # " . $this->sql_error . "\r\n");
		fclose($file);
	}
}

?>