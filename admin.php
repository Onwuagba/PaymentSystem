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

// checks if payment transaction has been made
if(isset($_SESSION['payment'])){
	$payment = $_SESSION['payment'];
}
// function logout()
// {
// 	unset($_SESSION['user_id']);
// 	session_unset();
// 	session_destroy(); 
// 	header("Location: index.php");
// }

$viewBalance = $app->checkBalance();
?>
<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Payment System</title>

	<!-- Bootstrap CSS -->
	<!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- PAystack API -->
	<script src="https://js.paystack.co/v1/inline.js"></script>
</head>
<body>  
	<div style="margin: 20px;">
		<a href="register.php"><button type="button" class="btn btn-primary">Add new</button></a>
		<a href="<?php ?> "><button type="button" class="btn btn-danger">Logout</button></a>
	</div>
	<div class="content-wrapper"> 
		<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
			<?php if (isset($payment)&&!empty($payment)) {
				echo "<div class=\"alert alert-success\">
				<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
				<strong><span class=\"glyphicon glyphicon-ok\"></span> </strong> $payment
				</div>";
				unset($_SESSION['payment']);
			} 
			?>
		</div>
		<div class="container-fluid">
			<div class="collapse" id="collapseExample">
				<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
					<div class="card card-signin my-5">
						<div class="card-body">
							<h5 class="card-title text-center">Bulk Payment</h5>
							<form action="bulk.php"  method="post" class="form-signin">
								<div class="form-label-group">
									<textarea name="description" placeholder="Enter a brief description of payment" value="" class="form-control" required></textarea>
								</div>
								<button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 10px;">Pay</button>
							</form><br>	
							<span class="text-muted" style="font-size: 12px;">Take your time to confirm that the email addresses and amount in the table are correct. Click the edit link of each employee to update.</span>
						</div>
					</div>
				</div>
			</div>
			<div class="card mb-3">
				<div class="card-header">
					<i class="fa fa-table"></i>Employees Table
					<div class="float-right">
						<span class="float-right">
							Balance: <b> &#8358; <?php 
							echo "$viewBalance";
							?> </b>
						</span> <br>
						<button type="button" class="btn btn-success" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Bulk Payment</button>
						<button type="button" onclick="payWithPaystack()" class="btn btn-warning">Top up Account</button>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>ID</th>
									<th>Employee</th>
									<th>Email</th>
									<th>Amount</th>
									<th>Account Number</th>
									<th>Bank</th>
									<th>Date Added</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>ID</th>
									<th>Employee</th>
									<th>Email</th>
									<th>Amount</th>
									<th>Account Number</th>
									<th>Bank</th>
									<th>Date Added</th>
									<th></th>
									<th></th>
								</tr>
							</tfoot>
							<tbody>
								<?php foreach ($requests as $request) {?>
									<tr>
										<td><?php echo $request->id;?></td>
										<td><?php echo $request->name;?></td>
										<td><?php echo $request->email;?></td>
										<td><?php echo $request->salary;?></td>
										<td><?php echo $request->account_number;?></td>
										<td><?php echo $request->bank;?></td>
										<td><?php echo $request->date;?></td>
										<td><a href="<?php echo "pay.php?id=".$request->id;?>">Pay</a></td></td>
										<td><a href="<?php echo "edit.php?id=".$request->id;?>">Edit</a></td></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
			</div>
		</div>	
		<script>
			function payWithPaystack(){
				var handler = PaystackPop.setup({
					key: 'pk_test_20b286d4af3125ddbea6c12f54c42289a287be0f',
					email: 'customer@email.com',
					amount: 10000000,
					metadata: {
						custom_fields: [
						{
							display_name: "Mobile Number",
							variable_name: "mobile_number",
							value: "+2348012345678"
						}
						]
					},
					callback: function(response){
						alert('success. transaction ref is ' + response.reference);
					},
					onClose: function(){
						alert('window closed');
					}
				});
				handler.openIframe();
			}
		</script>	
	</div>
	<!-- Bootstrap JavaScript -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="Hello World"></script>
</body>
</html>
