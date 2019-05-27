<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = strip_tags($data);
  return $data;
}

class Connect {
    /*
     * Register New User
     *
     * @param $name, $email, $username, $password
     * @return ID
     * */

    public function Register($id, $name, $pass, $email, $date, $lastlog) {
        try {
            $options = [
                'cost' => 12
            ];
            $conn = DB();
            $sql = "INSERT INTO user_csir(`Id`, `Name`, `Email`, `Password`, `Date_added`, `Last_logged`) VALUES (:Id,:username,:email,:pass,:date_added,:lastlog)";
            $query = $conn->prepare($sql);          
            $query->bindParam(":Id", $id, \PDO::PARAM_INT);  
            $query->bindParam(":username", $name, \PDO::PARAM_STR);
            $password_hash = password_hash($pass, PASSWORD_BCRYPT, $options);
            $query->bindParam(":pass", $password_hash, \PDO::PARAM_STR);
            $query->bindParam(":email", $email, \PDO::PARAM_STR);
            $query->bindParam(":date_added", $date, \PDO::PARAM_STR);
            $query->bindParam(":lastlog", $lastlog, \PDO::PARAM_STR);
            $query->execute();
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            file_put_contents('log.txt', $e->getMessage(), FILE_APPEND); 
            exit($e->getMessage());
        // return "Error!: " . $e->getMessage();
        // die();
        }
    }


    /*
     * Insert download request
     ** @return id
     * */
    public function insert_download($name, $email, $date, $page, $checked) {
        try {   
            $conn = DB();
            $sql = "INSERT INTO downloadrequest_csir(`Name`, `Email`, `Date`, `Page`, `Checked`) VALUES (:name,:email,:date_added,:page,:checked)";
            $query = $conn->prepare($sql);          
            $query->bindParam(":name", $name, \PDO::PARAM_STR);
            $query->bindParam(":email", $email, \PDO::PARAM_STR);
            $query->bindParam(":date_added", $date, \PDO::PARAM_STR);
            $query->bindParam(":page", $page, \PDO::PARAM_STR);
            $query->bindParam(":checked", $checked, \PDO::PARAM_STR);
            $query->execute();
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            file_put_contents('log.txt', $e->getMessage(), FILE_APPEND); 
            exit($e->getMessage());
        // return "Error!: " . $e->getMessage();
        // die();
        }
    }


    /*
     * Insert 2017 participation request
     ** @return id
     * */
    public function participate($id, $name, $email, $phone, $describe, $date) {
        try {   
            $conn = DB();
            $sql = "INSERT INTO participatelist_csir(`Id`, `Name`, `Email`, `Number`,  `Description`, `Date_added`) VALUES 
            (:Id,:name,:email,:numb,:describe,:date_added)";
            $query = $conn->prepare($sql);       
            $query->bindParam(":Id", $id, \PDO::PARAM_INT);  
            $query->bindParam(":name", $name, \PDO::PARAM_STR);
            $query->bindParam(":email", $email, \PDO::PARAM_STR);
            $query->bindParam(":numb", $phone, \PDO::PARAM_INT);
            $query->bindParam(":describe", $describe, \PDO::PARAM_STR);
            $query->bindParam(":date_added", $date, \PDO::PARAM_STR);
            $query->execute();
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            file_put_contents('log.txt', $e->getMessage(), FILE_APPEND); 
            exit($e->getMessage());
        // return "Error!: " . $e->getMessage();
        // die();
        }
    }

    /*
     * Insert 2017 participation request
     ** @return id
     * */
    public function subscribe($id, $fname,  $lname, $email, $date) {
        try {   
            $conn = DB();
            $sql = "INSERT INTO subscribe_csir(`Id`, `First_Name`, `Last_Name`, `Email`, `Date_added`) VALUES 
            (:Id,:fname,:lname,:email,:date_added)";
            $query = $conn->prepare($sql);       
            $query->bindParam(":Id", $id, \PDO::PARAM_INT);  
            $query->bindParam(":fname", $fname, \PDO::PARAM_STR);
            $query->bindParam(":lname", $lname, \PDO::PARAM_STR);
            $query->bindParam(":email", $email, \PDO::PARAM_STR);
            $query->bindParam(":date_added", $date, \PDO::PARAM_STR);
            $query->execute();
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            file_put_contents('log.txt', $e->getMessage(), FILE_APPEND); 
            exit($e->getMessage());
        // return "Error!: " . $e->getMessage();
        // die();
        }
    }

