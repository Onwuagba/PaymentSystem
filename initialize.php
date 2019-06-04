<?php
session_start();
if (isset($_SESSION['user'])&& !empty($_SESSION['user'])) {
  session_regenerate_id(); 
}else{
  header("Location: index.php");
}
require_once ('core/class.inc.php');
$app = new Connect;

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
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
  } else {
    $bankErr = "Bank info was altered. Edit the user and try paying again";
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

  //Amount
  if (isset($_POST["amount"]) && !empty($_POST["amount"])) {
    $amount = \test_input(filter_input(INPUT_POST, "amount", \FILTER_SANITIZE_NUMBER_INT)); 
    $amount = $amount * 100;
    if (!preg_match('/^\d+$/', $amount)) {
      $amountErr = "Amount must be whole number"; 
    }
  } else {
    $amountErr = "Please enter an amount";
  }

  //Description
  if (isset($_POST["description"]) && !empty($_POST["description"])) { 
    $description = \test_input(filter_input(\INPUT_POST, "description", \FILTER_SANITIZE_STRING)); 
  } else {
    $descriptionErr = "Please enter a name";
  }

  if (empty($nameErr) && empty($emailErr) && empty($bankErr) && empty($amountErr) && empty($accountnumberErr) & empty($descriptionErr)) {

    //Call ListBanks Endpoint
    $bankcode = $app->getBankCode($bank); 
    //End ListBanks Endpoint

    //Create Transfer Recipient
    $recipient_code = $app->getReceiver($name, $description, $accountnumber, $bankcode); 
    //End Transfer Recipient

    // Initiate transfer
    $initiate_transx = $app->InitateTransfer($amount, $recipient_code);
    // echo $initiate_transx;
    // End initiate transfer

    // End PayStack integration
  }
  else {
    $register_error = 'Error encountered. Kindly treat all errors before submitting';
  }

// END post check
}
else{ 
  unset($_SESSION['user']);
  session_destroy();
  header("Location: index.php");
}
?>