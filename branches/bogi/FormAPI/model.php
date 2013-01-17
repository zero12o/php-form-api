<?php

include_once("import.php");

/**
  * Abstract class for model classes. There are two abstract function
  * that have to be implemented for custom handling. @see Model::process($value)
  * function responsible for process the response (i.e. store data) from client and @see Model::access($value)
  * function responsible for get values from storage
  *
  * @package formapi
  * @author Zoltan Koppanyi <zoltan.koppanyi@gmail.com>
  * @abstract
  * @version 0.1
  */
abstract class Model {

	public function __construct($action) {
	}

	/**
	 * Process and store/update data
	 *
	 * @param <string, string> $value validated key-value pair, key contains the column of the table
	 * @param Form $form form definition
	 *
	 * @return string process results as string 
	 */
	public abstract function process($values, $form);

	/**
	 * Implements the data access
	 *
	 * @param <string, string> $value key-value pair, key contains the column(s) of the table, values are null
	 *
	 * @return <string, string> $value key-value pair, key contains the column(s) of the table, values are filled from storage
	 */
	public abstract function access($values);
}
?>
