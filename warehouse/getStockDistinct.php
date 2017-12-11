<?php
    include "../include/dbController.php";
    session_start();
    $stock=new Stock();
    $arr=array();
    $get_distinct_stock=$stock->viewDistinctCat();
    while($row=mysqli_fetch_assoc($get_distinct_stock))
        $arr[]=$row;
    echo($result=json_encode($arr));

?>