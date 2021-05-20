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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
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
                <?php
                    if (selectrole($_SESSION['user']) == 1) {
                        # code...
                        echo "
                        <li class='nav-item'>
                            <a class='nav-link' href='addclass.php'>Add Class</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='deleteclass.php'>Delete Class</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='changeinfo.php'>Update Info</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='setrole.php'>Setup role</a>
                        </li>
                        ";
                    }elseif (selectrole($_SESSION['user']) == 2) {
                        # code...
                        echo "
                        <li class='nav-item'>
                            <a class='nav-link' href='addclass.php'>Add Class</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='deleteclass.php'>Delete Class</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='changeinfo.php'>Update Info</a>
                        </li>
                        ";
                    }elseif (selectrole($_SESSION['user']) == 3) {
                        # code...
                        echo "
                        <li class='nav-item'>
                            <a class='nav-link' href='joinclass.php'>Join Class</a>
                        </li>
                        ";
                    }else{
                        exit();
                    }

                ?>
                <form class="form-inline" method="post" action="search.php">
                    <input class="form-control mr-sm-2" name="search" type="text" placeholder="Search Class">
                    <button class="btn btn-primary mt-1" type="submit" > Search </button>
                </form>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-3">
    <div class="row">
        <h4 class="ml-3">Hi <?=$_SESSION['name']?>, Here is your class list:</h4>
    </div>
</div>
<div class="container">
    <div class="row">
        <?php
            if (selectrole($_SESSION['user']) == 1) {
                // load lớp học admin từ database
                $sql_load = "SELECT * from class";
                $conn_load = open_database();
                $result_load = $conn_load->query($sql_load);
                if (!empty($result_load) && $result_load->num_rows > 0) {
                    // output data of each row
                    while($row = $result_load->fetch_assoc()) {
                        echo "
                        <div class='col-xl-3 col-lg-4 col-md-6 col-xs-12' >
                            <div class='card mt-4'  >
                                <img class='card-img-top' src='./image/".$row['image']."' alt='Card image cap'>
                                    <div class='card-body'>
                                    <h5 class='card-title'>
                                        <a href='classinfo.php' class='text-decoration-none'>Class ID: ".$row['classid']."</a>
                                    </h5>
                                </div>
                                <ul class='list-group list-group-flush'>
                                    <li class='list-group-item'>Class Name: ".$row['classname']."</li>
                                    <li class='list-group-item'>Room: ".$row['room']."</li>
                                    <li class='list-group-item'>Subject title: ".$row['subjects']."</li>
                                </ul>
                            </div>
                        </div>";
                    }
                }else{
                    Echo "
                    <div class='alert alert-primary ml-2' role='alert'>
                        You are in no class.
                    </div>
                    ";
                }
            }elseif (selectrole($_SESSION['user']) == 2) {
                // load lớp học của giảng viên từ database
                $sql_load = "SELECT * from class where add_by_lecturers =  '{$_SESSION['user']}' ";
                $conn_load = open_database();
                $result_load = $conn_load->query($sql_load);
                if (!empty($result_load) && $result_load->num_rows > 0) {
                    // output data of each row
                    while($row = $result_load->fetch_assoc()) {
                        echo "
                        <div class='col-xl-3 col-lg-4 col-md-6 col-xs-12' >
                            <div class='card mt-4'  >
                                <img class='card-img-top' src='./image/".$row['image']."' alt='Card image cap'>
                                    <div class='card-body'>
                                    <h5 class='card-title'>
                                        <a href='classinfo.php' class='text-decoration-none'>Class ID: ".$row['classid']."</a>
                                    </h5>
                                </div>
                                <ul class='list-group list-group-flush'>
                                    <li class='list-group-item'>Class Name: ".$row['classname']." </li>
                                    <li class='list-group-item'>Room: ".$row['room']."</li>
                                    <li class='list-group-item'>Subject title: ".$row['subjects']."</li>
                                </ul>
                            </div>
                        </div>";
                    }
                }else{
                    Echo "
                    <div class='alert alert-primary ml-2' role='alert'>
                        You are in no class.
                    </div>
                    ";
                }
            }elseif (selectrole($_SESSION['user']) == 3) {
                 // load lớp học của sinh viên đã tham gia từ database
                $sql_load = "SELECT * from class add_by_lecturers =  '{$_SESSION['user']}'";
                $conn_load = open_database();
                $result_load = $conn_load->query($sql_load);
                if (!empty($result_load) && $result_load->num_rows > 0) {
                    // output data of each row
                    while($row = $result_load->fetch_assoc()) {
                        echo "
                        <div class='col-xl-3 col-lg-4 col-md-6 col-xs-12' >
                            <div class='card mt-4'  >
                                <img class='card-img-top' src='./image/".$row['image']."' alt='Card image cap'>
                                    <div class='card-body'>
                                    <h5 class='card-title'>
                                        <a href='classinfo.php' class='text-decoration-none'>Class ID: ".$row['classid']."</a>
                                    </h5>
                                </div>
                                <ul class='list-group list-group-flush'>
                                    <li class='list-group-item'>Class Name: ".$row['classname']." </li>
                                    <li class='list-group-item'>Room: ".$row['room']."</li>
                                    <li class='list-group-item'>Subject title: ".$row['subjects']."</li>
                                </ul>
                            </div>
                        </div>";
                    }
                }else{
                    Echo "
                    <div class='alert alert-primary ml-2' role='alert'>
                        You are in no class.
                    </div>
                    ";
                }
            }

        ?>
<!-- ----------------------------------------- -->
    </div>
</div>
</body>
</html>