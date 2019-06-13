<!-- 
user:ps_admin;
password: csradmin 
-->

<?php 
session_start();
$login_message = '';
require_once ('core/config.inc.php'); 
$conn = DB(); 
require_once ('core/class.inc.php');
$app = new Connect;

if ($_SERVER["REQUEST_METHOD"] == "POST") {  

    if (isset($_POST["username"]) && !empty($_POST["username"])) { 
        $username = test_input(filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING));  
    } else {
        $login_message = "Username cannot be empty";
    }
    
    
    if (isset($_POST["password"]) && !empty($_POST["password"])) { 
        $password = test_input($_POST["password"]); 
    } else {
        $login_message = "Password cannot be empty";
    }

    if (empty($login_message)) { 
        $user_id = $app->Login($username, $password);
        echo $user_id;
        if ($user_id > 0) { 
            $_SESSION['user'] = $username; 
            header("Location: admin.php");
        }
        else{
            $login_message = "Invalid Login details";
        }
    }
}
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
	</head>
	<body>
		  <div class="container">
		    <div class="row">
		      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
		      	<?php if (isset($login_message) && !empty($login_message)) { ?> <br>
		      		<div class="alert alert-danger alert-dismissable">
		      			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		      			<strong>Error: </strong><?php echo "$login_message"; ?>.
		      		</div>
		      	<?php } ?>
		        <div class="card card-signin my-5">
		          <div class="card-body">
		            <h5 class="card-title text-center">Sign In</h5>
		            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  method="post" class="form-signin">
		              <label for="username">Username</label>
		              <div class="form-label-group">
		              	<input type="text" name="username" value="<?php if (isset($username)) {
		                    echo htmlspecialchars($username);
		                } ?>" placeholder="Username" class="form-control" required/>
		              </div>

		              <div class="form-label-group">
		              <label for="password">Password</label>
                        <input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control" autocomplete="off" required />
		              </div>

		              <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 10px;">Sign in</button>
		            </form>
		          </div>
		        </div>
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

