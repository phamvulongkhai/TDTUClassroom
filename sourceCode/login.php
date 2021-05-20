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
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
    $error = '';
    if (isset($_COOKIE['user']) && isset($_COOKIE['pass'])){
        $user = $_COOKIE['user'];
        $pass = $_COOKIE['pass'];
    }else{
        $user = '';
        $pass = '';
    }

    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($pass)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pass) < 6) {
            $error = 'Password must have at least 6 characters';
        }
        else{   
            $result = login($user, $pass);
            if ( $result['code'] == 0) {
                # code...
                if (isset($_POST['remember'])) {
                    # code...
                    setcookie('user', $user, time() + 3600);
                    setcookie('pass', $pass, time() + 3600);
                }

                $data = $result['data'];
                $_SESSION['user'] = $user;
                $_SESSION['name'] = $data['FullName'];
                header('Location: index.php');
                exit();

            }else{
                $error = $result['error'];
            }
        }
    }
?>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="mt-5 mb-3 text-secondary">Login</h3>
            <form action="login.php" method="post">
                <div class="form-group">
                    <input value="<?= $user?>" name="user" id="user" type="text" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">    
                    <input value="<?= $pass?>" name="pass" id="password" type="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input name="remember" type="checkbox" class="custom-control-input" id="remember">
                    <label class="custom-control-label text-secondary" for="remember" >Remember login</label>
                </div>
                <div class="form-group">
                    <?php  
                        if (!empty($error)) {
                            # code...
                            echo "<div class='alert alert-danger'>".$error."</div>";
                        }
                    ?>
                    <button type="submit" class="btn btn-primary px-5 ">Login</button>
                </div>
                <div class="form-group">
                    <p class="text-secondary">Don't have an account yet? <a href="register.php" class=" text-decoration-none" >Register now</a>.</p>
                    <p class="text-secondary">Forgot your password? <a href="forgot.php" class="text-decoration-none" >Reset your password</a>.</p>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>