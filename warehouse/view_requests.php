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
                        <a href="#" class="btn btn-classic">Requests</a>
                    </div>
                </div>
            </div>
            <?php
                $distinct_req=$whm->viewDistinctRequest();
                $my_distinct_req=$whm->viewMyDistinctRequest();
            ?>
            <div class="main_container jumbotron alert-info">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><a class="nav-link alert-link" data-toggle="tab" href="#IncomingRequests"><h4>Incoming Requests</h4></a></li>
                    <li class="nav-item"><a class="nav-link alert-link" data-toggle="tab" href="#MyRequests"><h4>My Requests</h4></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade" id="IncomingRequests" role="tabpanel">
                        <?php
                        while($dist_req=$distinct_req->fetch_assoc()):
                            $req_id=$dist_req['request_id'];
                            $req_by=$dist_req['request_by'];
                            $res=$whm->viewRequest($req_id);
                            $i=0;
                            ?>
                            <div id="accordion" role="tablist" aria-multiselectable="true"">
                                <div class="card text-center" style="border-radius: 0;">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <h5 class="mb-0">
                                            <a class="alert-link" data-toggle="collapse" data-parent="#accordion" href="#product_<?=$req_id;?>" aria-expanded="true" aria-controls="product_<?=$req_id;?>">
                                                <span class="float-md-left">Request ID : <?=$req_id;?></span><span class=""> From : <?=$req_by;?></span><span class="float-md-right">Date: <?=date("d-m-Y",strtotime($dist_req['request_time']));?></span>
                                            </a>
                                        </h5>
                                    </div>

                                    <div id="product_<?=$req_id;?>" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="card-block">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Product ID</th>
                                                    <th>Product Quantity</th>
                                                    <th>Authority Requested</th>
                                                </tr>
                                                <?php
                                                while ($row=$res->fetch_assoc()):
                                                    ?>
                                                    <tr>
                                                        <td><?=++$i;?></td>
                                                        <td><?=$row['product_id'];?></td>
                                                        <td><?=$row['product_qty'];?></td>
                                                        <td><?=$row['request_by'];?></td>
                                                    </tr>
                                                    <?php
                                                endwhile;
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        ?>
                    </div>
                    <div class="tab-pane fade" id="MyRequests" role="tabpanel">
                        <?php
                        while($my_dist_req=$my_distinct_req->fetch_assoc()):
                            $my_req_id=$my_dist_req['request_id'];
                            $my_req_to=$my_dist_req['request_to'];
                            $my_res=$whm->viewMyRequest($my_req_id);
                            $i=0;
                            ?>
                            <div id="accordion2" role="tablist" aria-multiselectable="true">
                                <div class="card">
                                    <div class="card-header text-center" role="tab" id="headingOne">
                                        <h5 class="mb-0">
                                            <a class="alert-link" data-toggle="collapse" data-parent="#accordion2" href="#product_<?=$my_req_id;?>" aria-expanded="true" aria-controls="product_<?=$my_req_id;?>">
                                                <span class="float-md-left">Request ID : <?=$my_req_id;?></span><span class=""> To : <?=$my_req_to;?></span><span class="float-md-right">Date: <?=date("d-m-Y",strtotime($my_dist_req['request_time']));?></span>
                                            </a>
                                        </h5>
                                    </div>

                                    <div id="product_<?=$my_req_id;?>" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="card-block">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>S.No.</th>
                                                    <th>Product ID</th>
                                                    <th>Product Quantity</th>
                                                    <th>Authority Requested</th>
                                                </tr>
                                                <?php
                                                while ($my_row=$my_res->fetch_assoc()):
                                                    ?>
                                                    <tr>
                                                        <td><?=++$i;?></td>
                                                        <td><?=$my_row['product_id'];?></td>
                                                        <td><?=$my_row['product_qty'];?></td>
                                                        <td><?=$my_row['request_to'];?></td>
                                                    </tr>
                                                    <?php
                                                endwhile;
                                                ?>
                                            </table>
                                        </div>
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
    </div>
</div>
</body>
</html>
