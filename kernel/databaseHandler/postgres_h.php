<?php
/* Gestor de Base de Datos PostgreSQL.
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
	}

	public function connect() {
		try {
			$this->connection_id = @pg_connect("host=" . $this->db_server . " dbname=" . $this->db_database . " user=" . $this->db_username . " password=" . $this->db_password . " port=" . $this->db_port);

			if(!$this->connection_id) {
				$this->messageId = "DATABASE_CONNECTION_ERROR";
				$this->messageText = "Cannot access PostgreSQL Server: " . $this->db_server;
				throw new Exception("No Database Access");
			}
		}
		catch(Exception $e) {
			$this->sql_error = $e->getMessage();
			$this->log();
			return false;
		}

		return true;
	}

	private function _query($query) {
		try {
			$this->result = @pg_query($this->connection_id, $query);
			if(!$this->result) {
				$this->messageId = "QUERY_SYNTAX_ERROR";
				$this->messageText = "Cannot execute query: \"" . $query . "\"";
				throw new Exception(pg_last_error());
			}
			else {
				$this->messageId = "QUERY_SUCESSFUL";
				$this->messageText = "query: \"" . $query . "\"";
				$this->log();
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
			$this->rows = @pg_num_rows($this->result);
			return true;
		}
		else {
			$this->rows = 0;
			return false;
		}
	}

	public function getResult() {
		$this->messageId = "DATA_RETURNED";
		$this->messageText = "data: \"" . $this->result . "\"";
		$this->log();
		return @pg_fetch_all($this->result);
	}

	public function getCol($no) {
		return @pg_fetch_result($this->result, 0, $no);
	}

	public function getRows() {
		return $this->rows;
	}

	public function insert($table, $values) {
		$cols = implode(",", array_keys($values));

		foreach ($values as $key => $value)
			$values[$key] = "'$value'";

		$values = implode(",", $values);
		$values = str_replace("''", "NULL", $values);

		if ($this->_query("INSERT INTO $table($cols) VALUES ($values)")) {
			$this->rows = @pg_num_rows($this->result);
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
			$this->rows = @pg_num_rows($this->result);
			return true;
		}
		else {
			$this->rows = 0;
			return false;
		}
	}

	public function delete($table, $condition) {
		if ($this->_query("DELETE FROM $table WHERE $condition")) {
			$this->rows = @pg_num_rows($this->result);
			return true;
		}
		else {
			$this->rows = 0;
			return false;
		}
	}

	public function val($query) {
		return pg_escape_string($query);
	}

	public function executeFile($filename) {
		$f = file_get_contents($filename);
		$sqlArray = explode(';', $f);
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
		$file = fopen(__DIR__ . "/sql_log.txt", "a");
		fputs($file, date("d/m/Y h:i:s a ") . $this->messageId . " @ " . $this->messageText . " - " . $this->sql_error . "\r\n");
	}
}

?>