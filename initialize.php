<?php
session_start();
if (isset($_SESSION['user'])&& !empty($_SESSION['user'])) {
  session_regenerate_id(); 
}else{
  header("Location: index.php");
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = strip_tags($data);
  return $data;
}

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

  //AccountNAME 
  if (isset($_POST["accountname"]) && !empty($_POST["accountname"])) { 
    $accountname = \test_input(filter_input(\INPUT_POST, "accountname", \FILTER_SANITIZE_STRING)); 
  } else {
    $accountnameErr = "Please enter an account name";
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
    if (!preg_match('/^\d+$/', $amount)) {
      $amountErr = "Amount must be whole number and in Kobo"; 
    }
  } else {
    $amountErr = "Please enter an amount";
  }

  if (empty($nameErr) && empty($emailErr) && empty($bankErr) && empty($accountnameErr) && empty($amountErr) && empty($accountnumberErr)) {
    $curl = curl_init();
    $callback_url = 'callback.php';  

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode([
    'amount'=>$amount,
    'email'=>$email,
    'callback_url' => $callback_url
    ]),
    CURLOPT_HTTPHEADER => [
    "authorization: Bearer sk_test_9e66427c528098ca9e91fe3d109a083f6aaf619e", 
    "content-type: application/json",
    "cache-control: no-cache"
    ],
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    if($err){
    // there was an error contacting the Paystack API
    die('Curl returned error: ' . $err);
    }

    $tranx = json_decode($response, true); 

    if(!$tranx['status']){
    // there was an error from the API
    print_r('Error: ' . $tranx['message']);
    }

    // comment out this line if you want to redirect the user to the payment page
    // print_r($tranx);
    // redirect to page so User can pay
    // uncomment this line to allow the user redirect to the payment page
    header('Location: ' . $tranx['data']['authorization_url']);


// =============================----------------------------======================
    // $result = array();
    // //Set other parameters as keys in the $postdata array
    // $postdata =  array('email' => $email, 'amount' => $amount,"reference" => '7PVGX8MEk85tgeEpVDtD', "callback_url" => 'callback.php');
    // $url = "https://api.paystack.co/transaction/initialize";

    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL,$url);
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));  //Post Fields
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // $headers = [
    //   'Authorization: Bearer sk_test_9e66427c528098ca9e91fe3d109a083f6aaf619e',
    //   'Content-Type: application/json',

    // ];
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // $request = curl_exec ($ch);

    // curl_close ($ch);

    // if ($request) { 
    //   $result = json_decode($request, true);
    //   print_r($result);
    // }


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