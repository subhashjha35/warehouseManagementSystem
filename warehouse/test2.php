<?php
error_reporting(-1); // reports all errors
ini_set("display_errors", "1"); // shows all errors
ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
    $db=mysqli_connect("localhost","root","123456","snt");
    echo $sql12="SELECT count(id) FROM warehouse_product where wp_id IS NULL and wp_category='consumable'";
    $query=mysqli_query($db,$sql12);echo "<br>";
    if($row=mysqli_fetch_row($query)){
        while($count=$row[0]) {
            echo $sql = "SELECT FLOOR(RAND() * 99999999) AS random_num FROM warehouse_product
              WHERE \"random_num\" NOT IN (SELECT wp_id FROM warehouse_product WHERE wp_id IS NOT NULL) LIMIT 1";
            $result = mysqli_query($db, $sql);
            $num = mysqli_fetch_row($result);
            echo $new_num = sprintf("%08s", $num[0]);
            echo $sql = "Update warehouse_product SET wp_id=UPPER(CONCAT(LEFT(wp_category,3),'$new_num')) WHERE wp_id IS NULL LIMIT 1";
            mysqli_query($db, $sql);
            $count-=1;
        }
    }
?>

<!--SELECT FLOOR(RAND() * 99999) AS random_num
FROM warehouse_product
WHERE "random_num" NOT IN (SELECT wp_id FROM warehouse_product WHERE wp_id IS NOT NULL)
LIMIT 1
-->