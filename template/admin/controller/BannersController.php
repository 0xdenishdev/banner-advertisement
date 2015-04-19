<?php

    require_once 'model/BannersService.php';

    /**
    * class BannersController
    * provides the connection between the controller and BannersService
    *
    */
    class BannersController {
        
        private $bannersService = NULL;
        
        /**
        * allows to create an instance of BannersService class
        *
        */
        public function __construct() {
            $this->bannersService = new BannersService();
        }
        
        /**
        * sends a raw http header to a client
        *
        * @param string $location - location to redirect
        */
        public function redirect($location) {
            header('Location: ' . $location);
        }
        
        /**
        * determines the params of the request that have been sent
        *
        */
        public function requestHandler() {
            $op = isset($_GET['op']) ? $_GET['op'] : NULL;
            try {
                if (!$op) $this->listOfBanners();
                else {
                    switch ($op) {
                        case "list":
                            $this->listOfBanners();
                            break;
                        case "new":
                            $this->saveBanner();
                            break;
                        case "delete":
                            $this->deleteBanner();
                            break;
                        case "update":
                            $this->updateBanner();
                            break;
                        case "show":
                            $this->showItem(); 
                            break;
                        case "signout":
                            $this->signout();
                            break;
                        case "getBanner":
                            $this->getIframe();
                            break;
                        case "showBanner":
                            $this->showBanner();
                            break;
                        default:
                            $this->showError("Page not found", "Page for operation " . $op . " was not found!");
                            break;
                    }
                }
            } catch (Exception $e) {
                $this->showError("Application error", $e->getMessage());
            }
        }
        
        /**
        * determines the page with list of banners of current user
        *
        */
        public function listOfBanners() {
            $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : NULL;
            $banners = $this->bannersService->getAllBanners($orderby);
            include 'view/banners.php';
        }

        /**
        * determines the page that allows the user to create a new banner and save it into the database
        *
        */
        public function saveBanner() {
           
            $title = "Add New Banner | Web Templates | Template Monster";
            
            $name    = '';
            $width   = '';
            $height  = '';
            $display = '';
            $bnrBody = '';
            $page    = '';
           
            $errors = array();
            
            if (isset($_POST['form-submitted'])) {
                
                $name    = isset($_POST['name'])    ? $_POST['name']    : NULL;
                $width   = isset($_POST['width'])   ? $_POST['width']   : NULL;
                $height  = isset($_POST['height'])  ? $_POST['height']  : NULL;
                $display = isset($_POST['display']) ? $_POST['display'] : NULL;
                $bnrBody = isset($_POST['bnrBody']) ? $_POST['bnrBody'] : NULL;
                $page    = isset($_POST['page'])    ? $_POST['page']    : NULL;
                
                try {
                    $this->bannersService->createNewBanner($name, $width, $height, $display, $bnrBody, $page);
                    $this->redirect('index.php');
                    return;
                } catch (ValidationException $e) {
                    $errors = $e->getErrors();
                }
            }
            
            include 'view/banner-form.php';
        }

        /**
        * determines the page that allows the user to update the banner which have already been created
        *
        */
        public function updateBanner() {
            $id = isset($_GET['id']) ? $_GET['id'] : NULL;
            if (!$id) {
                throw new Exception('Internal error.');
            }
            $banner = $this->bannersService->getBanner($id);

            $name    = $banner->name;
            $width   = $banner->width;
            $height  = $banner->height;
            $display = $banner->display;
            $body    = $banner->banner_body;
            $page    = $banner->page_address;
           
            $errors = array();

            if (isset($_POST['update-form-submitted'])) {
                
                $name    = isset($_POST['name'])    ? $_POST['name']    : NULL;
                $width   = isset($_POST['width'])   ? $_POST['width']   : NULL;
                $height  = isset($_POST['height'])  ? $_POST['height']  : NULL;
                $display = isset($_POST['display']) ? $_POST['display'] : NULL;
                $body    = isset($_POST['body'])    ? $_POST['body']    : NULL;
                $page    = isset($_POST['page'])    ? $_POST['page']    : NULL;

                try {
                    $this->bannersService->updateBanner($id, $name, $width, $height, $display, $body, $page);
                    $this->redirect('index.php');
                    return;
                } catch (ValidationException $e) {
                    $errors = $e->getErrors();
                }
            }

            include 'view/banner-edit.php';
        }
        
        /**
        * allows the user to delete the banner which have been already created
        *
        */
        public function deleteBanner() {
            $id = isset($_GET['id']) ? $_GET['id'] : NULL;
            if (!$id) {
                throw new Exception('Internal error.');
            }
            
            $this->bannersService->deleteBanner($id);
            
            $this->redirect('index.php');
        }

        /**
        * allows the user to get one item from the list of banners
        *
        */
        public function showItem() {
            $id = isset($_GET['id']) ? $_GET['id'] : NULL;
            if (!$id) {
                throw new Exception('Internal error.');
            }
            $banner = $this->bannersService->getBanner($id);
            
            include 'view/banner.php';
        }
        
        /**
        * determines the page of errors in case of exception situation
        * 
        * @param string $title   - title of errors page
        * @param string $message - message that will be shown in case of exception situation
        */
        public function showError($title, $message) {
            include 'view/error.php';
        }

        /**
        * allows the user to sign out and destroy the current session
        *
        */
        public function signout() {
            session_destroy();
            $this->redirect('index.php');
        }

        /**
        * determines the params of current iframe
        *
        */
        public function getIframe() {
            $id = mysql_real_escape_string($_POST['user_id']);
            $page = mysql_real_escape_string($_POST['page']);
            $data = $this->bannersService->getIframeParams($id, $page);
            echo json_encode($data);
        }
        
        /**
        * allows the user to dispose the returned banner
        *
        */
        public function showBanner() {
            $bannerId = mysql_real_escape_string($_GET['bannerId']);
            $bannerBody = $this->bannersService->showBannerBody($bannerId);
            echo $bannerBody; 
        }
    }
?>
