<?php

include_once("import.php");

/**
  * Singleton class for creating FormAPI control object. This class responsible for initializing the FormAPI control object.
  * With its @see FormAPIFactory::create($xml, $target, $model, $id = 1)  
  *
  * @property FormAPIFactory $instance instance of singelton object
  *
  * @see http://en.wikipedia.org/wiki/Singleton_pattern
  * @package formapi
  * @author Zoltan Siki <siki@agt.bme.hu> and Zoltan Koppanyi <zoltan.koppanyi@gmail.com>
  * @version 0.1
  */
class FormAPIFactory {
	private static $instance;
	
	/**
	 * Default constructor, which is hidden
	 *
	 */
	private function __construct()	{
	}

	/**
	 * Create and getting the singelton instance
	 *
	 * @return FormAPIFactory instance of factory class
	 */
	public static function getInstance() {
		if (is_null( self::$instance)) {
			self::$instance = new self();
	    	}
		return self::$instance;
	}

	/**
	 * Create FormAPI instance from XML file
	 *
	 * @param string $xml XML filename and location
	 * @param string $action URL of target php file, that receive the request
	 *
	 * @return FormAPI instance of control object
	 * @todo Implements Model creation from XML file
	 */
	public function create($xml, $action, $model, $layout=Form::vertLayout, $mode="post", $id=1) {

		// form object
		$form = new form($id);
		$form->setMode($mode);
		$form->setLayout($layout);
		$form->setTarget($action);

		// parsing fields tag
		$xmlobj = new SimpleXMLElement($xml, 0, true);
		$form->setName((string) $xmlobj->fields[0]["name"]);
		$form->setTitle(intval((string) $xmlobj->fields[0]["title"]));

		// process fields
		foreach ($xmlobj->fields[0]->field as $f) {
			$fields = &$form->getFields();

			$id = intval((string) $f["id"]);
			$name = (string) $f["name"];
			$requested = ((string) $f["requested"] == "yes") ? true : false;
			$w = (string) $f;
			$default = (strlen($w)) ? intval($w) : NULL;
			$regexp = (string) $f["regexp"];
			$w = (string) $f["help"];
			$help = (strlen($w)) ? intval($w) : NULL;
//			unset($options);
			$options = NULL;

			// create text field
			if($f["type"] == "text") {
				$label = intval((string) $f["label"]);
				$length = intval((string) $f["length"]);
				$maxlength = intval((string) $f["maxlength"]);

				$fields[$id] = new TextField($id, $name, $label, $length, $maxlength,
					$requested, $default, $regexp, $help);
			}

			// create check field	
			if($f["type"] == "check") {
				$label = intval((string) $f["label"]);
				$length = intval((string) $f["length"]);

				if (isset($f->option)) {					
					foreach ($f->option as $o) {
						$options[] = intval((string) $o);
					}
				}

				$fields[$id] = new CheckField($id, $name, $label, $options, $length,
					$requested, $default, $help);
			}

			// create radio field
			if($f["type"] == "radio") {
				$label = intval((string) $f["label"]);
				$length = intval((string) $f["length"]);

				if (isset($f->option)) {
					foreach ($f->option as $o) {
						$options[] = intval((string) $o);
					}
				}

				$fields[$id] = new RadioField($id, $name, $label, $options, $length, 
					$requested, $default, NULL, $help);
			}

			// create list field
			if($f["type"] == "list") {

				$label = intval((string) $f["label"]);
				$length = intval((string) $f["length"]);

				if (isset($f->option)) {
					foreach ($f->option as $o) {
						$options[] = intval((string) $o);
					}
				}

				$fields[$id] = new ListField($id, $name, $label, $options, $length, 
					$requested, $default, $help);
			}

			// create file field
			if($f["type"] == "file") {
				$label = intval((string) $f["label"]);
				$length = intval((string) $f["length"]);
				$maxlength = intval((string) $f["maxlength"]);

				if (isset($f->option)) {
					foreach ($f->option as $o) {
						$options[] = intval((string) $o);
					}
				}

				$fields[$id] = new FileField($id, $name, $label, $length, $maxlength,
					$requested, $help);
			}

			// create submit field
			if($f["type"] == "submit") {
				$label = intval((string) $f["label"]);
				$fields[$id] = new SubmitField($id, $name, $label, $help);
			}

			// create reset field
			if($f["type"] == "reset") {
				$label = intval((string) $f["label"]);
				$fields[$id] = new ResetField($id, $name, $label, $help);
			}

			//TODO: Add XML process logic for further fields
		}

		// process messages and inject into Form object
		foreach ($xmlobj->messages[0]->message as $m) {
			$messages = &$form->getMessages();
			$messages[(string) $m["id"]][(string) $m["language"]] = (string) $m;
		}

		//TODO Implement Model creation from model

		return new FormAPI($form, $model);
	}




}

?>
