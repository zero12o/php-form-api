<?php

include_once("import.php");

/**
  * Control object, that generates the HTML code and handle requests from clients.
  * @see FormAPI::generate($lang, $full=1) could be used for generate the HTML code
  * of form and @see FormAPI::request($request) for handling request. This class contains
  * the view (@see FormAPI::$form) and model (@see FormAPI::$model) instances.
  *
  * @property Form $form the view object
  * @property Model $model the model object
  *
  * @package formapi
  * @author Zoltan Siki <siki@agt.bme.hu> and Zoltan Koppanyi <zoltan.koppanyi@gmail.com>
  * @version 0.1
  */
class FormAPI {

	private $form;
	private $model;
	private $invalidRequestHandler = null;


	/**
	 * Constructor for initializing view and model objects
	 *
	 * @param Form $form view object
	 * @param Form $model model object
	 */
	public function __construct($form, $model) {
		$this->form = $form;
		$this->model = $model;
	}

	/**
	 * Get invalid request handler
    	 *
	 * @return function($handler) Invalid request handler instance
	 */
	public function getInvalidRequestHandler() {
		return $this->invalidRequestHandler;
	}

	/**
	 * Set invalid request handler
    	 *
	 * @param function($handler) $handler Invalid request handler function
	 */
	public function setInvalidRequestHandler($handler) {
		$this->invalidRequestHandler = $handler;
	}

	/**
	 * Generate form of HTML code
	 *
	 * @param string $lang language code, that has been defined in XML file of form
	 * @param int $full 0/1 generate only form/generate full html page
	 * @param string $layout layout of the form  (i.e. vertical, horizontal, ...)
    	 *
	 * @return string HTML code of form 
	 */
	public function generate($lang, $full=1, $layout="vertical") {
	    	return $this->form->generate($lang, $full, $layout);
	}
	

	/**
	 * Handling client request. This function responsible for validating values sent by the form.
	 *
	 * @param <string,string> $request hashmap of the request in the following form: <field_name, value>
	 *
	 * @return string message of model object after processing data
	 */
	public function request($request) {
		foreach($this->form->getFields() as $f) {
			$name = $f->getName();
			if (isset($request[$name])) {
				if($f->check($request[$name]) == true) {
					$checked_request[$name] = $request[$name];
				} else {
					if($this->invalidRequestHandler != null) {
						call_user_func($this->invalidRequestHandler, $f);
					}
					return;
				}
			}
		}
		$response = $this->model->insert($checked_request);
		echo $response;
	}
}

?>
