<?php
    
    /**
    * class BannersGateway
    * table data gateway
    *
    */
    class BannersGateway {

        /**
        * allows to select all banners of the user using user id
        *
        * @param int $userId      - user id 
        * @param string $order    - the order in which banners will be sorted
        * @param object $pdo      - current connection to the database
        * @return object $banners - the object that contains the list of banners of current user
        */
        public function selectAll($usrId, $order, $pdo) {
            if ( !isset($order)) {
                $order = "name";
            }

            $dbOrder =  mysql_real_escape_string($order);
            $sql = "SELECT banners.banner_id, banners.name, banners.width, banners.height, banners.display, banners.banner_body, urls.page_address 
                    FROM banners
                        JOIN banner_author ON banner_author.id_ban = banners.banner_id
                        JOIN users ON users.user_id = banner_author.id_author
                        JOIN banner_url ON banner_url.id_banner = banners.banner_id
                        JOIN urls ON urls.url_id = banner_url.id_url
                    WHERE users.user_id = ?
                    ORDER BY ? ASC";

            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($usrId, $dbOrder));
            } catch (PDOException $e) {
                echo 'select all failed. '. $e->getMessage();
            }
            
            $banners = array();

            while ( ($obj = $q->fetch(PDO::FETCH_OBJ)) != NULL) {
                $banners[] = $obj;
            }

            return $banners;
        }

        /**
        * allows to select one banner of the user using banner id
        *
        * @param int $id     - banner id
        * @param object $pdo - current connection to the database
        * @return object $q  - the object that contains params of the banner using its id
        */
        public function selectById($id, $pdo) {
            $dbId = mysql_real_escape_string($id);
            $sql = "SELECT banners.banner_id, banners.name, banners.width, banners.height, banners.display, banners.banner_body, urls.page_address
                    FROM banners
                        JOIN banner_url ON banner_url.id_banner = banners.banner_id
                        JOIN urls ON urls.url_id = banner_url.id_url
                    WHERE banners.banner_id = ?";

            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($dbId));
            } catch (PDOException $e) {
                echo 'select by id failed. ' . $e->getMessage();
            }

            return $q->fetch(PDO::FETCH_OBJ);		
        }

        /**
        * allows to insert a new banner
        *
        * @param string $name    - banner name
        * @param int $width      - banner width
        * @param int $height     - banner height
        * @param string $display - banner display (none | block)
        * @param string $body    - banner html code
        * @param string $pdo     - current connection to the database
        *
        * @return int $lastInsertId - id of the last inserted banner
        */
        public function insert($name, $width, $height, $display, $body, $pdo) {           
            $dbName    = ($name != NULL)    ? mysql_real_escape_string($name)    : 'NULL';
            $dbWidth   = ($width != NULL)   ? mysql_real_escape_string($width)   : 'NULL';
            $dbHeight  = ($height != NULL)  ? mysql_real_escape_string($height)  : 'NULL';
            $dbDisplay = ($display != NULL) ? mysql_real_escape_string($display) : 'NULL';
            $dbBody    = ($body != NULL)    ? mysql_real_escape_string($body)    : 'NULL';
            
            $sql = "INSERT INTO banners (name, width, height, display, banner_body) VALUES (?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($dbName, $dbWidth, $dbHeight, $dbDisplay, $dbBody));
            } catch (PDOException $e) {
                echo 'insert failed. '.$e->getMessage();
            }

            return $pdo->lastInsertId();
        }

        /**
        * allows to insert a new banner author
        *
        * @param int $usrId    - user id
        * @param int $bannerId - banner id
        * @param object pdo    - current connection to the database   
        */
        public function insertBannerAuthor($usrId, $bannerId, $pdo) {
            $dbUserId   = ($usrId != NULL)    ? mysql_real_escape_string($usrId)    : 'NULL';
            $dbBannerId = ($bannerId != NULL) ? mysql_real_escape_string($bannerId) : 'NULL';

            $sql = "INSERT INTO banner_author (id_ban, id_author) VALUES (?, ?)";
            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($dbBannerId, $dbUserId));
            } catch (PDOException $e) {
                echo 'insert banner author failed. '.$e->getMessage();
            }

            return;
        }

        /**
        * allows to insert a new banner url
        *
        * @param int $urlId    - url id
        * @param int $bannerId - banner id
        * @param object pdo    - current connection to the database   
        */
        public function insertBannerUrl($urlId, $bannerId, $pdo) {
            $dbUrlId    = ($urlId != NULL)    ? mysql_real_escape_string($urlId)    : 'NULL';
            $dbBannerId = ($bannerId != NULL) ? mysql_real_escape_string($bannerId) : 'NULL';

            $sql = "INSERT INTO banner_url (id_url, id_banner) VALUES (?, ?)";
            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($dbUrlId, $dbBannerId));
            } catch (PDOException $e) {
                echo 'insert banner url failed. '.$e->getMessage();
            }

            return;
        }

        /**
        * allows to get an url id using page name
        *
        * @param string $page - page name
        * @param object $pdo  - current connection to the database
        *
        * @return int $row[0] - id of url using banner page name
        */
        public function getIdByPageName($page, $pdo) {
            $sql = "SELECT url_id FROM urls WHERE page_address = ?";
            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($page));
                $row = $q->fetch(PDO::FETCH_NUM);
            } catch (PDOException $e) {
                echo 'get id by page name failed. '.$e->getMessage();
            }

            return $row[0];
        }
        
        /**
        * allows to update the banner which have been already created
        *
        * @param int $id         - banner id
        * @param string $name    - banner name
        * @param int $width      - banner width
        * @param int $height     - banner height
        * @param string $display - banner display (none | block)
        * @param string $body    - banner html code
        * @param string $pdo     - current connection to the database
        */
        public function update($id, $name, $width, $height, $display, $body, $pdo) {
            $dbId = mysql_real_escape_string($id);
            
            $dbName    = ($name != NULL)    ? mysql_real_escape_string($name)    : 'NULL';
            $dbWidth   = ($width != NULL)   ? mysql_real_escape_string($width)   : 'NULL';
            $dbHeight  = ($height != NULL)  ? mysql_real_escape_string($height)  : 'NULL';
            $dbDisplay = ($display != NULL) ? mysql_real_escape_string($display) : 'NULL';
            $dbBody    = ($body != NULL)    ? stripslashes($body)                : 'NULL';
            
            $sql = "UPDATE banners SET name = ?, width = ?, height = ?, display = ?, banner_body = ? WHERE banner_id = ?";
            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($dbName, $dbWidth, $dbHeight, $dbDisplay, $dbBody, $dbId));
            } catch (PDOException $e) {
                echo 'update banners table failed. '.$e->getMessage();
            }

            return;
        }

        /**
        * allows to update the banner url using url id
        *
        * @param int $bannerId - banner id 
        * @param int $urlId    - url id
        * @param object $pdo   - current connection to the database
        */
        public function updateUrls($bannerId, $urlId, $pdo) {
            $dbBanId = mysql_real_escape_string($bannerId);
            $dbUrlId = mysql_real_escape_string($urlId);
            
            $sql = "UPDATE banner_url SET id_url = ? WHERE id_banner = ?";
            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($dbUrlId, $dbBanId));
            } catch (PDOException $e) {
                echo 'update banner url table failed. '.$e->getMessage();
            }

            return;
        }
        
        /**
        * allows to delete the banner using its id
        *
        * @param int $id     - banner id 
        * @param object $pdo - current connection to the database 
        */
        public function delete($id, $pdo) {
            $dbId = mysql_real_escape_string($id);
            $sql1 = "DELETE FROM banners WHERE banner_id = ?";
            $sql2 = "DELETE FROM banner_author WHERE id_ban = ?";
            $sql3 = "DELETE FROM banner_url WHERE id_banner = ?";

            $q1 = $pdo->prepare($sql1);
            $q2 = $pdo->prepare($sql2);
            $q3 = $pdo->prepare($sql3);
            try {
                $q1->execute(array($id));
                $q2->execute(array($id));
                $q3->execute(array($id));
            } catch (PDOException $e) {
                echo 'delete failed. '.$e->getMessage();
            }
        }  

        /**
        * allows to check if all required arguments that have been provided are match auth params
        *
        * @param string $login    - user login
        * @param string $password - user password
        * @param object $pdo      - current connection to the database  
        * 
        * @return true in positive case else return false
        */
        public function getUserData($login, $password, $pdo) {
            //$dbId = mysql_real_escape_string($id);
            $sql = "SELECT * FROM users WHERE login = ? AND password = ?;";
            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($login, $password));
                $numRows = $q->rowCount();
            } catch (PDOException $e) {
                echo 'check user auth failed. '.$e->getMessage();
            }
            //return $q->fetch(PDO::FETCH_OBJ);
            return ($numRows > 0) ? TRUE : FALSE;
        } 

        //------------------------------------------------------- iframe ------------------------------------------------------------------------
        /**
        * allows to get the params of the iframe using user id and page addres in which the banner will be shown
        *
        * @param int $userId - user id
        * @param int $page   - page address in which the banner will be shown
        * @param int $pdo    - current connection to the database
        *
        * @return array $jsonData - data array that contains all the params of the iframe
        */
        public function getIframe($userId, $page, $pdo) {
            $sql = "SELECT banners.banner_id, banners.width, banners.height, banners.display  
                    FROM banners
                        JOIN banner_url ON banner_url.id_banner = banners.banner_id
                        JOIN urls ON urls.url_id = banner_url.id_url
                        JOIN banner_author ON banner_author.id_ban = banners.banner_id 
                        JOIN users ON users.user_id = banner_author.id_author
                    WHERE users.user_id = ? AND urls.page_address = ? AND banners.display = 'block'";

            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($userId, $page));
            } catch (PDOException $e) {
                echo 'get iframe data failed. '.$e->getMessage();
            }

            $bannerId = $this->getRandomBanner($q);
            //TODO: create a new sql function 
            $sql = "SELECT banners.banner_id, banners.width, banners.height, banners.display  
                    FROM banners
                        JOIN banner_author ON banner_author.id_ban = banners.banner_id 
                        JOIN users ON users.user_id = banner_author.id_author
                    WHERE users.user_id = '$userId' AND banners.banner_id = '$bannerId'";
            $q = $pdo->prepare($sql);
            try {
                $q = $pdo->query($sql);
                $row = $q->fetch(PDO::FETCH_NUM);
            } catch (PDOException $e) {
                echo 'get iframe params failed. '.$e->getMessage();
            }

            $jsonData = array();
            $jsonData['banner_id'] = $row[0];
            $jsonData['width']     = $row[1];
            $jsonData['height']    = $row[2];
            $jsonData['display']   = $row[3];

            return $jsonData;
        } 

        /**
        * allows to get a random banner in case of selected banners are more than one
        *
        * @param $query - sql query 
        *
        * @return  int $bannerId - banner id
        */
        public function getRandomBanner($query) {
            $numRows = $query->rowCount();
            if($numRows > 1) {
                $rand_banner = array();
                $i = 1;
                while ($row = $query->fetch(PDO::FETCH_NUM)) {
                    $rand_banner[$i++] = $row[0];
                } 
                $bannerId = $rand_banner[array_rand($rand_banner)];
            } elseif($numRows < 1) {
                return;
            } else {
                $row = $query->fetch(PDO::FETCH_NUM);
                $bannerId = $row[0];
            }

            return $bannerId;
        }

        /**
        * allows to get an html code of banner body using banner id
        *
        * @param int $id  - banner id
        * @param int $pdo - current connection to the database
        *
        * @return string $row[0] - html code of selected banner
        */
        public function getBannerBody($id, $pdo) {
            $sql = "SELECT banner_body FROM banners WHERE banner_id = ?";
            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($id));
                $row = $q->fetch(PDO::FETCH_NUM);
            } catch (PDOException $e) {
                echo 'get banner body failed. '.$e->getMessage();
            }

            return $row[0];
        }

        /**
        * allows to get a user id using its login
        *
        * @param string $login - user login
        * @param object $pdo   - current connection to the database
        * 
        * @return int $row[0] - user id
        */
        public function getUsrIdByLogin($login, $pdo) {
            $sql = "SELECT user_id FROM users WHERE login = ?";
            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($login));
                $row = $q->fetch(PDO::FETCH_NUM);
            } catch (PDOException $e) {
                echo 'get banner body failed. '.$e->getMessage();
            }

            return $row[0];
        } 

        /**
        * allows to get names of all banners using author id
        *
        * @param int $UsrId    - user login
        * @param object $pdo   - current connection to the database
        * 
        * @return array $row - names of banners
        */
        public function getAllNamesOfBanners($usrId, $pdo) {
            $sql = "SELECT name FROM banners
                        JOIN banner_author ON banner_author.id_ban = banners.banner_id
                    WHERE banner_author.id_author = ?";
            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($usrId));
                $row = $q->fetchAll(PDO::FETCH_COLUMN, 0);
            } catch (PDOException $e) {
                echo 'get banner body failed. '.$e->getMessage();
            }

            return $row;
        }

        /**
        * allows to get an id of banner using banner name
        *
        * @param string $bannerName - banner name
        * @param object $pdo   - current connection to the database
        * 
        * @return int $row[0] - banner id
        */
        public function getBannerId($bannerName, $pdo) {
            $sql = "SELECT banner_id FROM banners
                    WHERE name = ?";
            $q = $pdo->prepare($sql);
            try {
                $q->execute(array($bannerName));
                $row = $q->fetch(PDO::FETCH_NUM);
            } catch (PDOException $e) {
                echo 'get banner body failed. '.$e->getMessage();
            }

            return $row[0];
        }
    }
?>
