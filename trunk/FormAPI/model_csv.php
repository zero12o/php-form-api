<?php

include_once("import.php");

/**
  * This class convert response into text (CSV) file 
  *
  * @package formapi
  * @author Zoltan Siki <siki@agt.bme.hu>
  * @version 0.1
  */
class CsvModel extends Model {

	protected $dir;
	protected $fieldSep;
	protected $sep;
	/**
	 * Default constructor
	 * @param <string> $dir writeable target directory on server
	 */
	public function __construct($dir=".", $fieldSep=";", $sep=",") {
		if (! preg_match('/\/$/', $dir)) {
			$dir .= "/";
		}
		$this->dir = $dir;
		$this->fieldSep = $fieldSep;
		$this->sep = $sep;
	}

	/**
	 * Create CSV representation of the data
	 *
	 * @param <string, string> $value validated key-value pair, key contains the fields names
	 * @param <form> form instance
	 *
	 * @return error code or 0
	 */
	public function process($values, $form) {
		$fields = $form->getFields();
		$fpath = $this->dir . $form->getName() . ".csv";
		if (! file_exists($fpath)) {
			$fp = fopen($fpath, "w");
			// write header
			$buf = "";
			foreach ($fields as $f) {
				$buf .= $f->getName() . $this->fieldSep;
			}
			$buf .= "\n";
			fwrite($fp, $buf);
		} else {
			$fp = fopen($fpath, "a");
		}
		$buf = "";

		foreach ($fields as $f) {
			$name = $f->getName();
			if (isset($values[$name])) {
				if (is_array($values[$name])) {
					foreach ($values[$name] as $v) {
						$buf .= $f->getOption($v) . $this->sep;
					}
				} else {
					// replace special chars to space
					$pat ="/[" . $this->fieldSep . "\\r\\n]/";
					$buf .= preg_replace($pat, " ", $values[$name]);
				}
			}
			$buf .= $this->fieldSep;
		}
		$buf .= "\n";
		fwrite($fp, $buf);
		fclose($fp);
		return 0;
	}

	/**
	 * No access logic, but override this function can be used as Mock object.
	 *
	 * @param <string, string> $value 
	 *
	 * @return string 
	 */
	public function access($values) {
	}
}
?>
