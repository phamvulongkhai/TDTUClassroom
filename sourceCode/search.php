<!-- tìm kiếm lớp học -->

<?php 
    session_start();
    // head to login.php
    if (!isset($_SESSION['user'])) {
        # code...
        header('Location: login.php');
        exit();
    }
    require_once('db.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="index.php"><span class="text-light">Welcome <?= $_SESSION['name'] ?> </span></a>
        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="addclass.php">Add Class</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="deleteclass.php">Delete Class</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="changeinfo.php">Update Info</a>
                </li>
                <form class="form-inline" method="post" action="search.php">
                    <input class="form-control mr-sm-2" name="search" type="text" placeholder="Search Class">
                    <button class="btn btn-primary" type="submit" > Search </button>
                </form>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row justify-content-center">
<?php
    
    $sql = "SELECT * from class"; 
    $search = '';
    if (isset($_POST['search'])) {
        # code...
        $search = $_POST['search'];
        if (empty($search)) {
            # code...
        }
        else{
            $sql = "SELECT * from class where classid = '$search' or 
            (classname = '$search') or 
            (room = '$search') or
            (subjects = '$search')";
            $conn = open_database();
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "
                    <div class='col-xl-3 col-lg-4 col-md-6 col-xs-12'>
                        <div class='card mt-4'  >
                            <img class='card-img-top' src='./image/".$row['image']."' alt='Card image cap'>
                                <div class='card-body'>
                                <h5 class='card-title'>Mã lớp: ".$row['classid'].". </h5>
                            </div>
                            <ul class='list-group list-group-flush'>
                                <li class='list-group-item'>Tên lớp: ".$row['classname']." </li>
                                <li class='list-group-item'>phòng: ".$row['room']."</li>
                                <li class='list-group-item'>Tên môn học: ".$row['subjects']."</li>
                            </ul>
                        </div>
                    </div>";
                }
            } else {
            ?>
            	<div class="alert alert-primary col-xl-3 col-lg-4 col-md-6 col-xs-12" role="alert">
				 	Could not find any classrooms
            	</div>
			<?php
            }
        }
    }
?>
    </div>
</div>
</body>
</html>