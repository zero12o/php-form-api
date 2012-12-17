<?php

class ListField extends Field {

	protected $label = 0;
	protected $length = 10;
	protected $help = -1;
	protected $options = array();

	
	public function __construct($id, $name, $label, $length, $help, $options) {
		$this->id = $id;
		$this->name = $name;
		$this->label = $label;
		$this->length = $length;
		$this->help = $help;
		$this->options = $options;
	}

	public function generate($form, $lang) {

			$w = "<div class=\"textc\">";
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
			$w .= "</div>";
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
		return "list";
	}
}

?>
