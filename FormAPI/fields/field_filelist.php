<?php

/**
  * Field class to generate and select List.
  *
  * @property string $type the type of the field (i.e. filelist).
  * @property string $dir root dir for the file name list
  * @property boolean $recursdirs search subdirectories recursevly
  *
  * @package formapi
  * @author Zoltan Siki <siki@agt.bme.hu>
  * @version 0.1
  * @todo path lost when recu0rsdirs
  */

class FileListField extends ListField {

	protected $dir;
	protected $recursdirs;

	public function __construct($id, $name, $label, $regexp, $dir, $recursdirs=false, 
		$length=10, $requested=false, $help=NULL) {

		$this->regexp = $regexp;
		$this->dir = $dir;
		$this->recursdirs = $recursdirs;
		$this->options = array();
		$this->getFiles($dir);

//		$options = glob($mask);
		parent::__construct($id, $name, $label, $this->options, $length, 
			$requested, $regexp, $help);
		$this->type = "filelist";
	}

	public function getFiles($dir) {
		$d = opendir($dir);
		while (($entry = readdir($d))) {
			if ($entry == "." || $entry == "..") continue;
			if (is_dir($entry) && $this->recursdirs) {
				$this->getFiles($entry);
			} else {
				if (preg_match($this->regexp, $entry)) {
					$this->options[] = $entry;
				}
			}
		}
	}
}
