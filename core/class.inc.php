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
     * Register New Employee
     *
     * @param $id, $name, $email, $accountname, $accountnumber, $bank, $date
     * @return ID
     * */

    public function Register($id, $name, $email, $accountname, $accountnumber, $bank, $date) { 
        try {
            $options = [
                'cost' => 12
            ];
            $conn = DB();
            $sql = "INSERT INTO ps_employee(`id`, `name`, `email`, `account_name`, `account_number`, `bank`, `date`) VALUES (:id,:name,:email,:accountname,:accountnumber,:bank,:date_added)"; 
            $query = $conn->prepare($sql);         
            $query->bindParam(":id", $id, \PDO::PARAM_INT);  
            $query->bindParam(":name", $name, \PDO::PARAM_STR);
            $query->bindParam(":email", $email, \PDO::PARAM_STR);
            $query->bindParam(":accountname", $accountname, \PDO::PARAM_STR);
            $query->bindParam(":accountnumber", $accountnumber, \PDO::PARAM_INT);
            $query->bindParam(":bank", $bank, \PDO::PARAM_STR);
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
     * Check account number 
     *
     * @param $accountnumber
     * @return boolean
     * */

    public function isAccountNumber($accountnumber) {
        try {
            $conn = DB();
            $query = $conn->prepare("SELECT `Id` FROM `ps_employee` WHERE `account_number`=:num");
            $query->bindParam("num", $accountnumber, \PDO::PARAM_INT);
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
            $query = $conn->prepare("SELECT `Id` FROM `ps_employee` WHERE `email`=:email");
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
     * Login
     *
     * @param $username, $password
     * @return all details
     * */
    public function Login($username, $password) {
      try {
        $conn = DB();
        $sql = "SELECT * FROM ps_user WHERE Username=:username";
        $query = $conn->prepare($sql);
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) 
        {
          $result = $query->fetch();
          if (password_verify($password, $result['Password'])) { 
              return $result['Id'];
            }else{
              return false;
            }
          
        } else {
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

    public function get_employees() {
        try {
            $conn = DB();
            $query = $conn->prepare("SELECT * FROM `ps_employee` order by `id` desc");
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
     * get User Details with ID
     *
     * 
     * @return $mixed
     * */

    public function getDetails($id) {
        try {
            $conn = DB();
            $query = $conn->prepare("SELECT * FROM `ps_employee` WHERE `id`=:id");
            $query->bindParam("id", $id, \PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_OBJ);
            } else {
                return false;
            }
        } catch (\PDOException $e) {
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
}
?>
