<?php 
    session_start();
    if (isset($_SESSION['user'])) {
        # code...
        header('Location: index.php');
        exit();
    }

    require_once('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
    $error = '';
    $fullname = '';
    $email = '';
    $phone = '';
    $birthday = '';
    $user = '';
    $pass = '';
    $pass_confirm = '';

    if (isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['birthday']) && isset($_POST['user']) &&
        isset($_POST['pass']) && isset($_POST['pass-confirm']))
    {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $birthday = $_POST['birthday'];
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $pass_confirm = $_POST['pass-confirm'];

        if (empty($fullname)) {
            $error = 'Please enter your full name';
        }
        else if (empty($email)) {
            $error = 'Please enter your email';
        }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error = 'This is not a valid email address';
        }
        else if (empty($phone)) {
            $error = 'Please enter your number phone';
        }
        else if (empty($birthday)) {
            $error = 'Please enter your birthday';
        }
        else if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($pass)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pass) < 6) {
            $error = 'Password must have at least 6 characters';
        }
        else if ($pass != $pass_confirm) {
            $error = 'Password does not match';
        }
        else {
            // register a new account
            $result = register($fullname, $email, $phone, $birthday, $user, $pass);
            if ($result['code'] == 0) {
                header("Location: login.php");
                die();
            }else if ($result['code'] == 1){
                $error = 'This email is already exists';
            }else{
                $error = 'This username is already exists';
            }
        }
    }
?>
<body>
<div class="container">
<div class="row justify-content-center">
    <div class="col-xl-5 col-lg-6 col-md-8 my-5 p-4 rounded mx-3">
        <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Create a new account</h3>
        <form method="post" action="">
            <!-- fullname -->
            <div class="form-group">
                <input value="<?= $fullname?>" name="fullname"  class="form-control" type="text" placeholder="Full name" id="fullname">
            </div>
            <!-- email -->
            <div class="form-group">
                <input value="<?= $email?>" name="email" class="form-control" type="email" placeholder="Email" id="email">
            </div>
            <!-- phone -->
            <div class="form-group">
                <input value="<?= $phone?>" name="phone" class="form-control" type="number" placeholder="Number phone" id="phone">
            </div>
            <!-- birthday -->
            <div class="form-group">
                <input value="<?= $birthday?>" name="birthday" class="form-control" type="date" id="birthdate">
            </div>
            <!-- user -->
            <div class="form-group">
                <input value="<?= $user?>"  name="user"  class="form-control" type="text" placeholder="User name" id="username">
            </div>
            <!-- pass -->
            <div class="form-group">
                <input  name="pass" class="form-control" type="password" placeholder="Password" id="pass">
                <div class="invalid-feedback">Password is not valid.</div>
            </div>
            <!-- pass-confirm -->
            <div class="form-group">
                <input name="pass-confirm" class="form-control" type="password" placeholder="Confirm Password" id="pass2">
                <div class="invalid-feedback">Password is not valid.</div>
            </div>
            <div class="form-group">
                <?php
                    if (!empty($error)) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                ?>
                <button type="submit" class="btn btn-primary px-5 mt-3 mr-2">Register</button>
                <button type="reset" class="btn btn-primary px-5 mt-3">Reset</button>
            </div>
            <div class="form-group">
                <p>Already have an account? <a href="login.php" class="text-decoration-none">Login</a> now.</p>
            </div>
        </form>
    </div>
</div>
</div>
</body>
</html>