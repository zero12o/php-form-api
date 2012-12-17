<?php
	try {

		include_once("FormAPI/import.php");
		
		$formapi = FormAPIFactory::getInstance()->create("sample.xml", "upform.php", null);

		//$w = $formapi->toString();
		//echo $w;

	    	$w = $formapi->generate("en", 0, "vertical");
	    	echo $w;

	} catch (Exception $e) {
	    echo 'Caught exception: ',  $e->getMessage(), "\n";
	}



?>
