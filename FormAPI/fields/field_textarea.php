<?php

/**
  * Field class to generate and fill textarea fields.
  *
  * @property string $type the type of the field (i.e. text).
  * @property int $label label ID of Field
  * @property int $length number of items in one row, 0 all items in a sigle row
  * @property int $maxlength maximal number of input chars
  * @proberty int $rows number of rows to display
  *
  * @package formapi
  * @author Zoltan Siki <siki@agt.bme.hu> and Zoltan Koppanyi <zoltan.koppanyi@gmail.com>
  * @version 0.1
  */

class TextareaField extends Field {

	protected $length;
	protected $maxlength;
	protected $rows;
	
	public function __construct($id, $name, $label, $length=80, $rows=4,
		$requested=false, $default=NULL, $regexp=NULL, $help=NULL) {

		parent::__construct($id, $name, $requested, $default, $regexp, $help);
		$this->label = $label;
		$this->length = $length;
		$this->rows = $rows;
		$this->maxlength = $rows * $length;
		$this->type = "textarea";
	}

	public function generate($form, $lang) {
		$w = "<div class=\"textc\">" . 
			"<textarea" .
			" cols=\"" . $this->length . "\"" .
			" rows=\"" . $this->rows . "\"" .
			" name=\"" . $this->name . "\"" .
			" title=\"" . $form->getMsg($this->help, $lang) . "\"" .
			" >" . $this->default . "</textarea>";
			"</div>";
		return $w;
	}
}

?>
