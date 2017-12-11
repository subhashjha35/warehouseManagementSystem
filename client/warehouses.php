<?php
session_start();
include "../include/dbController.php";
$cli = new Client();
$whm = new WHM();
$result=$cli->viewClient($_SESSION['c_id']);
$all_whm=$whm->viewWHM();
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
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">
    <style type="text/css">

        @media screen and (min-width: 768px){
            .left-menu-box{
                padding-bottom:99999px;!important;
                margin-bottom:-99999px;!important;
                overflow:hidden;
            }
            #dashboard .col-md-4{
                margin:15px auto;
            }
        }
        .content-box{
            padding-top:10px;
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

        <div class="col-lg-3 col-sm-4 left-menu-box">
            <?php include "./include/left_menu.php"; ?>
        </div>
        <div class="col-lg-9 col-sm-8 content-box">
            <div class="container">
                <div class="row">
                    <div class="btn-group btn-breadcrumb">
                        <a href="index.php" class="btn btn-classic"><i class="fa fa-home" style="font-size:28px;"></i></a>
                    </div>
                </div>
            </div>
            <div class="main_container">
                <div class="row text-center" id="dashboard">
                    <div><strong>Total No. of Warehouses : 1</strong></div>
                </div>
                <?php
                    while($row=$all_whm->fetch_assoc()): ?>
                <div class="row alert alert-success">
                    <div class="col-md-2">
                        <img src="<?=$row['pic_path'];?>" class="img-fluid rounded" alt="">
                    </div>
                    <div class="col-md-5">
                        <h2><?=$row['warehouse_name'];?></h2>
                        <h5>Location : <?=$row['warehouse_location'];?></h5>
                        <h5>Warehouse ID : <?=$row['wm_id'];?></h5>
                    </div>
                    <div class="col-md-5">
                        <h2><?=$row['wm_name'];?></h2>
                        <h5>Designation : <?=$row['wm_designation'];?></h5>
                        <h5>Contact No. : <?=$row['contact_no'];?></h5>
                        <h5>Email : <a href="mailto:<?=$row['email'];?>"><?=$row['email'];?></a></h5>
                    </div>
                </div>
                </div>
                <?php
                    endwhile;
                ?>
            </div>
        </div>
    </div>

</div>
</body>
</html>
