<?php

class FileField extends Field {

	protected $label = 0;
	protected $help = -1;
	protected $length = 20;
	protected $maxlength = 50;
	
	public function __construct($id, $name, $label, $length, $maxlength, $help) {
		$this->id = $id;
		$this->name = $name;
		$this->label = $label;
		$this->length = $length;
		$this->maxlength = $maxlength;
		$this->help = $help;
	}

	public function generate($form, $lang) {
		$w = "<div class=\"filec\">";
			if ($this->maxlength > 0)  {
				$w .="<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"" .
				$this->maxlength . "\" />";
			}
			$w .= "<input type=\"file\" size=\"" . $this->length .
				"\" name=\"" . $this->name . "\" /></div>";
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
		return "file";
	}
}

?>
