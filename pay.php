<?php 
session_start();
if (isset($_SESSION['user'])&& !empty($_SESSION['user'])) {
  session_regenerate_id(); 
}else{
  unset($_SESSION['user']);
  session_destroy();
  header("Location: index.php");
}

// get id from URL
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
else{
  session_destroy();
  header("Location: index.php");
}

$login_message = '';
require_once ('core/config.inc.php'); 
$conn = DB(); 
require_once ('core/class.inc.php');
$app = new Connect;
$requests = $app->getDetails($id); 

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   //       //NAME 
//   // if (isset($_POST["name"]) && !empty($_POST["name"])) { 
//   //   $name = \test_input(filter_input(\INPUT_POST, "name", \FILTER_SANITIZE_STRING));
//   // } else {
//   //   $nameErr = "Please enter a name";
//   // }

//   //       //EMAIL
//   // if (isset($_POST["email"]) && !empty($_POST["email"])) { 
//   //   $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
//   //   $email = test_input(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL));
//   // } else {
//   //   $emailErr = "Please enter an Email";
//   // }

//   //       //Bank
//   // if (isset($_POST["bank"]) && !empty($_POST["bank"])) { 
//   //   $bank = test_input(filter_input(\INPUT_POST, "bank", \FILTER_SANITIZE_STRING));
//   // } else {
//   //   $bankErr = "No bank selected";
//   // }

//   //       //AccountNAME 
//   // if (isset($_POST["accountname"]) && !empty($_POST["accountname"])) { 
//   //   $accountname = \test_input(filter_input(\INPUT_POST, "accountname", \FILTER_SANITIZE_STRING));
//   // } else {
//   //   $accountnameErr = "Please enter an account name";
//   // }

//   //       //AccountNumber
//   // if (isset($_POST["accountnumber"]) && !empty($_POST["accountnumber"])) {
//   //   $accountnumber = \test_input(filter_input(INPUT_POST, "accountnumber", \FILTER_SANITIZE_NUMBER_INT)); 
//   //   if (!preg_match('/^[0-9]{10}$/', $accountnumber)) {
//   //     $accountnumberErr = "Account number should have only NUMBERS and must be <= 10!"; 
//   //   }
//   // } else {
//   //   $accountnumberErr = "Please enter an account number";
//   // }

//   //       //Amount
//   // if (isset($_POST["amount"]) && !empty($_POST["amount"])) {
//   //   $amount = \test_input(filter_input(INPUT_POST, "amount", \FILTER_SANITIZE_NUMBER_INT)); 
//   //   if (!preg_match('/^\d+$/', $amount)) {
//   //     $amountErr = "Amount must be whole number and in Kobo"; 
//   //   }
//   // } else {
//   //   $amountErr = "Please enter an amount";
//   // }
//   //        // $id="";    

// 	if (empty($nameErr) && empty($emailErr) && empty($bankErr) && empty($accountnameErr) && !empty($amountErr) && empty($accountnumberErr)) {  

// 		$curl = curl_init();
// 		// url to go to after payment
// 		$callback_url = 'myapp.com/pay/callback.php';  

// 		curl_setopt_array($curl, array(
// 		CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
// 		CURLOPT_RETURNTRANSFER => true,
// 		CURLOPT_CUSTOMREQUEST => "POST",
// 		CURLOPT_POSTFIELDS => json_encode([
// 		'amount'=>$amount,
// 		'email'=>$email,
// 		'callback_url' => $callback_url
// 		]),
// 		CURLOPT_HTTPHEADER => [
// 		"authorization: Bearer sk_test_9e66427c528098ca9e91fe3d109a083f6aaf619e", 
// 		"content-type: application/json",
// 		"cache-control: no-cache"
// 		],
// 		));

// 		$response = curl_exec($curl);
// 		$err = curl_error($curl);

// 		if($err){
// 		// there was an error contacting the Paystack API
// 		die('Curl returned error: ' . $err);
// 		}

// 		$tranx = json_decode($response, true);

// 		if(!$tranx->status){
// 		// there was an error from the API
// 		print_r('API returned error: ' . $tranx['message']);
// 		}

