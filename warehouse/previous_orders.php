<?php
session_start();
include "../include/dbController.php";
$whm = new WHM();

$result=$whm->viewWHM($_SESSION['wm_id']);
$sessionWarehouseUser=$result->fetch_assoc();

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
        }

        @media print{
                 *{
                     padding:0mm;
                     margin:0mm;
                 }      /* Size in inches */
            @page {
                size: 297mm 210mm;
            }
            body,.container,.title{
                padding:0mm 10mm;
                width:250mm;
            }

            .page_no{
                width: 250mm;
                text-align: right;
                padding:10px 0px;
                background-color: yellow;
                overflow:hidden;
            }
            .page_no strong{
                float:right;
            }
            #daily_stock_table{
                margin:0mm;!important;
                padding:0mm;
                width:250mm;
                page-break-after: always;
            }
        }
    </style>
    <script>
        $(document).ready(function(){
            <?php if(isset($_GET['t_type'])):
            $t_type=$_GET['t_type'];
            ?>

            $("<?="#".$t_type;?>").attr("class","btn rounded-0 btn-secondary");

            <?php
            else: ?>
            $("#all").attr("class","btn rounded-0 btn-secondary");
            <?php endif; ?>
        });
    </script>
</head>
<body>
<?php include "include/header.php"; ?>
<!--<div class="jumbotron text-center">
    <h1>Welcome to the Warehouse Management</h1>
</div>-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-sm-4 left-menu-box hidden-print">
            <?php include "./include/left_menu.php"; ?>
        </div>
        <div class="col-lg-9 col-sm-8 content-box">
            <div class="hidden-print container">
                <div class="row">
                    <div class="btn-group btn-breadcrumb">
                        <a href="index.php" class="btn btn-classic"><i class="fa fa-home" style="font-size:28px;"></i></a>
                        <a href="#" class="btn btn-classic">Previous Orders</a>
                    </div>
                </div>
            </div>
            <div class="main_container text-center">
                <div class="hidden-print">
                    <div class="text-left">
                        <form action="<?=$_SERVER['PHP_SELF'];?>" class="d-inline-block">
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchFor" placeholder="Search Product ID">
                                <span class="input-group-btn">
                                <button type="submit" class="btn btn-classic">Search</button>
                            </span>
                                <span class="input-group-btn">
                                 <a href="<?=$_SERVER['PHP_SELF'];?>" class="btn btn-warning">All Result</a>
                             </span>
                            </div>
                            <input type="hidden" name="records_per_page" value="<?=(isset($_GET['records_per_page']))?$_GET['records_per_page']:1;?>">
                        </form>
                        <form action="" id="records_limit" class="float-md-right d-inline-block">
                            <div class="input-group">
                                <label class="input-group-addon" for="">Records per Page</label>
                                <select class="form-control" name="records_per_page" id="records_per_page" onchange="$('#records_limit').submit();">
                                    <?php for($i=1;$i<15;$i++): ?>
                                        <option value="<?=$i;?>"<?php if(isset($_GET['records_per_page']) and $_GET['records_per_page']==$i) echo "SELECTED";?> ><?=$i;?></option>
                                        <?php
                                    endfor;
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" <?php if(isset($_GET['searchFor']))echo "name='searchFor' value='".$_GET['searchFor']."'";?>>
                        </form>
                    </div>
                </div>
                <div class="hidden-print text-right pb-1 pt-1">
                    <button class="btn-secondary btn btn-sm text-right" onclick="window.print();"><i class="fa fa-print"></i> Print Result</button>
                </div>
                <?php include "include/print_page_header.php" ?>
                <div class=""id="print_section">
                    <div class="text-left alert alert-success pb-1 pt-1"><?php
                    $stock=new Stock();
                    if(isset($_GET['searchFor'])):
                        $str=$_GET['searchFor'];
                        echo "Result for : ".$str;
                        $result=$stock->daily_stock_view($_GET['searchFor']);
                    else:
                        echo "All Results";
                        $result=$stock->daily_stock_view();
                    endif;?>
                    </div>
                    <?php
                    if(mysqli_num_rows($result)>0): ?>
                        <table class="table-sm table table-bordered" width="100%" id="daily_stock_table">
                            <tr class="alert-warning">
                                <th>S.No.</th>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Product Description</th>
                                <th>Received</th>
                                <th>Issued</th>
                                <th>Date</th>
                                <th>Balance</th>
                            </tr> <!--<TH>Table Headers</TH>-->
                            <?php
                            if(isset($_GET['records_per_page']) && $_GET['records_per_page']>0)
                                $limit=$_GET['records_per_page'];
                            else
                                $limit=10;
                            $i=0;
                            while($res=$result->fetch_assoc()):

                                ?>
                                <?php if($i%$limit==0 and $i!=0): ?><!--For $limit rows per page -->
                                <?php if($i<=$limit): ?>
                                    <div class="page_no text-left"><p><strong>Page No :<?=ceil($i/$limit);?></strong></p></div>
                                <?php endif; ?>
                                </table>

                                <?php include "include/print_page_header.php" ?>

                                <table class='table table-sm table-bordered' width='100%' id="daily_stock_table">

                                        <tr class="alert-warning">
                                            <th>S.No.</th>
                                            <th>Product ID</th>
                                            <th>Product Name</th>
                                            <th>Product Description</th>
                                            <th>Received</th>
                                            <th>Issued</th>
                                            <th>Date</th>
                                            <th>Balance</th>
                                        </tr> <!--<TH>Table Headers</TH>-->
                                        <tr>
                                            <td><?=++$i;?></td>
                                            <td><?=$res['product_id'];?></td>
                                            <td><?=$res['wp_name'];?></td>
                                            <td><?=$res['wp_description'];?></td>
                                            <td><?php if($res['product_qty']>0) echo $res['product_qty']; else echo "-";?></td>
                                            <td><?php if($res['product_qty']<0) echo abs($res['product_qty']); else echo "-";?></td>
                                            <td><?=$res['date'];?></td>
                                            <td><?=$res['bal'];?></td>
                                        </tr> <!--<TD>Table Data</TD>-->
                                        <div class="page_no text-left"><p><strong>Page No :<?=ceil($i/$limit);?></strong></p></div>

                                        <?php else: ?>
                                        <tr>
                                            <td><?=++$i;?></td>
                                            <td><?=$res['product_id'];?></td>
                                            <td><?=$res['wp_name'];?></td>
                                            <td><?=$res['wp_description'];?></td>
                                            <td><?php if($res['product_qty']>0) echo $res['product_qty']; else echo "-";?></td>
                                            <td><?php if($res['product_qty']<0) echo abs($res['product_qty']); else echo "-";?></td>
                                            <td><?=$res['date'];?></td>
                                            <td><?=$res['bal'];?></td>
                                        </tr> <!--<TD>Table Data</TD>-->

                                        <?php endif; ?>
                                <?php
                            endwhile;
                            ?>
                        </table>
                        <?php
                    else:
                        echo "no result found";
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>