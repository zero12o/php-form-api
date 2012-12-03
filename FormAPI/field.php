<?php

include_once("import.php");

/**
  * Abstract class of fields classes. All fields have to be extended this class and
  * have to be implemented its abstract functions. The subclass responsible for initialize
  * the protected properites via its constructor.
  *
  * @property int $id the unique id of field
  * @property string $name the unique name of field, that represents the field in the POST or GET request
  * @property boolean $requested true, if the field has to be filled by user, false otherwise
  * @property string|int|boolean $default the default value of the field, -1 represents that there is no default value
  *
  * @package formapi
  * @author Zoltan Siki <siki@agt.bme.hu> and Zoltan Koppanyi <zoltan.koppanyi@gmail.com>
  * @version 0.1
  */
abstract class Field {

	protected $id;
	protected $name;
	protected $requested = false;
	protected $default = -1;

	/**
	 * Abstract function that responsible for creating HTML code of the field. When implemented
	 * this function the return value must contain the HTML code as string 
	 *
	 * @param Form $form form object that contains the field instance
	 * @param string $lang language code that has been specified in form definition in XML file
 	 *
	 * @return string HTML code of form as string
	 */
	public abstract function generate($form, $lang);

	/**
	 * Abstract function that responsible for validating values. It can be used for checking
	 * response values from clients.
	 *
	 * @param string $value value that has to be checked
 	 *
	 * @return boolean true, if the value is valid, false otherwise
	 */
	public abstract function check($value);

	/**
	 * Get type of field
	 *
	 * @return string type of field (e.g. list, button, ...)
	 */
	public abstract function getType();

	/**
	 * Get unique ID of field
	 *
	 * @return int Unique ID of field
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Get name of field (it is unqiue in a form) 
	 *
	 * @return string unique name of field (it is unqiue in a form) 
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Is the field requested
	 *
	 * @return boolean true, if the field has to be filled by user, false otherwise
	 */
	public function getRequested() {
		return $this->requested;
	}

	/**
	 * Set thet the field has to be filled
	 *
	 * @param boolean $requested true, if the field has to be filled by user, false otherwise
	 */
	public function setRequested($requested) {
		$this->requested = $requested;
	}

	/**
	 * Default value of the field
	 *
	 * @return string default value of the field as string
	 */
	public function getDefault() {
		return $this->default;
	}

	/**
	 * Set the default value of the field
	 *
	 * @param string $default new default value of the field as string
	 */
	public function setDefault($default) {
		$this->default = $default;
	}

	/**
	 * Convert field definition to string (only for debugging)
	 *
	 * @return string
	 */
	public function toString() {
		$w = "Field -";
		foreach ($this as $attr => $val) {
			$w .= " " . $attr . ":" . $val;
		}
		return $w;
	}
}

?>
