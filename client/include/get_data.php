<?php
    session_start();
    include "../../include/dbController.php";
    $pro=new WarehouseProduct();
    $dtr=new DTR();
    if(isset($_GET['product_id'])):
        $pro_id=$_GET['product_id'];
        $res=$pro->viewProduct(['wp_id'=>$pro_id]);
        if($pro_data=$res->fetch_assoc()): ?>
            <div class="alert alert-success pt-1 pb-1"><?=substr($pro_data['wp_description'],0,120);?></div>
        <?php else: ?>
            <div class="alert alert-warning pt-1 pb-1">
                <a href="./product_registration.php?wp_id=<?=$pro_id;?>" class="alert-link">Register this Product</a></div>
        <?php
        endif;
    elseif(isset($_GET['transaction_id'])):
        $val=$_GET['transaction_id'];
        $res=$dtr->countTransaction(["transaction_id"=>$val]);
        ?>
        <div class="alert alert-success pt-1 pb-1"><?=$res;?> Products added</div>
<?php
    elseif(isset($_GET['trans_qty'])):
        $t_q=$_GET['trans_qty'];
        $wp_id=$_GET['wp_id'];
        $stock=new Stock();
        $res=$stock->showAvailability($wp_id);
        $row=$res->fetch_assoc();
        echo $row['availability']." in Stock";
    endif;
?>