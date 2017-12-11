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
    <style type="text/css">

        @media screen and (min-width: 768px){
            .left-menu-box{
                padding-bottom:99999px;!important;
                margin-bottom:-99999px;!important;
                overflow:hidden;
            }
        }
        .content-box{
            padding-top:10px;
        }
        #stock_categories_box .col-md-3{
            padding:10px;
        }
        #stock_categories_box .col-md-3 div{
            /*background-color: #1c94c4;*/
            padding:20px;
            border-radius: 5px;
        }
        #stock_categories_box .col-md-3 div a{
            color:rgba(226,226,226,0.99);
        }
        #stock_categories_box .col-md-3 div a:hover{
            color:#fff;
            text-decoration: none;
        }
        #count_tag{
            position:absolute;
            right:0px;
            top:0px;
            background:radial-gradient(#4085ae 50%, #fff 80%,#4085ae 100%);
            border-radius:25px;
            height:40px;
            width:40px;
            text-align: center;
            padding-top:8px;
            font-weight:bold;
        }
        #stock_categories_box > .col-md-3{
            position:relative;
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
                        <a<?php if(isset($_GET['product_category'])) echo " href='stock_details.php'"; ?> class="btn btn-classic">Stock Details</a>
                        <?php if(isset($_GET['product_category'])):?><a class="btn btn-classic"href="#"><?php echo ucwords(str_replace("_"," ",$_GET['product_category']))."</a>"; endif;?>
                    </div>
                </div>
            </div>
            <div class="main_container">
                <?php
                    $stock=new Stock();
                    $count_each_cat=$stock->viewDistinctCat();
                    $count_arr=Array();
                    while($row_count=$count_each_cat->fetch_assoc()){
                        $key=$row_count['wp_category'];
                        $value=$row_count['count'];
                        $count_arr["$key"] = $value;
                    }
                    /*print_r($count_arr);*/
                    if(isset($_GET['product_category'])):
                        $cat=$_GET['product_category'];
                        $result=$stock->viewStock($cat);

                        if(mysqli_num_rows($result)>0):
                            $i=0;
                            ?>
                            <strong><?=mysqli_num_rows($result);?> Record(s) found</strong>
                            <table class="table table-bordered table-striped alert-info">
                                <tr>
                                    <th>S.No.</th>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Product Description</th>
                                    <th>Quantity</th>
                                </tr>
                                <?php
                                while($row=mysqli_fetch_assoc($result)):

                                    ?>
                                    <tr>
                                        <td><?=++$i;?></td>
                                        <td><?=$row['wp_id'];?></td>
                                        <td><?=$row['wp_name'];?></td>
                                        <td><?=$row['wp_description'];?></td>
                                        <td><?=$row['availability']." ".$row['wp_unit'];?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>
                            <?php
                        else:
                            ?>
                        <div class="alert alert-danger">No records Found for the Category - <?=$cat;?></div>
                            <?php
                        endif;
                ?>

                <?php
                    else:
                ?>
                    <div class="row" id="stock_categories_box">
                                <div class="col-md-3">
                                    <div class="text-center bg-info">
                                        <a href="?product_category=Electrical">
                                            <i id="count_tag"><?=(isset($count_arr["electrical"]))?$count_arr["electrical"]:0;?></i>
                                            <div class="fa fa-bolt fa-2x"></div>
                                            <h5>Electrical</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center bg-info">
                                        <a href="?product_category=tnp">
                                            <i id="count_tag"><?=(isset($count_arr["tnp"]))?$count_arr["tnp"]:0;?></i>
                                            <div class="fa fa-bell fa-2x"></div>
                                            <h5>T & P</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center bg-info">
                                        <a href="?product_category=scrap">
                                            <i id="count_tag"><?=(isset($count_arr["scrap"]))?$count_arr["scrap"]:0;?></i>
                                            <div class="fa fa-trash-o fa-2x"></div>
                                            <h5>Scrap</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center bg-info">
                                        <a href="?product_category=local_purchase">
                                            <i id="count_tag"><?=(isset($count_arr["local_purchase"]))?$count_arr["local_purchase"]:0;?></i>
                                            <div class="fa fa-bell fa-2x"></div>
                                            <h5>Local Purchase</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center bg-info">
                                        <a href="?product_category=Mechanical">
                                            <i id="count_tag"><?=(isset($count_arr["mechanical"]))?$count_arr["mechanical"]:0;?></i>
                                            <div class="fa fa-cog fa-2x"></div>
                                            <h5>Mechanical</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center bg-info">
                                        <a href="?product_category=dead_stock">
                                            <i id="count_tag"><?=(isset($count_arr["dead_stock"]))?$count_arr["dead_stock"]:0;?></i>
                                            <div class="fa fa-bell fa-2x"></div>
                                            <h5>Dead Stock</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center bg-info">
                                        <a href="?product_category=works">
                                            <i id="count_tag"><?=(isset($count_arr["works"]))?$count_arr["works"]:0;?></i>
                                            <div class="fa fa-bell fa-2x"></div>
                                            <h5>Works</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center bg-info">
                                        <a href="?product_category=Consumable">
                                            <i id="count_tag"><?=(isset($count_arr["consumable"]))?$count_arr["consumable"]:0;?></i>
                                            <div class="fa fa-bell fa-2x"></div>
                                            <h5>Consumable</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                <?php
                    endif;
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
