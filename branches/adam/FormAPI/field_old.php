<?php

include_once("config.php");

/**
 * The field class stores data to generate the different form 
 * input/button/etc. elements
 *
 * @property int $id unique ordinal number for the field
 * @property string $name unique name of the field, used as HTML name tag in input fields
 * @property int $label id of the text in the message array put in front of the input field
 * @property string $type type of input field possible values are: text, check, radio, list, submit, reset
 * @property int $length length of input field, number of check, radio in a row, length of list, combolist
 * @property int $maxlength maxlength for text fields
 * @property int $help help id of popup help for field
 * @property boolean $requested TRUE for obligatory fields
 * @property string $default default value for text fields or ordinal number of default check, radio item
 * @property string $regexp regular expression to validate input field
 */

class Field {
	protected $id;
	protected $name;
	protected $label;
	protected $type;
	protected $length;
	protected $maxlength;
	protected $help;
	protected $requested;
	protected $default;
	protected $options = array();
	protected $regexp;

	/**
	 * Construct a form field
	 *
	 * @author Zoltan Siki <siki@agt.bme.hu>
	 *
	 * @param SimpleXMLObject $f field description
	 *
	 * @return void
	 */
	public function __construct($f) {
		$this->id = intval((string) $f["id"]);
		$this->name = (string) $f["name"];
		$this->label = intval((string) $f["label"]);
		$this->type = strtolower((string) $f["type"]);
		$this->length = intval((string) $f["length"]);
		$this->maxlength = intval((string) $f["maxlength"]);
		$this->help = intval((string) $f["help"]);
		if (preg_match("/^[yYiIjJ]/", (string) $f["requested"])) {
			$this->requested = TRUE;
		} else {
			$this->requested = FALSE;
		}
		$this->regexp = (string) $f["regexp"];
		$this->default = (string) $f;
		if (isset($f->option)) {
			foreach ($f->option as $o) {
				$this->options[] = intval((string) $o);
			}
		}
		if ($this->maxlength < $this->length) {
			$this->maxlength = $this->length;
		}
	}

	/**
	 * generate HTML tags for this field
	 *
	 * @param form $form container form
	 * @param string $lang language code (e.g en)
	 *
	 * @return void
	 */
	public function generate($form, $lang) {
		$w = "<tr>";
		switch ($this->type) {
		case "text":
			$w .= "<td class=\"labelc\">" . 
				$form->getMsg($this->label, $lang) . "</td>";
			$w .= "<td class=\"textc\"><input type=\"text\" maxlength=\"" .
				$this->maxlength . "\" size=\"" .
				$this->length . "\" value=\"" .
				$this->default . "\" name=\"" .
				$this->name . "\" /></td>";
			break;
		case "check":
			$w .= "<td class=\"labelc\">" . 
				$form->getMsg($this->label, $lang) . "</td>";
			$w .= "<td class=\"textc\">";
			for ($i=0; $i < count($this->options);$i++) {
				if ($this->length > 0 && $i > 0 && $i % $this->length == 0) {
					$w .= "<br />";
				}
				$w .= "<input type=\"checkbox\" name=\"" .
					$this->name . "\" value=\"" .
					$this->name . $i . "\" />" .
					$form->getMsg($this->options[$i], $lang) . " ";
			}
			$w .= "</td>";
			break;
		case "radio":
			$w .= "<td class=\"labelc\">" . 
				$form->getMsg($this->label, $lang) . "</td>";
			$w .= "<td class=\"textc\">";
			for ($i=0; $i < count($this->options);$i++) {
				if ($this->length > 0 && $i > 0 && $i % $this->length == 0) {
					$w .= "<br />";
				}
				$w .= "<input type=\"radio\" name=\"" . $this->name . "\"";
				if ($this->default == $i) {
					$w .= " CHECKED";
				}
				$w .= " value=\"" . $this->name . $i . "\" />" .
					$form->getMsg($this->options[$i], $lang) . " ";
			}
			$w .= "</td>";
			break;
		case "list":
			$w .= "<td class=\"labelc\">" . 
				$form->getMsg($this->label, $lang) . "</td>";
			$w .= "<td class=\"textc\">";
			$w .= "<select";
			if ($this->length) {
				$w .= " size=\"" . (string) $this->length . "\"";
			}
			$w .= ">";
			for ($i = 0; $i < count($this->options);$i++) {
				$w .= "<option value=\"" . $this->name . $i . "\"";
				if ($this->default == $i) {
					$w .= " selected";
				}
				$w .= " />" . $form->getMsg($this->options[$i], $lang) .
					"</option>";
			}
			$w .= "</select>";
			$w .= "</td>";
			break;
		case "file":
			$w .= "<td class=\"labelc\">" . 
				$form->getMsg($this->label, $lang) . "</td>";
			$w .= "<td class=\"filec\">";
			if ($this->maxlength > 0)  {
				$w .="<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"" .
				$this->maxlength . "\" />";
			}
			$w .= "<input type=\"file\" size=\"" . $this->length .
				"\" name=\"" . $this->name . "\" /></td>";
			break;
		case "submit":
			$w .= "<td>&nbsp;</td><td><input type=\"submit\" value=\"" .
					$form->getMsg($this->label, $lang) . "\" name=\"" .
					$this->name . "\" /></td>";
			break;
		case "reset":
			$w .= "<td>&nbsp;</td><td><input type=\"reset\" value=\"" .
					$form->getMsg($this->label, $lang) . "\" name=\"" .
					$this->name . "\" /></td>";
			break;
		}
		$w .= "</tr>";
		return $w;
	}

	/**
	 * Get the name of the field
	 *
	 * @return string the field name
	 */
	function getName() {
		return $this->name;
	}

	/**
	 * convert field definition to string (only for debugging)
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
