<?php

/**
  * Field class to generate and select file to upload.
  *
  * @property string $type the type of the field (i.e. file).
  * @property int $label label ID of Field
  * @property int $length width of file name field
  * @property int maxlength maximal size (bytes) of uploading file
  *
  * @package formapi
  * @author Zoltan Siki <siki@agt.bme.hu> and Zoltan Koppanyi <zoltan.koppanyi@gmail.com>
  * @version 0.1
  * @todo configure button text (Browse)
  * @todo title tooltipp doesn't work
  */

class FileField extends Field {

	protected $length;
	protected $maxlength;
	
	public function __construct($id, $name, $label, $length=20, 
		$maxlength=120, $requested=false, $help=NULL) {

		parent::__construct($id, $name, $requested, NULL, NULL, $help);
		$this->label = $label;
		$this->length = $length;
		$this->maxlength = $maxlength;
		$this->type = "file";
	}

	public function generate($form, $lang) {
		$w = "<div class=\"filec\">";
			if ($this->maxlength > 0)  {
				$w .="<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"" .
				$this->maxlength . "\" />";
			}
			$w .= "<input type=\"file\" size=\"" . $this->length .
				" title=\"" . $form->getMsg($this->help, $lang) . "\"" .
				"\" name=\"" . $this->name . "\" /></div>";
		return $w;
	}
}

?>
