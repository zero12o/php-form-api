<?php

class RadioField extends Field {

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
		$w = "<td class=\"labelc\">" . 
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
		return $w;
	}

	/**
	 * Get type of field
	 *
	 * @return string type of field
	 */
	public function getType() {
		return "radio";
	}

}

?>
