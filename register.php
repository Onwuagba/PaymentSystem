<?php 
session_start();
if (isset($_SESSION['user'])&& !empty($_SESSION['user'])) {
  session_regenerate_id(); 
}else{
  unset($_SESSION['user']);
  session_destroy();
  header("Location: index.php");
}

$register_message = '';
require_once ('core/config.inc.php'); 
$conn = DB(); 
require_once ('core/class.inc.php');
$app = new Connect;
$name = $email = $bank = $accountname =  $accountnumber = $date = "";
$nameErr = $emailErr = $bankErr = $accountnameErr = $accountnumberErr = "";

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
        if ($app->isEmail($email)) {
            $emailErr = "Email already exists";
        }
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
    	elseif ($app->isAccountNumber($accountnumber)){
	        $accountnumberErr = "Account number already exists.";
	    }
    } else {
        $accountnumberErr = "Please enter an account number";
    }
    
    // DATE
    $date = date("Y-m-d h:i:s");
    if (empty($date)) {
        header('Location:https://efccnigeria.org');
    }

     $id="";    
     
    if (empty($nameErr) && empty($emailErr) && empty($bankErr) && empty($accountnameErr) && !empty($date) && empty($accountnumberErr)) {  
        $user_id = $app->Register($id, $name, $email, $accountname, $accountnumber, $bank, $date);
        if ($user_id > 0) { 
            $register_message = $name . ' has been successfully registered.';
        } else {
            $register_error = 'problem encountered. Ensure you have a working internet';
        }
    } else {
        $register_error = 'Error encountered. Kindly treat all errors before submitting';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
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
							<h5 class="card-title text-center">Add New Employee</h5>

							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  method="post" class="form-signin">
								<label for="Name">Name</label>
								<div class="form-label-group">
									<input type="text" name="name" value="<?php if (isset($name)) {
										echo htmlspecialchars($name);
									} ?>"class="form-control" required/>
									<span class="error">
										<?php if (isset($nameErr) && !empty($nameErr)) {
											echo $nameErr;
										} ?>
									</span>
								</div>

								<label for="Email">Email address</label>
								<div class="form-label-group">
									<input type="email" name="email" value="<?php if (isset($email)) {
										echo htmlspecialchars($email);
									} ?>" class="form-control" required/>
									<span class="error">
										<?php if (isset($emailErr) && !empty($emailErr)) {
											echo $emailErr;
										} ?>
									</span>
								</div>

								<label for="Bank">Select Bank</label>
								<div class="form-label-group">
									<select name="bank" id="input" class="form-control" required>
										<option value="">-- Select One --</option>
										<option value="Access">Access Bank</option>
										<option value="First">First Bank</option>
										<option value="GTB">GT Bank</option>
										<option value="UBA">UBA Bank</option>
										<option value="Standard">Standard Chartered</option>
										<option value="Stanbic">Stanbic IBTC</option>
										<option value="Union">Union Bank</option>
										<option value="Unity">Unity Bank</option>
										<option value="Fidelity">Fidelity Bank</option>
										<option value="Zenith">Zenith Bank</option>
										<option value="Keystone">Keystone Bank</option>
									</select>
									<span class="error">
										<?php if (isset($bankErr) && !empty($bankErr)) {
											echo $bankErr;
										} ?>
									</span>
								</div>

								<label for="AccountName">Account Name</label>
								<div class="form-label-group">
									<input type="text" name="accountname" value="<?php if (isset($accountname)) {
										echo htmlspecialchars($accountname);
									} ?>" class="form-control" required/>
									<span class="error">
										<?php if (isset($accountnameErr) && !empty($accountnameErr)) {
											echo $accountnameErr;
										} ?>
									</span>
								</div>

								<label for="AccountNumber">Account Number</label>
								<div class="form-label-group">
									<input type="text" name="accountnumber" pattern="[0-9]{10}" value="<?php if (isset($accountnumber)) {
										echo htmlspecialchars($accountnumber);
									} ?>" placeholder="Not more than 10 numbers" class="form-control" required/>
									<span class="error">
										<?php if (isset($accountnumberErr) && !empty($accountnumberErr)) {
											echo $accountnumberErr;
										} ?>
									</span>
								</div>

								<button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 10px;">Register</button>
							</form>
						</div>
					</div>
					<a href="admin.php">Back to Employees page</a>
				</div>
			</div>
		</div>
		<!-- Bootstrap JavaScript -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
 		<script src="Hello World"></script>
	</body>
</html>

