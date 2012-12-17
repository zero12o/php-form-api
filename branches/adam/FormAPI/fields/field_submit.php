<?php

class SubmitField extends Field {

	protected $label = 0;
	
	public function __construct($id, $name, $label, $length, $maxlength, $help) {
		$this->id = $id;
		$this->name = $name;
		$this->label = $label;
	}

	public function generate($form, $lang) {
		$w = "<div><input type=\"submit\" value=\"" .
					$form->getMsg($this->label, $lang) . "\" name=\"" .
					$this->name . "\" /></div>";
		return $w;
	}

	public function generateLabel($form, $lang) {
		$w = "<div>&nbsp;</div>";
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
		return "submit";
	}
}

?>
