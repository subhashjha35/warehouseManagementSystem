<?php
session_start();
include "../include/dbController.php";
$whm = new WHM();

$result=$whm->viewWHM($_SESSION['wm_id']);
$sessionWarehouseUser=mysqli_fetch_assoc($result);
if(isset($_POST['product'])){
    /* print_r($_POST);
     $id_arr=array();
     $qty_arr=array();
     echo "next line \t";
     $id_arr=$_POST['product']['product_id'];
     $qty_arr=$_POST['product']['product_qty'];
     $req_id=$_POST['request_id'];
     $warehouse_id=$_POST['warehouse_id'];
     print_r($id_arr);*/
    $res=$whm->createRequest($_POST);
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
            $("#add_btn").on("click",function(){
                var a=document.createElement("div");
                a.setAttribute('class','form-group-sm');
                a.setAttribute('id','products_info_block');
                $("#products_request_form").append(a);
                var b1=document.createElement("Label");
                b1.setAttribute('for','product_id');
                b1.setAttribute('class','p-1');
                b1.innerHTML="Product ID : ";
                a.append(b1);
                var b2=document.createElement("input");
                b2.setAttribute('type','text');
                b2.setAttribute('class','form-control p-1 col-md-2 d-inline');
                b2.setAttribute('name','product[product_id][]');
                b2.setAttribute('onkeyup','search_product(this)');
                a.append(b2);
                var c1=document.createElement("Label");
                c1.setAttribute('for','product_id');
                c1.setAttribute('class','p-1');
                c1.innerHTML="Product Qty : ";
                a.append(c1);
                var c2=document.createElement("input");
                c2.setAttribute('type','number');
                c2.setAttribute('class','form-control p-1 col-md-1 d-inline');
                c2.setAttribute('name','product[product_qty][]');
                a.append(c2);
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
                        <a href="#" class="btn btn-classic">Request Products</a>
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
                <h3>Request Products from different Warehouses</h3>
                <form method="post" action="<?=$_SERVER['PHP_SELF'];?>" id="products_request_form">
                    <div class="form-group-sm" class="d-inline col-md-3">
                        <label for="transaction_id" class="p-1">Request ID:</label>
                        <input type="text" class="form-control p-1 col-md-2 d-inline" name="request_id" id="request_id" value="CLI<?=strtotime("now");?>">
                        <label for="warehouse_id" class="p-1">Warehouse ID :</label>
                        <input type="text" class="form-control p-1 col-md-2 d-inline"name="warehouse_id" id="warehouse_id">
                    </div>
                    <hr>
                    <button type="submit" class="float-md-right btn btn-success">Complete the Request</button>
                </form>
                <div class="form-group">
                    <button type="button" class="btn btn-info btn-sm" id="add_btn"><i class="fa fa-plus"></i> Products</button>
                </div>
            </div>
        </div>
    </div>

</div>  <span class="fa fa-map-signs"
</body>
</html>
