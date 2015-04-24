<?php

    require_once 'model/BannersGateway.php';
    require_once 'model/ValidationException.php';

    /**
    * class BannersService
    * provides the connection between BannersService and BannersGateway
    *
    */
    class BannersService {
        
        private $bannersGateway     = NULL;

        private static $cont        = NULL;
        private static $db_name     = "banner";
        private static $db_host     = "localhost";
        private static $db_username = "root";
        private static $db_user_pwd = '';

        /**
        * allows to create a new connection to a database
        * 
        * @return object $cont - current connection
        */
        private function openDb() {
            if (NULL == self::$cont) {     
            try {
              self::$cont =  new PDO("mysql:host=".self::$db_host.";"."dbname=".self::$db_name, self::$db_username, self::$db_user_pwd); 
            }
            catch(PDOException $e) {
              die($e->getMessage()); 
            }
           }
           return self::$cont;
        }
        
        /**
        * allows to close current connection
        *
        */
        private function closeDb() {
            self::$cont = NULL;
        }
        
        /**
        * allows to create an instance of BannersGateway class
        *
        */
        public function __construct() {
            $this->bannersGateway = new BannersGateway();
        }
        
        /**
        * returns the list of banners of current user
        *
        * @param string $order - value that helps the user to sort the list of banners in order
        * @return $res         - result of sql query 
        */
        public function getAllBanners($order) {
            try {
                $conn = $this->openDb();
                $login = $this->bannersGateway->getUsrIdByLogin(Session::get()[0], $conn);
                $res = $this->bannersGateway->selectAll($login, $order, $conn);
                $conn = $this->closeDb();
                return $res;
            } catch (Exception $e) {
                $conn = $this->closeDb();
                throw $e;
            }
        }
        
        /**
        * returns the banner by its id in database
        *
        * @param int $id - idenetefication number of the banner in database
        * @return $res   - result of sql query
        */
        public function getBanner($id) {
            try {
                $conn = $this->openDb();
                $res = $this->bannersGateway->selectById($id, $conn);
                $conn = $this->closeDb();
                return $res;
            } catch (Exception $e) {
                $conn = $this->closeDb();
                throw $e;
            }
            //return $this->bannersGateway->find($id);
        }
        
        /**
        * allows to check if all required arguments have been provided
        *
        * @param string $name   - banner name
        * @param int $width     - banner width
        * @param int $height    - banner height
        * @param string display - banner display (none | block)
        * @param string $body   - banner html code
        * @param string $page   - page in which the banner must be shown
        *
        * @throws new validation exception
        */
        private function validateBannerParams($name, $width, $height, $display, $body, $page) {
            $errors = array();
            if (!isset($name) || empty($name)) {
                $errors[] = 'Name is required';
                //TODO: exception handler
            }
            if (empty($errors)) {
                return;
            }
            throw new ValidationException($errors);
        }

        /**
        * allows to create a new banner
        *
        * @param string $name    - banner name
        * @param int $width      - banner width
        * @param int $height     - banner height
        * @param string $display - banner display (none | block)
        * @param string $body    - banner html code
        * @param string $page    - page in which the banner must be shown
        *
        * @return int $lastBannerId - id of the last inserted banner
        */
        public function createNewBanner($name, $width, $height, $display, $body, $page) {
            try {
                $conn = $this->openDb();
                $this->validateBannerParams($name, $width, $height, $display, $body, $page);
                $lastBannerId = $this->bannersGateway->insert($name, $width, $height, $display, $body, $conn);
                //---------------------------------------------------------------------------------------------------
                $login = $this->bannersGateway->getUsrIdByLogin(Session::get()[0], $conn);
                $this->bannersGateway->insertBannerAuthor($login, $lastBannerId, $conn);
                $urlId = $this->bannersGateway->getIdByPageName($page, $conn);

                $this->bannersGateway->insertBannerUrl($urlId, $lastBannerId, $conn);

                $conn = $this->closeDb();
                return $lastBannerId;
            } catch (Exception $e) {
                $conn = $this->closeDb();
                throw $e;
            }
        }

        /**
        * allows to update the banner which have been already created
        *
        * @param int $id        - banner id
        * @param string $name   - banner name
        * @param int $width     - banner width
        * @param int $height    - banner height
        * @param string display - banner display (none | block)
        * @param string $body   - banner html code
        * @param string $page   - page in which the banner must be shown
        *
        * @return $res - result of sql query
        */
        public function updateBanner($id, $name, $width, $height, $display, $body, $page) {
            try {
                $conn = $this->openDb();
                $this->validateBannerParams($name, $width, $height, $display, $body, $page);
                $res = $this->bannersGateway->update($id, $name, $width, $height, $display, $body, $conn);
                //-----------------------------------------------------------------------------------------------------
                $urlId = $this->bannersGateway->getIdByPageName($page, $conn);
                $this->bannersGateway->updateUrls($id, $urlId, $conn);

                $conn = $this->closeDb();
                return $res;
            } catch (Exception $e) {
                $conn = $this->closeDb();
                throw $e;
            }
        }
        
        /**
        * allows to delete the banner which have been already created
        *
        * @param int $id - banner id
        *
        * @return $res - result of sql query
        */
        public function deleteBanner($id) {
            try {
                $conn = $this->openDb();
                $res = $this->bannersGateway->delete($id, $conn);
                $conn = $this->closeDb();
            } catch (Exception $e) {
                $conn = $this->closeDb();
                throw $e;
            }
        }
        
        /**
        * allows to check if all required arguments that have been provided are match the auth params
        *
        * @param string $login    - user login
        * @param string $password - user password
        *
        * @return $res - result of sql query
        */
        public function getUserAuth($login, $password) {
            try {
                $conn = $this->openDb();
                $res = $this->bannersGateway->getUserData($login, $password, $conn);
                $conn = $this->closeDb();
                return $res;
            } catch (Exception $e) {
                $conn = $this->closeDb();
                throw $e;
            }
        }
        
        /**
        * allows getting the params of the iframe
        *
        * @param int $id      - user id
        * @param string $page - page in which the banner must be shown
        *
        * @return $res - result of sql query
        */
        public function getIframeParams($id, $page) {
            try {
                $conn = $this->openDb();
                $res = $this->bannersGateway->getIframe($id, $page, $conn);
                $conn = $this->closeDb();
                return $res;
            } catch (Exception $e) {
                $conn = $this->closeDb();
                throw $e;
            }
        }

        /**
        * allows showing the banner on page
        *
        * @param int $bannerId - banner id in database
        *
        * @return $res - result of sql query
        */
        public function showBannerBody($bannerId) {
            try {
                $conn = $this->openDb();
                $res = $this->bannersGateway->getBannerBody($bannerId, $conn);
                $conn = $this->closeDb();
                return $res;
            } catch (Exception $e) {
                $conn = $this->closeDb();
                throw $e;
            }
        }

        /**
        * allows getting the user id by login
        *
        * @param string $login - user login
        *
        * @return $res - result of sql query
        */
        public function getUserId($login) {
            try {
                $conn = $this->openDb();
                $res = $this->bannersGateway->getUsrIdByLogin($login, $conn);
                $conn = $this->closeDb();
                return $res;
            } catch (Exception $e) {
                $conn = $this->closeDb();
                throw $e;
            }
        }

        /**
        * allows getting all names of banners by user id
        *
        * @param int $usrId - user id
        *
        * @return $res - result of sql query
        */
        public function getAllNames($usrId) {
            try {
                $conn = $this->openDb();
                $res = $this->bannersGateway->getAllNamesOfBanners($usrId, $conn);
                $conn = $this->closeDb();
                return $res;
            } catch (Exception $e) {
                $conn = $this->closeDb();
                throw $e;
            }
        }

        /**
        * allows getting the user id by login
        *
        * @param string $name - banner name
        *
        * @return $res - result of sql query
        */
        public function getBannerIdByName($name) {
            try {
                $conn = $this->openDb();
                $res = $this->bannersGateway->getBannerId($name, $conn);
                $conn = $this->closeDb();
                return $res;
            } catch (Exception $e) {
                $conn = $this->closeDb();
                throw $e;
            }
        }
    }
?>
