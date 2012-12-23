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
	public function __construct() {
	}

	/**
	 * Create HTML representation of the data
	 *
	 * @param <string, string> $value validated key-value pair, key contains the fields names
	 *
	 * @return string HTML representation of the data
	 */
	public function process($values, $form) {
		$fields = $form->getFields();
		$response = "<table>";

		foreach ($fields as $f) {
			$name = $f->getName();
			if (isset($values[$name])) {
				$response .= "<tr><td><b>" . $name . "</b></td>";
				if (is_array($values[$name])) {
					$response .= "<td>";
					foreach ($values[$name] as $v) {
						$response .= $v . " ";
					}
					$response .= "</td></tr>";
				} else {
					$response .= "<td>" . $values[$name] . "</td></tr>";
				}
			} else {
				$response .= "<tr><td><b>" . $name . "</b></td><td>-</td></tr>";
			}
		}
		$response .= "</table>";
		return $response;
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
