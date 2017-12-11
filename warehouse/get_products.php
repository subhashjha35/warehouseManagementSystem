<?php
include "../include/dbController.php";
$product=new WarehouseProduct();
/*print_r($product);*/

if(isset($_GET['search_key'])):
    $search_key=$_GET['search_key'];
    $search_res=$product->viewWP($search_key);
else:
    $search_res=$product->viewWP();
endif;

/*print_r($search_res);*/

if(mysqli_num_rows($search_res)>0):
    ?>
    <table class="table table-bordered table-striped">
        <tr class="">
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Description</th>
            <th>Product Category</th>
            <th>Time Of Entry</th>
            <th>Action</th>
        </tr>
        <?php
        while($row=mysqli_fetch_assoc($search_res)):
            ?>
            <tr>
                <td><?=$row['wp_id'];?></td>
                <td><?=$row['wp_name'];?></td>
                <td><?=$row['wp_description'];?></td>
                <td><?=$row['wp_category'];?></td>
                <td><?=$row['time_of_entry'];?></td>
                <td><a class="btn btn-danger btn-sm" href="?wp_id=<?=$row['wp_id'];?>"><i class="fa fa-edit"></i> Edit</a></td>
            </tr>
            <?php
        endwhile;
        ?>
    </table>
<?php
else:
    ?>
    <div class="alert alert-warning alert-dismissible">Sorry! No result found. <a href="#" class="close" data-dismiss="alert"><span class="fa fa-close"></span></a></div>
<?php

endif; ?>


