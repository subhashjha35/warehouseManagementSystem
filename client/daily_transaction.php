<?php
session_start();
include "../include/dbController.php";
$cm = new CM();

$result=$cm->viewCM($_SESSION['c_id']);
$sessionUser=mysqli_fetch_assoc($result);

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
        .left-menu-box{
            background: #ccc;
            padding: 0px;
        }
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
<div class="jumbotron text-center">
    <h1>Welcome to the Client Management</h1>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <?php include "./include/left_menu.php";?>
        </div>
        <div class="col-lg-9">
            <div class="alert alert-info alert-dismissible fade show"><strong>You are logged in to <?=$sessionUser['c_name'];?>.</strong> To User another account, signout first.<span class="close" data-dismiss="alert">&times;</span></div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#incoming" role="tab" aria-controls="incomming">Incoming Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#outgoing" role="tab" aria-controls="profile">Outgoing Orders</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="incoming" role="tabpanel">
                    <form action="daily_transaction.php#incoming">
                        <div class="form-group">
                            <label for="request_id">Request ID</label>
                            <input type="text" id="request_id" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="product_id">Product ID</label>
                            <input type="text" id="product_id" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" id="product_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info">Confirm and Submit</button>
                            <button class="btn btn-secondary">Clear Fields</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="outgoing" role="tabpanel">
                    <form action="daily_transaction.php#outgoing">
                        <div class="form-group">
                            <label for="request_id">Request ID</label>
                            <input type="text" id="request_id" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="product_id">Product ID</label>
                            <input type="text" id="product_id" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" id="product_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info">Confirm and Submit</button>
                            <button class="btn btn-secondary">Clear Fields</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
