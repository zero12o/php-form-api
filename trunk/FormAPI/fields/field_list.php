<?php

/**
  * Field class to generate and select List.
  *
  * @property string $type the type of the field (i.e. list).
  * @property int $label label ID of Field
  * @property int $length number of visible items, 0 combo list
  * @property string[] $options label IDs for list items
  *
  * @package formapi
  * @author Zoltan Siki <siki@agt.bme.hu> and Zoltan Koppanyi <zoltan.koppanyi@gmail.com>
  * @version 0.1
  * @todo title popup doesnot work
  */

class ListField extends Field {

	protected $label;
	protected $length;
	protected $options = array();
	
	public function __construct($id, $name, $label, $options, $length=10,
		$requested=false, $default=NULL, $help=NULL) {

		parent::__construct($id, $name, $requested, $default, NULL, $help);
		$this->label = $label;
		$this->length = $length;
		$this->options = $options;
		$this->type = "list";
	}

	public function generate($form, $lang) {

			$w = "<div class=\"textc\">";
			$w .= "<select";
			if ($this->length) {
				$w .= " size=\"" . (string) $this->length . "\"";
			}
			$w .= ">";
			for ($i = 0; $i < count($this->options);$i++) {
				$w .= "<option value=\"" . $this->name . $i . "\"" .
					" title=\"" . $form->getMsg($this->help, $lang) . "\"";
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
}

?>
