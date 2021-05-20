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
    // nếu là sinh viên(permission = 3), sẽ không thể truy cập trang xoá lớp học
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
    <script src="main.js" type="text/javascript" ></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
    $error = '';
    $classid = '';
    if (isset($_POST['classid'])) {
        # code...
        $classid = $_POST['classid'];

        if (empty($classid)) {
            # code...
            $error = 'Please enter Class id';
        }else{
            // Nếu tài khoản là admin thì dùng deleteclass()
            if (selectrole($_SESSION['user']) == 1) {
                # code...
                $result = deleteclass($classid);
                if ($result['code'] == 0) {
                    # code...
                    $error = 'Admin delete success';
                }
                elseif ($result['code'] == 2) {
                    # code...
                    $error = 'Can not execute command';
                }elseif ($result['code'] == 3) {
                    # code...
                    $error = 'ID does not exist';
                }else{
                    die();
                }
            }else{
                // ngược lại là giảng viên thì dùng deleteclassLec()
                // không có trường hợp cho sinh viên, vì sv không có quyền xoá
                // $_SESSION['user'] để đảm bảo giáo viên chỉ có thể xoá lớp của mình
                $result = deleteclassLec($classid, $_SESSION['user']);
                if ($result['code'] == 0) {
                    # code...
                    $error = "Successfully deleted by " . $_SESSION['name'];
                }
                elseif ($result['code'] == 2) {
                    # code...
                    $error = 'Can not execute command';
                }elseif ($result['code'] == 3) {
                    # code...
                    $error = 'ID does not exist';
                }elseif ($result['code'] == 1) {
                    # code...
                    $error = 'You do not have permission to delete this class';
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
            <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Delete class</h3>
            <form method="post" action="" novalidate enctype="multipart/form-data">
                <div class="form-group">
                    <input value="<?= $classid?>" name="classid" required class="form-control" type="text" placeholder="Class id">
                </div>
                <div class="form-group">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button type="submit" class="btn btn-primary px-5 mr-2" Onclick="return ConfirmDelete()">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>