<?php
class ZipCodeField extends Field {

	protected $label = 0;
	protected $help = -1;
	protected $length = 4;
	protected $maxlength = 4;
	
	public function __construct($id, $name, $label, $length, $maxlength, $help) {
		$this->id = $id;
		$this->name = $name;
		$this->label = $label;
		$this->length = $length;
		$this->maxlength = $maxlength;
		$this->help = $help;
	}

	public function generate($form, $lang) {
			$w = "<div class=\"textc\"><input type=\"text\" maxlength=\"" .
				$this->maxlength . "\" size=\"" .
				$this->length . "\" value=\"" .
				$this->default . "\" name=\"" .
				$this->name . "\" /></div>";
		return $w;
	}
	
	public function generateLabel($form, $lang) {
			$w = "<div class=\"labelc\">" . 
				$form->getMsg($this->label, $lang) . "</div>";
		return $w;
	}

	/**
	 * Get type of field
	 *
	 * @return string type of field
	 */
	public function getType() {
		return "zipcode";
	}

}

?>
