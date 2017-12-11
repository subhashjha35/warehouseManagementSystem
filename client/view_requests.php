<?php
session_start();
include "../include/dbController.php";
$cli = new Client();
$result=$cli->viewClient($_SESSION['c_id']);
$sessionWarehouseUser=mysqli_fetch_assoc($result);
if(isset($_POST['product'])){

    $res=$cli->createRequest($_POST);
    if($res==0){
        header("location:product_request.php?request_error");
    }
}
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
    <script>
        $(document).ready(function(){

        });
    </script>
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
                        <a href="#" class="btn btn-classic">My Requests</a>
                    </div>
                </div>
            </div>
            <?php
            if(isset($_GET['request_error'])):
                ?>
                <div class="alert alert-warning">Error while making a request <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a></div>
                <?php
            endif;
            ?>
            <div class="main_container jumbotron alert-info">
                <h3>My Requests</h3>
                <hr>
                <table class="table">
                    <tr>
                        <th>Request ID</th>
                        <th>Product ID</th>
                        <th>Product Quantity</th>
                        <th>Authority Requested</th>
                        <th>Date</th>
                    </tr>
                    <?php
                        $res=$cli->viewRequest();

                        while ($row=$res->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?=$row['request_id'];?></td>
                            <td><?=$row['product_id'];?></td>
                            <td><?=$row['product_qty'];?></td>
                            <td><?=$row['request_to'];?></td>
                            <td><?=$row['request_time'];?></td>
                        </tr>
                    <?php
                        endwhile;
                    ?>
                </table>
            </div>
        </div>
    </div>

</div>
</body>
</html>
