<?php

    include '/lib/Session.php';
    require_once 'model/BannersService.php';

    Session::start();

    class LoginController {
      
        private $bannersService = NULL;
        
        /**
        * allows to create an instance of LoginController class
        */
        public function __construct() {
            $this->bannersService = new BannersService();
        }
        
        /**
        * allows to check if all required arguments have been provided
        *
        * @return bool $userFlag - return true in positive case else return false
        */
        public function checkUser() {
            $userData = Session::get();
            $login = $userData[0];
            $password = $userData[1];
            $userFlag = $this->bannersService->getUserAuth($login, $password);
            
            return $userFlag;
        }

        /**
        * allows to redirect to the login page   
        *
        */
        public function getAuth() {
            include '/view/login.php';
        }

        /**
        * allows to set a login and password of user in current session
        *
        */
        public function setUser($login, $password) {
            Session::set($login, $password);
        }
    }
?>
