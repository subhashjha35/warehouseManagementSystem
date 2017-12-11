<?php
    session_start();
    include "../include/dbController.php";
    $cli = new Client();

    $result=$cli->viewClient($_SESSION['c_id']);
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
        .tag{
            position:absolute;
            right:30px;
            color:#fff;
            display:inline-block;
            background-color:#d6743a;
            text-align:center;
            height:50px;
            width:50px;
            padding-top:14px;
            border-radius:50%;
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
                        <a href="index.php" class="btn btn-classic"><i class="fa fa-dashboard" style="font-size:28px;"></i></a>
                    </div>
                </div>
            </div>
            <div class="alert alert-info alert-dismissible fade show"><strong>Welcome <?=$sessionWarehouseUser['c_name'];?>.</strong> You are Logged in to your client Dashboard<span class="close" data-dismiss="alert">&times;</span></div>
            <div class="main_container">
                <div class="row text-center" id="dashboard">
                    <div class="col-md-4">
                        <div class="card alert-danger">
                            <a href="stock_details.php"class="alert-link">
                                <div class="card-block">
                                    <div class="fa fa-bar-chart fa-4x"></div>
                                    <span class="tag"><?php $stock=new Stock(); echo $stock->countRows(); ?></span>
                                </div>
                            </a>
                            <div class="card-footer">
                                My Requests
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card alert-success">
                            <a href="products_view.php" class="alert-link">
                                <div class="card-block">
                                    <div class="fa fa-shopping-basket fa-4x"></div>
                                    <span class="tag"><?php $pro=new WarehouseProduct(); echo $pro->countRows(); ?></span>
                                </div>
                            </a>
                            <div class="card-footer">
                                Total Products
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card alert-danger">
                            <a href="warehouses.php" class="alert-link">
                                <div class="card-block">
                                    <div class="fa fa-building fa-4x"></div>
                                    <span class="tag"><?php $whm=new WHM(); echo $whm->countRows(); ?></span>
                                </div>
                            </a>
                            <div class="card-footer">
                                Warehouses
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card alert-success">
                            <a href="product_request.php" class="alert-link">
                                <div class="card-block">
                                    <div class="fa fa-pencil fa-4x"></div>
                                </div>
                            </a>
                            <div class="card-footer">
                                Make a New Request
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card alert-danger">
                            <a href="edit_profile.php" class="alert-link">
                                <div class="card-block">
                                    <div class="fa fa-user fa-4x"></div>
                                </div>
                            </a>
                            <div class="card-footer">
                                My Profile
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card alert-success">
                            <a href="dtr_view.php" class="alert-link">
                                <div class="card-block">
                                    <div class="fa fa-exchange fa-4x"></div>
                                </div>
                            </a>
                            <div class="card-footer">
                                Daily Transaction Register
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
