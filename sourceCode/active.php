<?php 
  require_once('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Active</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
		integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
		crossorigin="anonymous"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php 

	$error = '';
	$message = '';

	if (isset($_GET['email']) && isset($_GET['token'])) {
	    # code...
	    $email = $_GET['email'];
	    $token = $_GET['token'];
	    if (filter_var($email,  ) === false) {
	       # code...
	        $error = 'Invalid email address';
	    }elseif (strlen($token) != 32) {
	      # code...
	        $error = 'Invalid token format';
	    }else{
	        // check database
	        $result = activateAccount($email, $token);
	        if ($result['code'] == 0) {
				$message = 'Your account has been activated. Login now';
	        }else{
	        	$error = $result['error'];
	        }
	    }
  	}else{
    	$error ='Invalid acctivation url';
  	}
?>

<?php 
    if (!empty($error)) {
      	?>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mt-5 mx-auto p-3 border rounded">
                        <h4>Account Activation</h4>
                        <p class="text-danger"><?= $error ?></p>
                        <p>Click <a href="login.php">here</a> to login.</p>
                        <a class="btn btn-primary px-5" href="login.php">Login</a>
                    </div>
                </div>
            </div>  
      	<?php
    }else{
      	?>
            <div class="container">
              <div class="row">
                <div class="col-md-6 mt-5 mx-auto p-3 border rounded">
                    <h4>Account Activation</h4>
                    <p class="text-success">Congratulations! Your account has been activated.</p>
                    <p>Click <a href="login.php">here</a> to login and manage your account information.</p>
                    <a class="btn btn-primary px-5" href="login.php">Login</a>
                </div>
              </div>
            </div>
      	<?php
    }
?>
</body>
</html>