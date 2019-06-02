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

// function logout()
// {
// 	unset($_SESSION['user_id']);
// 	session_unset();
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
			<div class="container-fluid">
			<div class="card mb-3">
				<div class="card-header">
					<i class="fa fa-table"></i>Employees Table</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>ID</th>
										<th>Employee</th>
										<th>Email</th>
										<th>Account Name</th>
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
										<th>Account Name</th>
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
								    <td><?php echo $request->account_name;?></td>
								    <td><?php echo $request->account_number;?></td>
								    <td><?php echo $request->bank;?></td>
								    <td><?php echo $request->date;?></td>
								    <td><a href="<?php echo "pay.php?id=".$request->id;?>">Edit</a></td>
								    <td><button type="button" onclick="payWithPaystack()"> Pay </button></td>
								  </tr>
								  <?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
				</div>
			</div>		
			<!-- place below the html form -->
			<script>
			  function payWithPaystack(){
			    var handler = PaystackPop.setup({
			      key: 'pk_test_20b286d4af3125ddbea6c12f54c42289a287be0f',
			      email: 'customer@email.com',
			      amount: 10000,
			      ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
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
<!-- <?php
  include_once('include/footer.php')
?> -->