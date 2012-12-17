<?php
	try {

		include_once("FormAPI/import.php");
		include_once("config.php");

		error_reporting(E_ALL);
		
		// Display results on client side
		$model = new EchoModel();

		// Create control object
		$formapi = FormAPIFactory::getInstance()->create("sample.xml", "upform.php", $model);

		//Handle bad request with an anonymous function
		$formapi->setInvalidRequestHandler(function($f) { echo "Invalid value: " . $f->getName(); });

		// Process request
	    	$w = $formapi->request($_REQUEST);
		
		// Print result
	    	echo $w;

	} catch (Exception $e) {
	    echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
?>
