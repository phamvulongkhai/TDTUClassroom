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
    // nếu khác sinh viên sẽ không thể truy cập trang tham gia lớp học lớp học
    if (selectrole($_SESSION['user']) != 3) {
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
	$classid = '';

	if (isset($_POST['classid'])) {
		# code...
		$classid = $_POST['classid'];
		if (empty($classid )) {
			# code...
			$error = 'Please enter class id';
		}else{
			# code...
			$result = joinclass($classid, $_SESSION['user']);
			if ($result['code'] == 2) {
				# code...
				$error = 'Can not execute command';
			}elseif ($result['code'] == 0) {
				# code...
				$error = 'Join successfull';
			}
			elseif ($result['code'] == 1) {
				# code...
				$error = 'ID does not exists';
			}else{
				exit();
			}
		}
	}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8 border rounded my-5 p-4  mx-3">
            <p class="mb-2"><a href="index.php" class="text-decoration-none">Back</a></p>
            <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Join Class</h3>
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
                    <button type="submit" class="btn btn-primary px-5 mr-2">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
