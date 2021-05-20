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
    // nếu là sinh viên(permission = 3), sẽ không thể truy cập trang sửa lớp học
    if (selectrole($_SESSION['user']) == 3) {
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
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- <script src="main.js" type="text/javascript" ></script> -->
</head>
<body>
<?php

    $error = '';
    $classname = '';
    $subjects = '';
    $room = '';
    $classid = '';
    if (isset($_POST['classname']) && isset($_POST['subjects']) && isset($_POST['room']) && isset($_POST['classid'])) {
        $classname = $_POST['classname'];
        $subjects = $_POST['subjects'];
        $room = $_POST['room'];
        $classid = $_POST['classid'];

        if (empty($classid)) {
            # code...
            $error = 'Please enter class id';
        }elseif (empty($classname)) {
            # code...
            $error = 'Please enter Class name';
        }
        elseif (empty($subjects)) {
            # code...
            $error = 'Please enter Subject name';
        }
        elseif (empty($room)) {
            # code...
            $error = 'Please enter room name';
        }
        elseif ($_FILES['image']['error'] != UPLOAD_ERR_OK) {
            # code...
            $error = 'Please upload class avatar';
        }
        else{
            $image = $_FILES['image']['name'];
            $temp_name = $_FILES['image']['tmp_name'];
            $uploads_dir = '';  
            move_uploaded_file($temp_name, $uploads_dir. $image);
            // 1 là quyền admin
            if (selectrole($_SESSION['user']) == 1) {
                # code...
                $result = changeinfo($classname, $room, $subjects, $image, $classid);
                if ($result['code'] == 0) {
                    # code...
                    $error = "Admin change Successfully";
                }elseif ($result['code'] == 2) {
                    # code...
                    $error =  "can not execute command";
                }elseif ($result['code'] == 3) {
                    # code...
                    $error =  "ID does not exists";
                }else{
                    die();
                }
            }else {
                // ngược lại là quyền giảng viên
                // không có trường hợp cho sinh viên, vì sv không có quyền thay đổi
                $result = changeinfoLec($classname, $room, $subjects, $image, $classid, $_SESSION['user']);
                if ($result['code'] == 0) {
                    # code...
                    $error = "Successfully updated by ". $_SESSION['name'];
                }elseif ($result['code'] == 2) {
                    # code...
                    $error =  "can not execute command";
                }elseif ($result['code'] == 3) {
                    # code...
                    $error =  "ID does not exists";
                }elseif ($result['code'] == 1) {
                    # code...
                    $error =  "You do not have permission to delete this class";
                }else{
                    die();
                }
            }
        }
    }

?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8 border rounded my-5 p-4  mx-3">
            <p class="mb-2"><a href="index.php" class="text-decoration-none">Back</a></p>
            <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Change information</h3>
            <form method="post" action="" novalidate enctype="multipart/form-data">
                <div class="form-group">
                    <label for="classid" class="text-dark">Please enter the correct class id to change below infor</label>
                    <input value="<?= $classid?>" name="classid" required class="form-control" type="text" placeholder="Class id">
                </div>
                <div class="form-group">
                    <input value="<?= $classname?>" name="classname" required class="form-control" type="text" placeholder="New Class name">
                </div>
                <div class="form-group">
                    <input value="<?= $subjects?>" name="subjects" required class="form-control" type="text" placeholder="New Subject name">
                </div>
                <div class="form-group">
                    <input value="<?= $room?>" name="room" required class="form-control" type="text" placeholder="New Room">
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input name="image" type="file" class="custom-file-input" id="customFile" accept="image/gif, image/jpeg, image/png, image/bmp">
                        <label class="custom-file-label" for="customFile">New Avatar</label>
                    </div>
                </div>
                <div class="form-group">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button type="submit" class="btn btn-primary px-5 mr-2">Change</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

