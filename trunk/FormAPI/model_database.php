<?php

include_once("import.php");

/**
  * This class responsibles for handling database access and insert or update new records. 
  *
  * @package formapi
  * @author Zoltan Koppanyi <zoltan.koppanyi@gmail.com>
  * @todo Implement logic!
  * @version 0.1
  */
class DatabaseModel {
	private $url;
	private $port;
	private $database;
	private $user;
	private $pwd;
	private $table;

	public function __construct($url, $port, $database, $user, $pwd, $table)	{		
		$this->url = $url;
		$this->port = $port;
		$this->database = $database;
		$this->user = $user;
		$this->url = $pwd;
		$this->table = $table;

	}

	public function insert($values) {
	}

	public function update($values) {
	}

	public function access($values) {
	}
}
?>
