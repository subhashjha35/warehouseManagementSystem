<?php
session_start();
include "../include/dbController.php";
$whm = new WHM();

$result=$whm->viewWHM($_SESSION['wm_id']);
$sessionWarehouseUser=mysqli_fetch_assoc($result);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="../js/jquery.js"></script>
    <script src="http://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../css/jquery-ui-1.10.4.min.css">
    <style type="text/css">

        @media screen and (min-width: 768px){
            .left-menu-box{
                padding-bottom:99999px;!important;
                margin-bottom:-99999px;!important;
                overflow:hidden;
            }
        }

    </style>
</head>
<body>
<?php include "include/header.php"; ?>
<!--<div class="jumbotron text-center">
    <h1>Welcome to the Warehouse Management</h1>
</div>-->
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-2 col-sm-4 left-menu-box">
            <?php include "./include/left_menu.php"; ?>
        </div>
        <div class="col-lg-10 col-sm-8 content-box">
            <div class="container">
                <div class="row">
                    <div class="btn-group btn-breadcrumb">
                        <a href="index.php" class="btn btn-classic"><i class="fa fa-home" style="font-size:28px;"></i></a>
                        <a href="#" class="btn btn-classic">Daily Transaction</a>
                    </div>
                </div>
            </div>
            <div class="main_container text-center">
                <img src="../resources/error/under_construction.png" alt="">
            </div>

        </div>
    </div>

</div>
</body>
</html>
