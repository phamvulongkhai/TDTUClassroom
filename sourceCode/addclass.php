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
    // nếu là sinh viên(permission = 3), sẽ không thể truy cập trang thêm lớp học
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
    <script src="main.js" type="text/javascript" ></script>
</head>
<body>
<?php

    $error = '';
    $classname = '';
    $subjectname = '';
    $room = '';

    if (isset($_POST['classname']) && isset($_POST['subjectname']) && isset($_POST['room'])) {
        $classname = $_POST['classname'];
        $subjectname = $_POST['subjectname'];
        $room = $_POST['room'];

        if (empty($classname)) {
            # code...
            $error = 'Please enter Class name';
        }
        elseif (empty($subjectname)) {
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
            $name = $_FILES['image']['name'];
            $temp_name = $_FILES['image']['tmp_name'];
            $uploads_dir = './image/';  
            move_uploaded_file($temp_name, $uploads_dir.$name);
            // nếu là ad thì dùng hàm addclass
            if (selectrole($_SESSION['user']) == 1) {
                # code...
                $result = addclass($classname, $subjectname, $room, $name);
                if ($result['code'] == 0) {
                    # code...
                    $error = "Admin add success";
                }elseif ($result['code'] == 2) {
                    # code...
                    $error =  "can not execute command";
                }else{
                    $error = "Can not execute command";
                }
            }else{
                // ngược lại là giảng viên thì dùng addclassLec()
                // không có trường hợp cho sinh viên, vì sv không có quyền thêm
                // $_SESSION['user'] để phân biệt giáo viên nào đã thêm lớp học.
                $result = addclassLec($classname, $subjectname, $room, $name, $_SESSION['user']);
                if ($result['code'] == 0) {
                    # code...
                    $error = "Successfully added by " . $_SESSION['name'];
                }elseif ($result['code'] == 2) {
                    # code...
                    $error =  "can not execute command";
                }else{
                    $error = "Can not execute command";
                }               
            }
        }
    }

?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8 border rounded my-5 p-4  mx-3">
            <p class="mb-2"><a href="index.php" class="text-decoration-none">Back</a></p>
            <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Add Class</h3>
            <form method="post" action="" novalidate enctype="multipart/form-data">
                <div class="form-group">
                    <input value="<?= $classname?>" name="classname" required class="form-control" type="text" placeholder="Class name">
                </div>
                <div class="form-group">
                    <input value="<?= $subjectname?>" name="subjectname" required class="form-control" type="text" placeholder="Subject name">
                </div>
                <div class="form-group">
                    <input value="<?= $room?>" name="room" required class="form-control" type="text" placeholder="Room">
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input name="image" type="file" class="custom-file-input" id="customFile" accept="image/gif, image/jpeg, image/png, image/bmp">
                        <label class="custom-file-label" for="customFile">Avatar</label>
                    </div>
                </div>
                <div class="form-group">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button type="submit" class="btn btn-primary px-5 mr-2">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

