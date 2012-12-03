<?php

class ResetField extends Field {

	protected $label = 0;
	
	public function __construct($id, $name, $label, $length, $maxlength, $help) {
		$this->id = $id;
		$this->name = $name;
		$this->label = $label;
	}

	public function generate($form, $lang) {
		$w = "<td>&nbsp;</td><td><input type=\"reset\" value=\"" .
					$form->getMsg($this->label, $lang) . "\" name=\"" .
					$this->name . "\" /></td>";
		return $w;
	}

	public function check($value) {
		return true;
	}

	/**
	 * Get type of field
	 *
	 * @return string type of field
	 */
	public function getType() {
		return "reset";
	}

}

?>
