<?php 
    require_once('db.php');
?>
<DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
    $error = '';
    $email = '';
    $message = '';

    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        if (empty($email)) {
            $error = 'Please enter your email';
        }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error = 'This is not a valid email address';
        }
        else {
            // reset password
            reset_password($email);
            $message = 'If your email exists in the database, you will receive an email containing the reset password instructions.';
        }
    }
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">Reset Password</h3>
            <form method="post" action="" class=" w-100 mb-5 mx-auto px-3 pt-3">
                <div class="form-group">
                    <input name="email" id="email" type="text" class="form-control" placeholder="Email address">
                </div>
                <div class="form-group">
                    <p><?= $message?></p>
                </div>
                <div class="form-group">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button class="btn btn-primary px-5">Reset password</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
