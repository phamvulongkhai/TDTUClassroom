<?php 
    session_start();
    // head to login.php
    if (!isset($_SESSION['user'])) {
        # code...
        header('Location: login.php');
        exit();
    }
    require_once('db.php');
    // dùng username để xác nhận quyền(username không trùng lắp)
    // nếu không phải admin(khác 1), sẽ không thể truy cập trang phân quyền
    if (selectrole($_SESSION['user']) != 1) {
        # code...
        header('Location: index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Thông tin sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- <script src="main.js" type="text/javascript" ></script> -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
    $error = '';
    $email = '';
    $radio = '';

    if (isset($_POST['email']) && isset($_POST['radio'])) {
        $email = $_POST['email'];
        $radio = $_POST['radio'];

        if (empty($email)) {
            $error = 'Please enter email';
        }
        else if (empty($radio)) {
            $error = 'Please enter your radio';
        }
        else{
            $result = setrole($email, $radio);
            if ($result['code'] == 0) {
                # code...
                $error = "Setup successfull";
            }elseif ($result['code'] == 2) {
                # code...
                $error =  "can not execute command";
            }elseif ($result['code'] == 3) {
                # code...
                $error =  "Email does not exists";
            }else{
                 $error =  "can not execute command";
            }
        }
    }
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8 border rounded my-5 p-4  mx-3">
            <p class="mb-2"><a href="index.php" class="text-decoration-none">Back</a></p>
            <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Setup Role</h3>
            <form method="post" action="" novalidate enctype="multipart/form-data">
                <div class="form-group">
                    <input value="<?= $email?>" name="email" required class="form-control" type="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio" id="inlineRadio1" value="1">
                        <label class="form-check-label" for="inlineRadio1">Admin</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio" id="inlineRadio2" value="2">
                        <label class="form-check-label" for="inlineRadio2">lecturer</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio" id="inlineRadio3" value="3">
                        <label class="form-check-label" for="inlineRadio3">Student</label>
                    </div>
                </div>

                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button type="submit" class="btn btn-primary px-5 mr-2">Setup</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>