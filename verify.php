<?php
session_start();
if (isset($_SESSION['user'])&& !empty($_SESSION['user'])) {
  session_regenerate_id(); 
}else{
  header("Location: index.php");
}

require_once ('core/config.inc.php'); 
$conn = DB(); 
require_once ('core/class.inc.php');
$app = new Connect; 


if ($_SERVER["REQUEST_METHOD"] == "POST") { 
  //ID
  if (isset($_POST["id"]) && !empty($_POST["id"])) { 
    $id = \test_input(filter_input(INPUT_POST, "id", \FILTER_SANITIZE_NUMBER_INT));
  } 

  //NAME 
  if (isset($_POST["name"]) && !empty($_POST["name"])) { 
    $name = \test_input(filter_input(\INPUT_POST, "name", \FILTER_SANITIZE_STRING)); 
  } else {
    $nameErr = "Please enter a name";
  } 

  //EMAIL
  if (isset($_POST["email"]) && !empty($_POST["email"])) { 
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $email = test_input(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)); 
  } else {
    $emailErr = "Please enter an Email";
  } 

  //Bank
    if (isset($_POST["bank"]) && !empty($_POST["bank"])) { 
        $bank = test_input(filter_input(\INPUT_POST, "bank", \FILTER_SANITIZE_STRING));
        if ($bank == "-- Select One --") {
          $bankErr = "Kindly select a bank";
        }
    } else {
        $bankErr = "No bank selected";
    } 

    //Amount
    if (isset($_POST["amount"]) && !empty($_POST["amount"])) {
      $amount = \test_input(filter_input(INPUT_POST, "amount", \FILTER_SANITIZE_NUMBER_INT)); 
      if (!is_numeric($amount)) { 
        $amountErr = "Only numbers allowed"; 
      }elseif (!preg_match('/^\d+$/', $amount)) {
        $amountErr = "Amount must be whole number"; 
      }
    } else {
      $amountErr = "Please enter an amount";
    }


  //AccountNumber
  if (isset($_POST["accountnumber"]) && !empty($_POST["accountnumber"])) {
    $accountnumber = \test_input(filter_input(INPUT_POST, "accountnumber", \FILTER_SANITIZE_NUMBER_INT)); 
    if (!preg_match('/^[0-9]{10}$/', $accountnumber)) {
      $accountnumberErr = "Account number should have only NUMBERS and must be <= 10!"; 
    }
  } else {
    $accountnumberErr = "Please enter an account number";
  } 

  if (empty($nameErr) && empty($emailErr) && empty($bankErr) && empty($amountErr) && empty($accountnumberErr)) {  
  $outcome = $app->CheckAccount($accountnumber, $app->getBankCode($bank));
    if ($outcome) {   
      $update = "UPDATE ps_employee SET 
      `name` = :name, 
      `email` = :email, 
      `salary` = :amount, 
      `account_number` = :accountnumber,
      `bank` = :bank
      WHERE `id` = :id "; 
      $query =  $conn->prepare($update);
      $query->bindParam(":id", $id, \PDO::PARAM_INT); 
      $query->bindParam(":name", $name, \PDO::PARAM_STR);
      $query->bindParam(":email", $email, \PDO::PARAM_STR);
      $query->bindParam(":amount", $amount, \PDO::PARAM_STR);
      $query->bindParam(":accountnumber", $accountnumber, \PDO::PARAM_INT);
      $query->bindParam(":bank", $bank, \PDO::PARAM_STR);
      $query->execute(); 
        if($query->rowCount() > 0){ 
          $_SESSION['payment'] = "Vendor " . $name . " has been updated successfully."; 
          header("Location: admin.php");
        }else{
          $_SESSION['failure'] = "Error: No User found";
          header("Location: admin.php");
        }
    }else{
      $_SESSION['failure'] = "Account details is incorrect. Update and try again.";
      header("Location: admin.php");
    }
  }
  else {
    $_SESSION['failure']= 'Error encountered. Kindly treat all errors before submitting';
    header("Location: admin.php");
  }

// END post check
}

?>