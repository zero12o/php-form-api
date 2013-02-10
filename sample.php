<?php
/**
 * User defined callback function if field validation fails.
 *
 * @param Field $f field object with invalid content
 */
	function request_error_callback($f) {
		echo "Invalid value: " . $f->getName();
	}

	include_once("FormAPI/import.php");

	$model = new EchoModel();
	$formapi = FormAPIFactory::getInstance()->create("sample.xml", $_SERVER['PHP_SELF'], $model);

	// TODO improve condition more specific to form
	if (is_array($_REQUEST) && count($_REQUEST) > 2) {
		$formapi->setInvalidRequestHandler("request_error_callback");
		// response for submit
		$w = $formapi->request($_REQUEST);
		echo $w;
	} else {
		// generate form
		$w = $formapi->generate("en", 0);
		echo $w;
	}

?>
