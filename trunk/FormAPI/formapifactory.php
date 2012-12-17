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
	public static function getInstance()
	  {
	    if ( is_null( self::$instance ) )
	    {
	      self::$instance = new self();
	    }
	    return self::$instance;
	  }

	/**
	 * Create FormAPI instance from XML file
	 *
	 * @param string $xml XML filename and location
	 * @param string $target URL of target php file, that receive the request
	 * @param Model $model model object, that process the request
	 *
	 * @return FormAPI instance of control object
	 * @todo Implements Model creation from XML file
	 */
	public function create($xml, $target, $model, $id = 1) {

		// form object
		$form = new form($id, $target);

		// parsing fields tag
		$xmlobj = new SimpleXMLElement($xml, 0, true);
		$form->setName((string) $xmlobj->fields[0]["name"]);
		$form->setMode((string) $xmlobj->fields[0]["mode"]);
		$form->setTitle((string) $xmlobj->fields[0]["title"]);
		$form->setLayout((string) $xmlobj->fields[0]["layout"]);

		// process fields
		foreach ($xmlobj->fields[0]->field as $f) {
			$id = intval((string) $f["id"]);
			$fields = &$form->getFields();

			$id = intval((string) $f["id"]);
			$name = (string) $f["name"];
			$regexp = (string) $f["regexp"];
			$requested = (string) $f["requested"];

			// create text field
			if($f["type"] == "text") {
				$label = intval((string) $f["label"]);
				$help = intval((string) $f["help"]);
				$length = intval((string) $f["length"]);
				$maxlength = intval((string) $f["maxlength"]);
				$default = intval((string) $f["default"]);

				$fields[$id] = new TextField($id, $name, $label, $length, $maxlength, $help);
				$fields[$id]->setDefault($default);
			}

			// create check field	
			if($f["type"] == "check") {
				$label = intval((string) $f["label"]);
				$length = intval((string) $f["length"]);
				$help = intval((string) $f["help"]);
				$default = intval((string) $f["default"]);

				if (isset($f->option)) {
					foreach ($f->option as $o) {
						$options[] = intval((string) $o);
					}
				}

				$fields[$id] = new CheckField($id, $name, $label, $length, $help, $options);
				$fields[$id]->setDefault($default);
			}

			// create radio field
			if($f["type"] == "radio") {
				$label = intval((string) $f["label"]);
				$length = intval((string) $f["length"]);
				$help = intval((string) $f["help"]);
				$default = intval((string) $f["default"]);

				if (isset($f->option)) {
					foreach ($f->option as $o) {
						$options[] = intval((string) $o);
					}
				}

				$fields[$id] = new RadioField($id, $name, $label, $length, $help, $options);
				$fields[$id]->setDefault($default);
			}

			// create list field
			if($f["type"] == "list") {

				$label = intval((string) $f["label"]);
				$length = intval((string) $f["length"]);
				$help = intval((string) $f["help"]);
				$default = intval((string) $f["default"]);

				if (isset($f->option)) {
					foreach ($f->option as $o) {
						$options[] = intval((string) $o);
					}
				}

				$fields[$id] = new ListField($id, $name, $label, $length, $help, $options);
				$fields[$id]->setDefault($default);
				
			}

			// create file field
			if($f["type"] == "file") {
				$label = intval((string) $f["label"]);
				$help = intval((string) $f["help"]);
				$length = intval((string) $f["length"]);
				$maxlength = intval((string) $f["maxlength"]);
				$default = intval((string) $f["default"]);

				if (isset($f->option)) {
					foreach ($f->option as $o) {
						$options[] = intval((string) $o);
					}
				}

				$fields[$id] = new FileField($id, $name, $label, $length, $maxlength, $help);
				$fields[$id]->setDefault($default);
			}

			// create submit field
			if($f["type"] == "submit") {
				$label = intval((string) $f["label"]);
				$fields[$id] = new SubmitField($id, $name, $label, $length, $help, $options);
			}

			// create reset field
			if($f["type"] == "reset") {
				$label = intval((string) $f["label"]);
				$fields[$id] = new ResetField($id, $name, $label, $length, $help, $options);
			}

			//TODO: Add XML process logic for further fields


			//Set regexp and requested values
			if($fields[$id] != null) {
				$fields[$id]->setRegexp($regexp);
				if($requested=="yes") {
					$fields[$id]->setRequested(true);
				} else {
					$fields[$id]->setRequested(false);
				}
			}

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
