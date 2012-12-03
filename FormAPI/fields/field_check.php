<?php

/**
  * Field class for generate and check CheckBoxes.
  *
  * @property string $type the type of the field (i.e. check).
  * @property int $label label ID of Field
  * @property int $length 
  * @property int $help
  * @property string[] $options 
  *
  * @package formapi
  * @author Zoltan Siki <siki@agt.bme.hu> and Zoltan Koppanyi <zoltan.koppanyi@gmail.com>
  * @abstract
  * @version 0.1
  */
class CheckField extends Field {

	protected $label = 0;
	protected $length = 3;
	protected $help = 12;
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
				$w .= "<input type=\"checkbox\" name=\"" .
					$this->name . "\" value=\"" .
					$this->name . $i . "\" />" .
					$form->getMsg($this->options[$i], $lang) . " ";
			}
		$w .= "</td>";
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
		return "check";
	}

}

?>
