<?php

	require_once 'controller/BannersController.php';

	$bannerController = new BannersController();
	
	/**
	* allows to invoke the request handler to get an iframe params and set the banner to chosen position
	*
	*/
	$bannerController->requestHandler();
?>
