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


    <script>
            function search_res(){
                $str=$("#search_key").val();
                /*alert($str);*/
                $.get("get_products.php",{search_key:$str},function($data){
                    $("#search_result").html($data);
                });
            }
            $(document).ready(function(){
               search_res();
               $(window).scroll(function(){
                  if($(window).scrollTop()==$(document).height()-$(window).height()){
                      
                  }
               });
            });
    </script>
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

        <div class="col-lg-3 col-sm-4 left-menu-box">
            <?php include "./include/left_menu.php"; ?>
        </div>
        <div class="col-lg-9 col-sm-8 content-box">
            <div class="container">
                <div class="row">
                    <div class="btn-group btn-breadcrumb">
                        <a href="index.php" class="btn btn-classic"><i class="fa fa-home" style="font-size:28px;"></i></a>
                        <a href="#" class="btn btn-classic">View Products</a>
                    </div>
                </div>
            </div>
            <div class="main_container">
                <?php
                    if(isset($_POST['submit_change'])):
                        /*$wp_id=$_POST['wp_id'];*/
                        $wp_name=$_POST['wp_name'];
                        $wp_description=$_POST['wp_description'];
                        $wp_category=$_POST['wp_category'];
                        $data=array('wp_name'=>$wp_name,'wp_description'=>$wp_description,'wp_category'=>$wp_category);
                        $pro=new WarehouseProduct();
                        $res=$pro->updateWP($data,$_POST['product_id']);
                        if(!$res>0): ?>
                        <div class="alert alert-danger alert-dismissible">No row updated <a href="#" class="close" data-dismiss="alert"><i class="fa fa-times"></i></a></div>
                <?php
                        endif;
                    endif;
                ?>
                <div class="form-group">
                    <label for="search_key"><strong>Instant Filter/Search the records</strong></label><br>
                    <div class="input-group">
                        <input type="text" class="form-control" name="search_key" id="search_key" onkeyup="search_res()">
                        <div class="input-group-addon btn-classic">
                            <a class="" onclick="search_res()"><i class="fa fa-search"></i> Search</a>
                        </div>
                    </div>
                </div>
                <div id="search_result">

                </div>

            </div>
        </div>
    </div>
</div>
<?php if(isset($_GET['wp_id'])):
    $wp_id=$_GET['wp_id'];
    $pro=new WarehouseProduct();
    $res=$pro->viewWP($wp_id)->fetch_assoc();
    ?>

<div class="modal" id="edit_product_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Product Details</h2>
            </div>
            <div class="modal-body">
                <form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
                    <div class="form-group">
                        <label for="">Product ID:</label>
                        <input type="text" class="form-control" value="<?=$res['wp_id'];?>" readonly name="product_id">
                        <input type="hidden" name="product_id" value="<?=$_GET['wp_id'];?>">
                    </div>
                    <div class="form-group">
                        <label for="">Product Name:</label>
                        <input type="text" class="form-control" value="<?=$res['wp_name'];?>" name="wp_name">
                    </div>
                    <div class="form-group">
                        <label for="">Product Description:</label>
                        <textarea class="form-control" name="wp_description"><?=$res['wp_description'];?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Product ID:</label>
                        <select type="text" class="form-control" name="wp_category">
                            <?php
                                $arr=array('Electrical','scrap','local_purchase','tnp','Mechanical','Consumable','works','dead_stock');
                                foreach ($arr as $val):
                                ?>
                            <option value="<?=$val;?>"<?php if($val==$res['wp_category']) echo "selected";?>><?=ucwords(str_replace("_"," ",$val));?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <input type="hidden"name="submit_change">
                    <div class="form-group">
                        <button class="btn btn-classic" type="submit">Submit the Changes</button>
                        <button class="btn btn-secondary" type="reset">Clear Fields</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <script>
        $("#edit_product_modal").modal('show');
    </script>
    <?php
endif;
?>
</body>
</html>
