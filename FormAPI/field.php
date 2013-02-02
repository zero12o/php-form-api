<?php

include_once("import.php");

/**
  * Abstract class of fields classes. All fields have to be extended this class and
  * have to be implemented its abstract functions. The subclass responsible for initialize
  * the protected properites via its constructor.
  *
  * @property string $type field type (e.g. text, check, radio, etc)
  * @property int $id the unique id of field
  * @property string $name the unique name of field, that represents the field in the POST or GET request
  * @property boolean $requested true, if the field must be filled, false otherwise
  * @property int $default the message id of default text or ordinal value of default radio, list item, NULL represents that there is no default value
  * @property string regexp regular expression to validate user input, NULL if no validation
  * @property int $help the message id of popup message for the field, NULL if no help message
  * @property int $label label ID of Field
  *
  * @package formapi
  * @author Zoltan Siki <siki@agt.bme.hu> and Zoltan Koppanyi <zoltan.koppanyi@gmail.com>
  * @version 0.1
  */
abstract class Field {
	protected $type;
	protected $id;
	protected $name;
	protected $requested;
	protected $default;
	protected $regexp;
	protected $help;
	protected $label;

	function __construct($id, $name, $requested=false, $default=NULL, $regexp=NULL, $help=NULL) {
		$this->id = $id;
		$this->name = $name;
		$this->requested = $requested;
		$this->default = $default;
		$this->regexp = $regexp;
		$this->help = $help;
		$this->label = "";
	}

	/**
	 * Abstract function that responsible for creating HTML code of the field. This code
	 * return only the input part of the field between <div> tag.
	 *
	 * @param Form $form form object that contains the field instance
	 * @param string $lang language code that has been specified in form definition in XML file
 	 *
	 * @return string HTML code of input part of the field
	 */
	public abstract function generate($form, $lang);

	/**
	 * Function that is responsible for creating HTML code the  
	 * label of the field between <div> tags.
	 *
	 * @param Form $form form object that contains the field instance
	 * @param string $lang language code that has been specified in form definition in XML file
 	 *
	 * @return string HTML code of label of field as string
	 */
	public function generateLabel($form, $lang) {
		$w = "<div class=\"labelc\">" .
			$form->getMsg($this->label, $lang) . "</div>";
		return $w;
	}

	/**
	 * Get type of field
	 *
	 * @return string type of field (e.g. list, button, ...)
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Get unique ID of field
	 *
	 * @return int Unique ID of field
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Get ID for generate HTML code. This ID will represents the field in the HTML code.
	 *
	 * @return int HTML ID of the field
	 */
	public function getHtmlId() {
		return "FAPI_" . $this->getType() . "_" . $this->id;
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
	 * Set regexp
	 *
	 * @param string $regexp Regexp as a string
	 */
	public function setRegexp($regexp) {
		$this->regexp = $regexp;
	}

	/**
	 * Get actual regexp
	 *
	 * @return string Actual regexp as a string, it is "" if no regexp has been specified
	 */
	public function getRegexp() {
		return $this->regexp;
	}

	/**
	 * Convert field definition to string (only for debugging)
	 *
	 * @return string
	 */
	public function __toString() {
		$w = $this->getType() . " field -";
		foreach ($this as $attr => $val) {
			$w .= " " . $attr . ":" . $val;
		}
		return $w;
	}

	/**
	 * Function that responsible for validating values. It can be used for checking
	 * response values from clients.
	 *
	 * @param string $value value that has to be checked
 	 *
	 * @return boolean true, if the value is valid, false otherwise
	 */
	public function check($value) {
		// skip array (check, radio, list)
		if (is_array($value)) {
			return true;
		}
		$value = trim($value);
		// obligatory field?
		if ($this->requested and empty($value)) {
			return false;
		}
		// empty value accepted
		if (empty($value)) {
			return true;
		}
		// check length
		if (isset($this->maxLength) && ! empty($this->maxLength) &&
			$this->maxLength < strlen($value)) {
			return false;
		}
		// if regexp has not been specified, accept all value
		if (empty($this->regexp)) {
			return true;
		}
		// regular expression match
		if (preg_match($this->regexp, $value)) {
			return true;
		}
		return false;
	}
}

?>
