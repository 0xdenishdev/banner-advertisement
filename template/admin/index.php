<?php

	require_once 'controller/BannersController.php';
	require_once 'controller/LoginController.php';

	$bannerController = new BannersController();
	$loginController  = new LoginController();

	/**
	* allows to check if all required arguments have been provided
	* in positive case - get the user and redirect to the index page of banners admin panel
	* else redirect to the auth page
	*
	*/
	if (!$loginController->checkUser()) {
		$loginController->getAuth();

		if (isset($_POST['username']) && isset($_POST['password'])) {
			$login = htmlspecialchars($_POST['username']);
			$password = htmlspecialchars($_POST['password']);
			$loginController->setUser($login, $password);
		}
	} else {
		/**
		* determines GET params for handling the request
		*/
		$bannerController->requestHandler();
	}
?>
