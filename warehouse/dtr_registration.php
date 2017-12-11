<?php
session_start();
include "../include/dbController.php";
$whm = new WHM();

$result=$whm->viewWHM($_SESSION['wm_id']);
$sessionWarehouseUser=mysqli_fetch_assoc($result);

$dtr=new DTR();
if(isset($_POST['in_transaction'])):
    /*echo "incoming_transaction started";*/
    $dtr->addDTR($_POST);

elseif(isset($_POST['out_transaction'])):
    $dtr->subtractDTR($_POST);
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
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">
    <script type="text/javascript">
        $(document).ready(function(){
           $("#incoming_dtr_form #product_id").on('change',function(){
               $str=$(this).val();
               $.get("./include/get_data.php",{product_id:$str},function($data){
                   $("#incoming_dtr_form #product_status").html($data);

               });
           });
            $("#incoming_dtr_form #transaction_id").on('change',function(){
                $str=$("#incoming_dtr_form #transaction_id").val();
                $.get("./include/get_data.php",{transaction_id:$str},function($data){
                    $("#incoming_dtr_form #transaction_status").html($data);
                });
            });

            $("#outgoing_dtr_form #product_id").on('change',function(){
                $str=$(this).val();
                $.get("./include/get_data.php",{product_id:$str},function($data){
                    $("#outgoing_dtr_form #product_status").html($data);

                });
                $t_qty=$("#outgoing_dtr_form #transaction_qty").val();
                $.get("./include/get_data.php",{trans_qty:$t_qty,wp_id:$str},function($data){
                    $("#outgoing_dtr_form #trans_qty_status").html($data);
                    $num = $data.match(/\d+/);
                    $("#outgoing_dtr_form #transaction_qty").attr({
                        "max" :$num,        // substitute your own
                        "min" : 0          // values (or variables) here
                    });
                });
            });
            $("#outgoing_dtr_form #transaction_id").on('change',function(){
                $str=$(this).val();
                $.get("./include/get_data.php",{transaction_id:$str},function($data){
                    $("#outgoing_dtr_form #transaction_status").html($data);
                });
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
    </style>
</head>
<body>
<?php include "include/header.php"; ?>
<!--<div class="jumbotron text-center">
    <h1>Welcome to the Warehouse Management</h1>
</div>-->
<input type="hidden" id="session_wm_id" val="<?=$_SESSION['wm_id'];?>">
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
                        <a href="#" class="btn btn-classic">DTR Registration</a>
                    </div>
                </div>
            </div>
            <div class="main_container">
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-classic rounded-0 rounded-top" data-toggle="collapse" href="#incoming_dtr_form" aria-expanded="false" aria-controls="collapseExample">Incomming DTR</a>
                        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="p-md-3 collapse table-bordered" id="incoming_dtr_form">
                            <input type="hidden"name="in_transaction">
                            <input type="hidden"name="t_type" value="in">
                            <div class="form-group">
                                <label for="transaction_id">Transaction ID:</label>
                                <input class="form-control" type="text" name="transaction_id" id="transaction_id">
                                <div class="" id="transaction_status"></div>
                            </div>
                            <div class="form-group">
                                <label for="product_id">Product ID:</label>
                                <input required class="form-control" type="text" name="product_id" id="product_id">
                                <div class="" id="product_status"></div>
                            </div>
                            <div class="form-group">
                                <label for="transaction_qty">Transaction Quantity:</label>
                                <input class="form-control" type="number" value="0" min="0" name="transaction_quantity" id="transaction_qty">
                            </div>
                            <div class="form-group">
                                <label for="transaction_to_from">Transaction From:</label>
                                <input class="form-control" type="text" name="transaction_to_from" id="transaction_to_from">
                            </div>
                            <div class="form-group">
                                <label for="lrap">Ledger Reference and Page:</label>
                                <input class="form-control" type="text" name="ledger_reference_and_page" id="lrap">
                            </div>
                            <div class="form-group">
                                <label for="crnad">Challan Receipt No. and Date:</label>
                                <input class="form-control" type="text" name="challan_receipt_no_and_date" id="crnad">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-classic" type="submit">Submit Incomming Transaction</button> <button type="reset" class="btn btn-secondary">Clear Fields</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-warning rounded-0" data-toggle="collapse" href="#outgoing_dtr_form" aria-expanded="false" aria-controls="collapseExample">Outgoing DTR</a>
                        <form method="post" action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>" class="p-md-3 collapse table-bordered" id="outgoing_dtr_form">
                            <input type="hidden" name="out_transaction">
                            <input type="hidden"name="t_type" value="out">
                            <div class="form-group">
                                <label for="transaction_id">Transaction ID:</label>
                                <input class="form-control" type="text" name="transaction_id" id="transaction_id">
                                <div class="" id="transaction_status"></div>
                            </div>
                            <div class="form-group">
                                <label for="product_id">Product ID:</label>
                                <input required class="form-control" type="text" name="product_id" id="product_id">
                                <div class="" id="product_status"></div>
                            </div>
                            <div class="form-group">
                                <label for="transaction_qty">Transaction Quantity:</label>
                                <input required class="form-control" type="number" min="0" value="0" name="transaction_quantity" id="transaction_qty">
                                <div class="" id="trans_qty_status"></div>
                            </div>
                            <div class="form-group">
                                <label for="transaction_to_from">Transaction to:</label>
                                <input required class="form-control" type="text" name="transaction_to_from" id="transaction_to_from">
                            </div>
                            <div class="form-group">
                                <label for="lrap">Ledger Reference and Page:</label>
                                <input class="form-control" type="text" name="ledger_reference_and_page" id="lrap">
                            </div>
                            <div class="form-group">
                                <label for="crnad">Challan Receipt No. and Date:</label>
                                <input class="form-control" type="text" name="challan_receipt_no_and_date" id="crnad">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-classic" type="submit">Submit Outgoing Transaction</button> <button type="reset" class="btn btn-secondary">Clear Fields</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
