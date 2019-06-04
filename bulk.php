<?php
session_start();
if (isset($_SESSION['user'])&& !empty($_SESSION['user'])) {
	$user = $_SESSION['user']; 
	session_regenerate_id(); 
}else{
	header("Location: index.php");
}

require_once ('core/config.inc.php');
$conn = DB();
require_once ('core/class.inc.php');
$app = new Connect;
$requests = $app->get_employees(); 
// $BulkReceiverCode = array();
$transfer = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
	//Description
  if (isset($_POST["description"]) && !empty($_POST["description"])) { 
    $description = \test_input(filter_input(\INPUT_POST, "description", \FILTER_SANITIZE_STRING)); 
  } else {
    $descriptionErr = "Please enter a name";
  }
  
  foreach ($requests as $request) {
  	$transfer [] = array("amount"=>$request->salary, 
  						"recipient"=> $app->getReceiver($request->name, $description, $request->account_number, $app->getBankCode($request->bank)));
  }

  $complete = $app->BulkTransfer($transfer);

  print_r($transfer);
  //End POST request
}
?>																