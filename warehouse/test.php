<?php
$db=mysqli_connect("localhost","root","123456","snt");
echo $sql11="SELECT wp_id FROM warehouse_product";
$query=mysqli_query($db,$sql11);
while($row=mysqli_fetch_assoc($query)){
    $wp_id=$row['wp_id'];
    echo $sql1="INSERT INTO warehouse_stock(wp_id,wm_id,availability) VALUES ('$wp_id','wm001','10')";
    mysqli_query($db,$sql1);
}
?>
