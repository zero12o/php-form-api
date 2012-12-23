<?php

/**
  * Field class to generate and select RadioBoxes.
  *
  * @property string $type the type of the field (i.e. radio).
  * @property int $label label ID of Field
  * @property int $length number of items in one row, 0 all items in a sigle row
  * @property string[] $options label IDs for radio items
  *
  * @package formapi
  * @author Zoltan Siki <siki@agt.bme.hu> and Zoltan Koppanyi <zoltan.koppanyi@gmail.com>
  * @version 0.1
  */
class RadioField extends Field {

	protected $label;
	protected $length;
	protected $options = array();

	public function __construct($id, $name, $label, $options, $length=10,
		$requested=false, $default=NULL, $regexp=NULL, $help=NULL) {

		parent::__construct($id, $name, $requested, $default, $regexp, $help);
		$this->label = $label;
		$this->length = $length;
		$this->options = $options;
		$this->type = "radio";
	}

	public function generate($form, $lang) {
			$w = "<div class=\"textc\">";
			for ($i=0; $i < count($this->options);$i++) {
				if ($this->length > 0 && $i > 0 && $i % $this->length == 0) {
					$w .= "<br />";
				}
				$w .= "<input type=\"radio\" name=\"" . $this->name . "\"" .
					" title=\"" . $form->getMsg($this->help, $lang) . "\"" .
					" value=\"" . $this->name . $i . "\"";
				if ($this->default == $i) {
					$w .= " CHECKED";
				}
				$w .= " />" . $form->getMsg($this->options[$i], $lang) . " ";
			}
			$w .= "</div>";
		return $w;
	}

	public function generateLabel($form, $lang) {
		$w = "<div class=\"labelc\">" . 
				$form->getMsg($this->label, $lang) . "</div>";
		return $w;
	}
}

?>