// 		// comment out this line if you want to redirect the user to the payment page
// 		print_r($tranx);
// 		// redirect to page so User can pay
// 		// uncomment this line to allow the user redirect to the payment page
// 		header('Location: ' . $tranx['data']['authorization_url']);
// 		}


// 	}
// 	else {
// 			$register_error = 'Error encountered. Kindly treat all errors before submitting';
// 	}
// }
// else{ exit("10");
// 	unset($_SESSION['user']);
// 	session_destroy();
// 	header("Location: index.php");
// }
?>

<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Payment System</title>

		<!-- Bootstrap CSS -->
  		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<style type="text/css">
			.error{
				color: red;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
					<?php if (isset($register_message)&&!empty($register_message)) {
						echo "<div class=\"alert alert-success\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
						<strong><span class=\"glyphicon glyphicon-ok\"></span> </strong> $register_message
						</div>";
					} elseif (isset($register_error)&&!empty($register_error)) {
						echo "<div class=\"alert alert-danger\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
						<strong><span class=\"glyphicon glyphicon-remove\"></span> </strong> <span>$register_error</span>
						</div>";
					}
					?>
					<div class="card card-signin my-5">
						<div class="card-body">
							<h5 class="card-title text-center">Pay Employee</h5>

							<form action="initialize.php"  method="POST" class="form-signin">
								<label for="Name">Employee Name</label>
								<div class="form-label-group">
									<input type="text" name="name" value="<?php if (isset($requests[0]->name)) {
										echo $requests[0]->name;
									} ?>" class="form-control" required readonly/>
									<span class="error">
										<?php if (isset($nameErr) && !empty($nameErr)) {
											echo $nameErr;
										} ?>
									</span>
								</div>

								<label for="Email">Email address</label>
								<div class="form-label-group">
									<input type="email" name="email" value="<?php if (isset($requests[0]->email)) {
										echo htmlspecialchars($requests[0]->email);
									} ?>" class="form-control" required readonly/>
									<span class="error">
										<?php if (isset($emailErr) && !empty($emailErr)) {
											echo $emailErr;
										} ?>
									</span>
								</div>
								
								<label for="Bank">Bank</label>
								<div class="form-label-group">
									<input type="text" name="bank" value="<?php if (isset($requests[0]->bank)) {
										echo htmlspecialchars($requests[0]->bank);
									} ?>" class="form-control" required readonly/>
									<span class="error">
										<?php if (isset($bankErr) && !empty($bankErr)) {
											echo $bankErr;
										} ?>
									</span>
								</div>

								<label for="AccountName">Account Name</label>
								<div class="form-label-group">
									<input type="text" name="accountname" value="<?php if (isset($requests[0]->account_name)) {
										echo htmlspecialchars($requests[0]->account_name);
									} ?>" class="form-control" required readonly/>
									<span class="error">
										<?php if (isset($accountnameErr) && !empty($accountnameErr)) {
											echo $accountnameErr;
										} ?>
								</div>

								<label for="AccountNumber">Account Number</label>
								<div class="form-label-group">
									<input type="text" name="accountnumber" pattern="[0-9]{10}" value="<?php if (isset($requests[0]->account_number)) {
										echo htmlspecialchars($requests[0]->account_number);
									} ?>" class="form-control" required readonly/>
									<span class="error">
										<?php if (isset($accountnumberErr) && !empty($accountnumberErr)) {
											echo $accountnumberErr;
										} ?>
									</span>
								</div>

								<label for="Amount">Input Amount</label>
								<div class="form-label-group">
									<input type="text" name="amount" placeholder="Input amount in Kobo" value="<?php if (isset($amount)) {
										echo htmlspecialchars($amount);
									} ?>" class="form-control" required/>
									<span class="error">
										<?php if (isset($amountErr) && !empty($amountErr)) {
											echo $amountErr;
										} ?>
									</span>
								</div>

								<button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 10px;">Pay</button>
							</form>
						</div>
					</div>
					<a href="admin.php">Back to Employees page</a>
					<a href="" class="float-right" id="removeAttribute">Edit Employees Details</a>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			function removeAttribute(){
				$(this).closest('tr').find('input').removeAttr('readonly');
			}
		</script>
		<!-- Bootstrap JavaScript -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
 		<script src="Hello World"></script>
	</body>
</html>

