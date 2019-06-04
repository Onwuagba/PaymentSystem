<?php 
session_start();
if (isset($_SESSION['user'])&& !empty($_SESSION['user'])) { 
  session_regenerate_id(); 
}else{
  unset($_SESSION['user']);
  session_destroy();
  header("Location: index.php");
}

$id = "";

// get id from URL
if (isset($_GET['id'])) { 
	$id = $_GET['id'];
}
// else{
//   session_destroy();
//   header("Location: index.php");
// }

$login_message = '';
require_once ('core/config.inc.php'); 
$conn = DB(); 
require_once ('core/class.inc.php');
$app = new Connect;
$requests = $app->getDetails($id); 
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
					  <?php
					  if (isset($_SESSION['failed'])) {
					     echo '<div class="alert alert-danger text-center">
					     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					     <p class="text-size-16">'.$_SESSION['failed'].'</p>
					     </div>'; unset($_SESSION['failed']);
					 }elseif (isset($_SESSION['update'])&&!empty($_SESSION['update'])){
					  echo '<div class="alert alert-success text-center">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  <strong style="font-size:16px;">'. $_SESSION['update'] .'</strong>
					  </div>';unset($_SESSION['update']);
					}
					?>
					<div class="card card-signin my-5">
						<div class="card-body">
							<h5 class="card-title text-center">Pay Employee</h5>

							<form action="verify.php"  method="POST" class="form-signin">
								<input type="hidden" name="id" id="input" class="form-control" value="<?php if (isset($id)){
										echo htmlspecialchars($id);
									}
									elseif (isset($requests[0]->id)) {
										echo $requests[0]->id;
									} ?>">

								<label for="Name">Employee Name</label>
								<div class="form-label-group">
									<input type="text" name="name" value="<?php if (isset($name)){
										echo htmlspecialchars($name);
									}
									elseif (isset($requests[0]->name)) {
										echo $requests[0]->name;
									} ?>" class="form-control" required/>
									<span class="error">
										<?php if (isset($nameErr) && !empty($nameErr)) {
											echo $nameErr;
										} ?>
									</span>
								</div>

								<label for="Email">Email address</label>
								<div class="form-label-group">
									<input type="email" name="email" value="<?php if (isset($email)){
										echo htmlspecialchars($email);
									}
									elseif (isset($requests[0]->email)) {
										echo htmlspecialchars($requests[0]->email);
									} ?>" class="form-control" required/>
									<span class="error">
										<?php if (isset($emailErr) && !empty($emailErr)) {
											echo $emailErr;
										} ?>
									</span>
								</div>
								
								<label for="Amount">Input Amount</label>
								<div class="form-label-group">
									<input type="text" name="amount" placeholder="Input amount in Kobo" pattern="[0-9]{}" value="<?php if (isset($amount)){
										echo htmlspecialchars($amount);
									}
									elseif (isset($requests[0]->salary)) {
										echo htmlspecialchars($requests[0]->salary);
									} ?>" class="form-control" required/>
									<span class="error">
										<?php if (isset($amountErr) && !empty($amountErr)) {
											echo $amountErr;
										} ?>
									</span>
								</div>

								<label for="Bank">Select Bank</label>
								<div class="form-label-group">
									<select name="bank" id="input" class="form-control" required>
										<option value="">-- Select One --</option>
										<option value="Access Bank">Access Bank</option>
										<option value="First Bank">First Bank</option>
										<option value="United Bank For Africa">UBA Bank</option>
										<option value="Standard Bank">Standard Chartered</option>
										<option value="Stanbic Bank">Stanbic IBTC</option>
										<option value="Union Bank">Union Bank</option>
										<option value="Unity Bank">Unity Bank</option>
										<option value="Fidelity Bank">Fidelity Bank</option>
										<option value="Zenith Bank">Zenith Bank</option>
										<option value="Keystone Bank">Keystone Bank</option>
									</select>
									<span class="error">
										<?php if (isset($bankErr) && !empty($bankErr)) {
											echo $bankErr;
										} ?>
									</span>
								</div>

								<label for="AccountNumber">Account Number</label>
								<div class="form-label-group">
									<input type="text" name="accountnumber" pattern="[0-9]{10}" value="<?php if (isset($accountnumber)){
										echo htmlspecialchars($accountnumber);
									}
									elseif (isset($requests[0]->account_number)) {
										echo htmlspecialchars($requests[0]->account_number);
									} ?>" class="form-control" required/>
									<span class="error">
										<?php if (isset($accountnumberErr) && !empty($accountnumberErr)) {
											echo $accountnumberErr;
										} ?>
									</span>
								</div>

								<button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 10px;">Update</button>
							</form>
						</div>
					</div>
					<a href="admin.php">Back to Employees page</a>
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

