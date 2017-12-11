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
    <style type="text/css">
        @media screen and (min-width: 768px){
            .left-menu-box{
                padding-bottom:999defg99px;!important;
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
            body,.container,.title,.main_container{
                padding:0mm 0mm;
                width:280mm;
            }

            .page_no{
                width: 270mm;
                text-align: right;
                padding:10px 0px;
                background-color: yellow;
                overflow:hidden;
            }
            .page_no strong{
                float:right;
            }
            #daily_transaction_table{
                margin:0mm;!important;
                padding:0mm;
                width:270mm;
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
            <div class="container hidden-print">
                <div class="row">
                    <div class="btn-group btn-breadcrumb">
                        <a href="index.php" class="btn btn-classic"><i class="fa fa-home" style="font-size:28px;"></i></a>
                        <a href="#" class="btn btn-classic">View DTR</a>
                    </div>
                </div>
            </div>
            <div class="main_container text-center" style="overflow-x: scroll;">
                <div class="container">
                    <a href="<?=$_SERVER['PHP_SELF'];?><?=(isset($_GET['records_per_page']))?"?records_per_page=".$_GET['records_per_page']:null;?>" id="all" class="rounded-0 btn btn-classic">All</a>
                    <a href='?t_type=in<?=(isset($_GET['records_per_page']))?"&records_per_page=".$_GET['records_per_page']:null;?><?=(isset($_GET['start_date']))?'&start_date='.$_GET['start_date']:null;?><?=(isset($_GET['end_date']))?'&end_date='.$_GET['end_date']:null;?>' class="rounded-0 btn btn-classic" id="in">Incoming</a>
                    <a href='?t_type=out<?=(isset($_GET['records_per_page']))?"&records_per_page=".$_GET['records_per_page']:null;?><?=(isset($_GET['start_date']))?'&start_date='.$_GET['start_date']:null;?><?=(isset($_GET['end_date']))?'&end_date='.$_GET['end_date']:null;?>' class="rounded-0 btn btn-classic" id="out">Outgoing</a>
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
                        <input type="hidden" <?php if(isset($_GET['t_type']))echo "name='t_type' value='".$_GET['t_type']."'";?>>
                    </form>
                </div>
                <form action="" class="float-md-right mt-1 mb-1 form-inline">
                    <div class="form-group">
                        <label for="start_date" class="col-md-4">From :</label>
                        <input type="date" name="start_date" class="col-md-8 form-control p-0" value="<?=(isset($_GET['start_date']))?$_GET['start_date']:null;?>">
                    </div>
                    <div class="form-group">
                        <label for="end_date" class="col-md-4">Till :</label>
                        <input type="date" name="end_date" class="col-md-8 form-control p-0"value="<?=(isset($_GET['end_date']))?$_GET['end_date']:null;?>">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-classic"><i class="fa fa-search"></i></button>
                    </div>
                    <input type="hidden" <?php if(isset($_GET['t_type']))echo "name='t_type' value='".$_GET['t_type']."'";?>>
                    <input type="hidden" <?php if(isset($_GET['records_per_page']))echo "name='records_per_page' value='".$_GET['records_per_page']."'";?>>
                </form>

                <?php
                    $dtr=new DTR();
                    if(isset($_GET['t_type']))
                        $result=$dtr->viewDTR(['transaction_type'=>$_GET['t_type']]);
                    elseif(isset($_GET['start_date']))
                        $result=$dtr->viewDTR(['start_date'=>$_GET['start_date'],'end_date'=>$_GET['end_date']]);
                    else
                        $result=$dtr->viewDTR();
                    if(mysqli_num_rows($result)>0): ?>
                <table class="table table-bordered" id="daily_transaction_table">
                    <tr class="alert-success">
                        <th>Product ID</th>
                        <th>Trans. ID</th>
                        <th>Trans. Qty</th>
                        <th>Trans. To</th>
                        <th>Trans. From</th>
                        <th>Ledger Refer and Page</th>
                        <th>Trans. Type</th>
                        <th>Challan Receipt No and Date</th>
                        <th>Date</th>
                    </tr>
                    <?php
                    if(isset($_GET['records_per_page']))
                        $limit=$_GET['records_per_page'];
                    else
                        $limit=4;
                    $i=0;
                    while($res=mysqli_fetch_assoc($result)):
                    if($i%$limit==0 and $i!=0): /*For $limit rows per page*/
                        if($i<=$limit):
                    ?>
                    <div class="page_no text-left"><p><strong>Page No :<?=ceil($i/$limit);?></strong></p></div>
                        <?php endif;?>
            </table>
            <table class='table table-sm table-bordered' width='100%' id="daily_transaction_table">
                <tr class="alert-warning">
                    <th>Product ID</th>
                    <th>Trans. ID</th>
                    <th>Trans. Qty</th>
                    <th>Trans. To</th>
                    <th>Trans. From</th>
                    <th>Ledger Reference and Page</th>
                    <th>Trans. Type</th>
                    <th>Challan Receipt No and Date</th>
                    <th>Date</th>
                </tr>
                    <tr><?php $i++;?>
                    <td><?=$res['product_id'];?></td>
                    <td><?=$res['transaction_id'];?></td>
                    <td><?=$res['transaction_quantity'];?></td>
                    <td><?=$res['transaction_to'];?></td>
                    <td><?=$res['transaction_from'];?></td>
                    <td><?=$res['ledger_reference_and_page'];?></td>
                    <td><?=$res['transaction_type'];?></td>
                    <td><?=$res['challan_receipt_no_and_date'];?></td>
                    <td><?=$res['date'];?></td>
                </tr>
                <div class="page_no text-left"><p><strong>Page No :<?=ceil($i/$limit);?></strong></p></div>

                    <?php else: ?>
                <tr><?php $i++;?>
                    <td><?=$res['product_id'];?></td>
                    <td><?=$res['transaction_id'];?></td>
                    <td><?=$res['transaction_quantity'];?></td>
                    <td><?=$res['transaction_to'];?></td>
                    <td><?=$res['transaction_from'];?></td>
                    <td><?=$res['ledger_reference_and_page'];?></td>
                    <td><?=$res['transaction_type'];?></td>
                    <td><?=$res['challan_receipt_no_and_date'];?></td>
                    <td><?=$res['date'];?></td>
                </tr>

                <?php
                    endif;
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
</body>
</html>
