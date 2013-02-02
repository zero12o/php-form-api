<?php

include_once("import.php");

/**
  * This class responsibles for handling database access and insert or update new records. 
  *
  * @package formapi
  * @author Zoltan Koppanyi <zoltan.koppanyi@gmail.com>
  * @author Zoltan Siki <siki@agt.bme.hu>
  * @todo Implement logic!
  * @version 0.1
  */
class DatabaseModel {
	private $db;
	private $host;
	private $port;
	private $database;
	private $user;
	private $pwd;
	private $table;

	public function __construct($database, $table, $user, $pwd, $host="localhost", $db="mysql", $port=3306)	{		
		$this->host = $host;
		$this->port = $port;
		$this->database = $database;
		$this->user = $user;
		$this->url = $pwd;
		$this->table = $table;
		$this->db = $db;
	}

	/**
	 * Send form data to database
	 * @param <string, string> $value validated key-value pair, key contains the fields names
	 * @param <form> form instance
	 * @return <string> error id
	 */
	public function process($values, $form) {
		try {
			$dbh = new PDO($this->db . ":host=" . $this->host . ";dbname=" .
				$this->database, $this->user, $this->pass);
		} catch (PDOException $e) {
			return $e->getCode();
		}
		// build insert statement
		$sql = "INSERT INTO " . $tis->table;
		$cols = "";
		$vals = "";
		$fields = $form->getFields();
		foreach ($fields as $f) {
			$name = $f->getName();
			if (strlen($cols)) {
				$cols .= ",$name" ;
			}else {
				$cols = $name;
			}
			if (isset($values[$name])) {
				if (is_array($values[$name])) {
				} else {
				}
			}
		}
		return 0;
	}

	public function access($values) {
	}
}
?>
