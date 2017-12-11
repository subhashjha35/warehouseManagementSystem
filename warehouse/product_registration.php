<?php
session_start();
include "../include/dbController.php";
$whm = new WHM();

$result=$whm->viewWHM($_SESSION['wm_id']);
$sessionWarehouseUser=mysqli_fetch_assoc($result);

if(isset($_POST['product_registration'])):
    $wp_id=$_POST['wp_id'];
    $wp_name=$_POST['wp_name'];
    $wp_description=$_POST['wp_description'];
    $wp_category=$_POST['wp_category'];

    $product=new WarehouseProduct();
    $recordInsertion=$product->insertWP($wp_id,$wp_name,$wp_description,$wp_category);

elseif(isset($_GET['wp_id'])):
    $wp_id=$_GET['wp_id'];

endif;
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
            .content-box{
                padding-top:10px;
                padding-bottom:9999px;
                margin-bottom:-9999px;
                overflow:hidden;
            }
        }
        .content-box{
            padding-top:10px;
            background-color: #EEEEEE;
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

        <div class="col-lg-3 col-sm-1 left-menu-box">
            <?php include "./include/left_menu.php"; ?>
        </div>
        <div class="col-lg-9 col-sm-11 content-box">
            <div class="container">
                <div class="row">
                    <div class="btn-group btn-breadcrumb">
                        <a href="index.php" class="btn btn-classic"><i class="fa fa-home" style="font-size:28px;"></i></a>
                        <a href="#" class="btn btn-classic">Product Registration</a>
                    </div>
                </div>
            </div>
            <?php if(isset($recordInsertion)):
                if($recordInsertion>0):?>
            <div class="alert alert-info show fade alert-dismissible">
                <?=$recordInsertion;?> Records Inserted Successfully <a href="#" data-dismiss="alert" class="close" aria-label="Close">&times;</a></div>
            <?php else: ?>
            <div class="alert alert-danger alert-dismissible">Failed to Insert this Record <a href="#" data-dismiss="alert" class="close" aria-label="Close">&times;</a></div>
            <?php endif;endif; ?>
            <div class="main_container">
                <h3>Register New Product</h3>
                <hr>
                <form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
                    <div class="form-group">
                        <label for="product_id">
                            Product ID:
                        </label>
                        <input type="text" name="wp_id" id="product_id" class="form-control" value="<?php if(isset($wp_id))echo $wp_id;?>">
                    </div>
                    <div class="form-group">
                        <label for="product_name">
                            Product Name:
                        </label>
                        <input type="text" name="wp_name" id="product_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="product_desc">
                            Product Description:
                        </label>
                        <input type="text" name="wp_description" id="product_desc" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="product_cat">
                            Product Category:
                        </label>
                        <select name="wp_category" id="product_cat" class="form-control">
                            <option value="electrical">Electrical</option>
                            <option value="tnp">T & P</option>
                            <option value="scrap">Scrap</option>
                            <option value="local_purchase">Local Purchase</option>
                            <option value="mechanical">Mechanical</option>
                            <option value="dead_stock">Dead Stock</option>
                            <option value="works">Works</option>
                            <option value="consumable">Consumable</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-classic">Register Product</button>
                        <button type="reset" class="btn btn-secondary">Clear Fields</button>
                    </div>
                    <input type="hidden" name="product_registration">
                </form>
            </div>
        </div>
    </div>

</div>
</body>
</html>
