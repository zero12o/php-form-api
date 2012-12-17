<?php

include_once("import.php");

/**
  * This class convert response into HTML code
  *
  * @package formapi
  * @author Zoltan Koppanyi <zoltan.koppanyi@gmail.com>
  * @version 0.1
  */
class EchoModel extends Model {

	/**
	 * Default constructor
	 */
	public function __construct()	{		

	}

	/**
	 * Create HTML representation of the data
	 *
	 * @param <string, string> $value validated key-value pair, key contains the fields names
	 *
	 * @return string HTML representation of the data
	 */
	public function insert($values) {
		$response = "<table>";
		foreach(array_keys($values) as $key) {
			$response .= "<tr><td><b>" . $key . "</b></td><td>" . $values[$key] . "</td></tr>";
		}
		$response .= "</table>";
		return $response;
	}

	/**
	 * Create HTML representation of the data
	 *
	 * @param <string, string> $value validated key-value pair, key contains the fields names
	 *
	 * @return string HTML representation of the data
	 */
	public function update($values) {
		return $this->insert($values);
	}

	/**
	 * No access logic, but override this function can be used as Mock object.
	 *
	 * @param <string, string> $value 
	 *
	 * @return string 
	 */
	public function access($values) {
	}
}
?>