    /*
     * Insert contact
     ** @return id
     * */
    public function contact($id, $name, $email, $subject, $message, $date) {
        try {   
            $conn = DB();
            $sql = "INSERT INTO contact_csir(`Id`, `Name`, `Email`, `Subject`, `Message`, `Date_added`) VALUES 
            (:Id,:name,:email,:subject,:message,:date_added)";
            $query = $conn->prepare($sql);       
            $query->bindParam(":Id", $id, \PDO::PARAM_INT);  
            $query->bindParam(":name", $name, \PDO::PARAM_STR);
            $query->bindParam(":email", $email, \PDO::PARAM_STR);
            $query->bindParam(":subject", $subject, \PDO::PARAM_STR);
            $query->bindParam(":message", $message, \PDO::PARAM_STR);
            $query->bindParam(":date_added", $date, \PDO::PARAM_STR);
            $query->execute();
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            file_put_contents('log.txt', $e->getMessage(), FILE_APPEND); 
            exit($e->getMessage());
        // return "Error!: " . $e->getMessage();
        // die();
        }
    }

    /*
     * Check Username
     *
     * @param $username
     * @return boolean
     * */

    public function isUsername($name) {
        try {
            $conn = DB();
            $query = $conn->prepare("SELECT `Id` FROM `user_csir` WHERE `name`=:name");
            $query->bindParam("name", $name, \PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Check Email
     *
     * @param $email
     * @return boolean
     * */

    public function isEmail($email) {
        try {
            $conn = DB();
            $query = $conn->prepare("SELECT `Id` FROM `user_csir` WHERE `email`=:email");
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Check Token
     *
     * @param $token
     * @return boolean
     * */

    public function setToken() {
        try {
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            return $token;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Check Toke
     *
     * @param $token
     * @return boolean
     * */

    public function isToken($token) {
        try {
            $conn = DB();
            $query = $conn->prepare("SELECT `user_id` FROM `csat_user` WHERE `token`=:token");
            $query->bindParam("token", $token, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Login
     *
     * @param $username, $password
     * @return all details
     * */
    public function Login($username, $password) {
      try {
        $conn = DB();
        $sql = "SELECT * FROM user_csir WHERE Name=:username";
        $query = $conn->prepare($sql);
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) 
        {
          $result = $query->fetch();
          if (password_verify($password, $result['Password'])) {
            $data = date("Y-m-d h:i:s"); 
            $update = "UPDATE user_csir
                       SET `Last_logged` =:data
                       WHERE `Id` =:user_Id"; 
            $query =  $conn->prepare($update); 
            $query->bindParam("user_Id", $result['Id'], PDO::PARAM_INT); 
            $query->bindParam("data", $data, PDO::PARAM_STR);
            $query->execute(); 
            if($query->rowCount() > 0){ 
              return $result['Id'];
            }else{
              return false;
            }
          }
        } 
        else {
          return false;
        }
      } 
      catch (Exception $e) {
        exit($e->getMessage());
      }
    }

    /*
     * get User Details
     *
     * 
     * @return $mixed
     * */

    public function get_all_requests() {
        try {
            $conn = DB();
            $query = $conn->prepare("SELECT * FROM `downloadrequest_csir` order by `Id` desc");
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_OBJ);
            }else{
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    /*
     * get all from a table
     *
     * 
     * @return $mixed
     * */

    public function select_all($tableName) {
        try {
            $conn = DB();
            $query = $conn->prepare("SELECT * FROM " . $tableName . " order by `Id` desc");
            $query->bindParam(":tableName", $tableName, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_OBJ);
            }else{
                return false;
            }   
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    /*
     * Logout template
     *
     * @return $query
     * */

    public function logout() {
        try {
            $conn = DB();
            $value = "active";
            $logout = "UPDATE `user_csir`
                       SET `status` =:value
                       WHERE `user_Id` =:user_Id"; 
            $query =  $conn->prepare($logout); 
            $query->bindParam("user_Id", $_SESSION['user_id'], PDO::PARAM_INT); 
            $query->bindParam("value", $value, PDO::PARAM_STR); 
            $query->execute(); 
            if($query->rowCount() > 0){ 
                return true;
              }
          } 
          catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function Insert($column, $field, $tableName) {
        try {
              $conn = DB();
              $dataField = array(); 
              $dataField_binding = array();
              foreach ($column as $key => $data) {
                $dataField[] = "`$data`"; 
                $dataField_binding[] = ':' . $data;
              }
              $insert = "INSERT INTO `" . $tableName . "`(" . implode(',', $dataField) . ") VALUES (" . implode(',', $dataField_binding) . ")";
              $stmt = $conn-> prepare($insert);
                $i = 0;
                $lastKey = sizeof($column);
              foreach ($field as $key => $FieldData) { 
                if ($i < $lastKey) {
                 $stmt->bindParam($dataField_binding[$i], $FieldData, PDO::PARAM_STR);
                }
                $i++;
              }
              $stmt->execute();
              return $conn->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}
?>
