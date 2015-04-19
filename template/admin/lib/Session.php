<?php 
    
    /**
    * class Session
    * provides all of the operations with user data while the session
    *
    */
    class Session {

        /**
        * allows to start a new session
        *
        */
        public static function start() {
            @session_start();
        }

        /**
        * allows to destroy a current session
        *
        */
        public static function destroy() {
            session_destroy();
        }

        /**
        * allows to check the active user 
        *
        * @return true in positive case else return false
        */
        public static function isActive() {
            return isset($_SESSION['login']) ? TRUE : FALSE;
        }

        /**
        * allows to set a user login and password to the session valiables
        *
        */
        public static function set($login, $password) {
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
        }

        /**
        * allows to get a login and password of logged user using session variables
        *
        * @return array of user data that contains a login and password
        */
        public static function get() {
            if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
                $login = $_SESSION['login'];
                $password = $_SESSION['password'];
                return array($login, $password);
            }
        }
    }
?>
