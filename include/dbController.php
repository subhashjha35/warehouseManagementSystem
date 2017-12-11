<?php

class Db{
    private $host="localhost";
    private $user="root";
    private $pass="123456";
    private $database="snt";
    private $db;
    function __construct()
    {
        $this->db=new mysqli($this->host,$this->user,$this->pass,$this->database);

    }

    function Dbase(){
        return $this->db;
    }
}

class WHM{
    function __construct()
    {
        $this->Db = new Db();
        $this->Db =$this->Db->Dbase();
    }

    function viewRequest($req_id=null){
        $curr_user=$_SESSION['wm_id'];
        if($req_id==null)
            $sql="SELECT * FROM request_list, product_request where request_list.request_id=product_request.request_id and request_to='$curr_user'";
        else
            $sql="SELECT * FROM request_list, product_request where request_list.request_id=product_request.request_id and request_to='$curr_user' and request_list.request_id='$req_id'";
        return $this->Db->query($sql);
    }

    function viewMyRequest($req_id=null){
        $curr_user=$_SESSION['wm_id'];
        if($req_id==null)
            $sql="SELECT * FROM request_list, product_request where request_list.request_id=product_request.request_id and request_by='$curr_user'";
        else
            $sql="SELECT * FROM request_list, product_request where request_list.request_id=product_request.request_id and request_by='$curr_user' and request_list.request_id='$req_id'";
        return $this->Db->query($sql);
    }
    function createRequest($arr){
        $curr_user=$_SESSION['wm_id'];
        $ware_id=$arr['warehouse_id'];
        $req_id=$arr['request_id'];
        $product_arr=$arr['product'];
        /*print_r($product_arr);*/
        $n=array_sum(array_map("count", $product_arr))/count($product_arr);
        $sql="INSERT INTO `request_list`(`id`, `request_id`, `request_by`, `request_to`, `request_time`) VALUES (0,'$req_id','$curr_user','$ware_id',now())";
        $sql1="INSERT INTO `product_request`(`id`, `request_id`, `product_id`, `product_qty`) VALUES ";
        for($i=0;$i<$n;$i++) {
            $sql1.="(0,'".$req_id."','".$product_arr['product_id'][$i]."',";
            $sql1.="'".$product_arr['product_qty'][$i]."'),";
        }
        $sql1=rtrim($sql1,',');
        $sql."\n".$sql1;
        if($query=$this->Db->query($sql)):
            $this->Db->query($sql1);
            return 1;
        else:
            return 0;
        endif;
    }
    function viewDistinctRequest(){
        $curr_user=$_SESSION['wm_id'];
        $sql="SELECT * FROM request_list WHERE request_to='$curr_user'";
        return $this->Db->query($sql);
    }
    function viewMyDistinctRequest(){
        $curr_user=$_SESSION['wm_id'];
        $sql="SELECT * FROM request_list WHERE request_by='$curr_user'";
        return $this->Db->query($sql);
    }
    public function viewWHM($user=null){
        if($user==null):
            $sql="SELECT * FROM warehouse_manager";
        else:
            $sql="SELECT * FROM warehouse_manager WHERE wm_id='$user'";
        endif;
        return $this->Db->query($sql);
    }

    public function checkWHM($user,$pass){
        $sql="SELECT * FROM warehouse_manager WHERE wm_id='$user' AND wm_pass='$pass'";
        return $this->Db->query($sql);
    }

    public function createWHM($user, $pass){
        $sql="insert into users() values (0,'$')";
        return $this->Db->query($sql);
    }

    public function updateImage($wm_id,$pic_path){
        $sql="UPDATE `warehouse_manager` SET `pic_path`='$pic_path' WHERE `wm_id`='$wm_id'";
        $query=$this->Db->query($sql);
        return mysqli_affected_rows($this->Db);
    }

    public function updateDetails($wm_id,$data){
        $sql="UPDATE `warehouse_manager` SET ";
        foreach($data as $key=>$value):
            $sql.="$key = '$value',";
        endforeach;
        $sql=substr(trim($sql), 0, -1);
        $sql.=" where wm_id='$wm_id'";
        $sql;
        $this->Db->query($sql);
    }

    function countRows(){
        $res=$this->viewWHM();
        return $res->num_rows;
    }
}

class WarehouseProduct{
    function __construct()
    {
        $this->Db = new Db();
        $this->Db =$this->Db->Dbase();
    }

    public function listItems(){
        $sql="SELECT (SELECT ) wp_id,wp_name,wp_description, availability FROM warehouse_product inner join warehouse_stock on warehouse_product.wp_id=stock.wp_id";
    }
    public function viewWP($search_key=null){
        if($search_key==null)
            $sql="SELECT * FROM warehouse_product";
        else
            $sql="SELECT * FROM `warehouse_product` WHERE `wp_id`like '%".$search_key."%' OR `wp_name` like '%".$search_key."%' OR `wp_description` like '%".$search_key."%' OR `wp_category` like '%".$search_key."%'";
        return $this->Db->query($sql);
    }
    public function viewProduct($array){
        $sql="SELECT * FROM `warehouse_product` WHERE ";
        foreach($array as $key=>$val)
            $sql.="$key = '$val'";
        return $this->Db->query($sql);
    }

    public function viewWPDetailed(){
        $sql="SELECT * FROM warehouse_product, warehouse_manager, warehouse_stock where warehouse_product.wp_id=warehouse_stock.wp_id and warehouse_manager.wm_id=warehouse_stock.wm_id";
        return $this->Db->query($sql);
    }


    public function insertWP($wp_id, $wp_name, $wp_description, $wp_category){
        $wp_id=mysqli_real_escape_string($this->Db,htmlspecialchars($_POST['wp_id']));
        $wp_name=mysqli_real_escape_string($this->Db,htmlspecialchars($_POST['wp_name']));
        $wp_description=mysqli_real_escape_string($this->Db,htmlspecialchars($_POST['wp_description']));
        $wp_category=mysqli_real_escape_string($this->Db,htmlspecialchars($_POST['wp_category']));
        $sql="insert into warehouse_product() values ('$wp_id','$wp_name','$wp_description','$wp_category',now())";
        $rs= $this->Db->query($sql);
        return mysqli_affected_rows($this->Db);
    }
    public function updateProductId(){
        $r=0;
        while($r<=10):
            $sql1="SELECT FLOOR(100000 + RAND()* 900000) AS rand_no FROM warehouse_product WHERE 'rand_no' NOT IN (SELECT wp_id FROM warehouse_product) LIMIT 1";
            $u_val=$this->Db->query($sql1)->fetch_array();
            /*$u_val=mysqli_fetch_row($u_val);*/
            $u_val=$u_val[0];
            $s=$r+1;
            $sql="UPDATE warehouse_product SET wp_id='$u_val' WHERE id=$r";
            $this->Db->query($sql);
            $r++;
        endwhile;
    }
    public function batchInsertWP($array){
        $stmt=$this->Db->stmt_init();
        $stmt->prepare("insert into warehouse_product() values ('?','?','?','?',now())");
        foreach($array as $row)
        {
            $stmt->bind_param('idsb', $row['fld1'], $row['fld2'], $row['fld3'], $row['fld4']);
            $stmt->execute();
        }
    }

    public function updateWP($data, $wp_id){
        $sql="UPDATE warehouse_product SET";
        foreach($data as $key => $val):
        $sql.=" $key = '$val',";
        endforeach;
        $sql=substr(trim($sql), 0, -1);
        $sql.="where wp_id='".$wp_id."'";
        $res=$this->Db->query($sql);
        return $this->Db->affected_rows;
    }

    public function countRows(){
        $res=$this->viewWP();
        return $res->num_rows;
    }
}

class Stock{
    private $curr_user;
    function __construct()
    {
        $this->Db = new Db();
        $this->Db =$this->Db->Dbase();
    }

    function viewStock($cat=null){
        if($cat!=null){
            $cat=mysqli_real_escape_string($this->Db,htmlspecialchars($cat));
            $sql="SELECT * FROM warehouse_product, warehouse_manager, warehouse_stock where warehouse_product.wp_id=warehouse_stock.wp_id and warehouse_manager.wm_id=warehouse_stock.wm_id and wp_category='$cat'";
        }
        else{
            $sql="SELECT * FROM warehouse_product, warehouse_manager, warehouse_stock where warehouse_product.wp_id=warehouse_stock.wp_id and warehouse_manager.wm_id=warehouse_stock.wm_id";
        }

        return $this->Db->query($sql);
    }

    function viewDistinctCat(){
        $curr_user=$_SESSION['wm_id'];
        $sql="SELECT wp_category,COUNT(wp_category) AS count FROM warehouse_product, warehouse_stock WHERE warehouse_stock.wp_id=warehouse_product.wp_id and warehouse_stock.wm_id='$curr_user' GROUP BY wp_category";
        return $this->Db->query($sql);
    }
    function showAvailability($pro_id){
        $curr_user=$_SESSION['wm_id'];
        $sql="SELECT warehouse_stock.availability FROM warehouse_product, warehouse_manager, warehouse_stock where warehouse_product.wp_id=warehouse_stock.wp_id and warehouse_manager.wm_id=warehouse_stock.wm_id and warehouse_stock.wp_id='$pro_id' and warehouse_stock.wm_id='$curr_user'";
        return $this->Db->query($sql);
    }

    function addStock($wp_id, $qty){
        $curr_user=$_SESSION['wm_id'];
        $sql="SELECT id FROM warehouse_stock WHERE wp_id='$wp_id' and wm_id='$curr_user'";
        if($this->Db->query($sql)->num_rows >0):
            $query="UPDATE warehouse_stock SET availability=availability+".$qty." where wm_id='$curr_user' and wp_id='$wp_id'";
        else:
            $query="INSERT INTO warehouse_stock VALUES (0,'$wp_id','$curr_user','$qty')";
        endif;
        $this->Db->query($query);

        $sql1="SELECT * FROM warehouse_stock WHERE wp_id='$wp_id' and wm_id='$curr_user'";
        $res=$this->Db->query($sql1);
        var_dump($row=$res->fetch_assoc());
        $this->daily_stock_update($wp_id,$qty,"+",$row['availability']);
    }

    function subtractStock($wp_id,$qty){
        $curr_user=$_SESSION['wm_id'];
        $sql="SELECT id FROM warehouse_stock WHERE wp_id='$wp_id' and wm_id='$curr_user'";
        if($this->Db->query($sql)->num_rows >0):
            $query="UPDATE warehouse_stock SET availability=availability-'$qty' where wm_id='$curr_user' and wp_id='$wp_id'";
            $this->Db->query($query);
            $sql1="SELECT * FROM warehouse_stock WHERE wp_id='$wp_id' and wm_id='$curr_user'";
            $res=$this->Db->query($sql1);
            $row=$res->fetch_assoc();
            $this->daily_stock_update($wp_id,$qty,"-",$row['availability']);
        else:
            return 0;
        endif;
    }

    function countRows(){
        $res=$this->viewStock();
        return $res->num_rows;
    }

    function daily_stock_update($wp_id,$change_qty,$sign,$total_qty){
        $curr_user=$_SESSION['wm_id'];
        $date=new DateTime();
        $sql="INSERT INTO daily_stock_table VALUES(0,'$curr_user','$wp_id','$sign$change_qty','$total_qty',now())";
        $this->Db->query($sql);
    }

    function daily_stock_view($pro_id=null){
        $curr_user=$_SESSION['wm_id'];
        if($pro_id==null)
            $sql="SELECT * FROM daily_stock_table INNER JOIN warehouse_product ON daily_stock_table.product_id=warehouse_product.wp_id and daily_stock_table.wm_id='$curr_user'";
        else
            $sql="SELECT * FROM daily_stock_table INNER JOIN warehouse_product ON daily_stock_table.product_id=warehouse_product.wp_id and daily_stock_table.wm_id='$curr_user' and warehouse_product.wp_id like '%".$pro_id."%'";
        return $this->Db->query($sql);
    }

    function sync_stock($wp_id){
        $curr_user=$_SESSION['wm_id'];
        $sql="SELECT availability from warehouse_stock WHERE wp_id='$wp_id'";
        $res=$this->Db->query($sql);
        $row=$res->fetch_assoc();
        $bal=$row['availability'];
        $sql1="UPDATE daily_stock_table set bal='$bal' where product_id='$wp_id' and wm_id='$curr_user' ORDER BY id DESC limit 1";
        $this->Db->query($sql1);
    }
}
/*$stock=new Stock();
$stock->daily_stock_view();
$stock->sync_stock("611851");*/

class DTR{
    function __construct()
    {
        $this->Db = new Db();
        $this->Db =$this->Db->Dbase();
    }

    public function viewProduct($array){
        $sql="SELECT * FROM `daily_transaction_register` WHERE ";
        foreach($array as $key=>$val){
            $sql.="$key = '".$val."'";
        }
        return $this->Db->query($sql);
    }
    public function countTransaction($array){
        $res=$this->viewProduct($array);
        return $res->num_rows;
    }

    public function addDTR($data){
        $wm_id=$_SESSION['wm_id'];
        $p_id=mysqli_real_escape_string($this->Db,htmlspecialchars($data['product_id']));
        $t_id=mysqli_real_escape_string($this->Db,htmlspecialchars($data['transaction_id']));
        $t_qty=mysqli_real_escape_string($this->Db,htmlspecialchars($data['transaction_quantity']));
        $t_tf=mysqli_real_escape_string($this->Db,htmlspecialchars($data['transaction_to_from']));
        $t_type=mysqli_real_escape_string($this->Db,htmlspecialchars($data['t_type']));
        $lrp=mysqli_real_escape_string($this->Db,htmlspecialchars($data['ledger_reference_and_page']));
        $crnad=mysqli_real_escape_string($this->Db,htmlspecialchars($data['challan_receipt_no_and_date']));
        $sql="INSERT INTO `daily_transaction_register`(`id`, `product_id`, `transaction_id`, `transaction_quantity`, `ledger_reference_and_page`, `transaction_type`, `transaction_from`,`transaction_to`, `challan_receipt_no_and_date`, `date`) VALUES (0,'$p_id','$t_id',$t_qty,'$lrp','$t_type','$t_tf','$wm_id','$crnad',now())";
        if($this->Db->query($sql)):
            $num1=$this->Db->affected_rows;
            $stock=new Stock();
            $stock->addStock($p_id,$t_qty);
        endif;
    }

    public function subtractDTR($data){
        $wm_id=$_SESSION['wm_id'];
        $p_id=mysqli_real_escape_string($this->Db,htmlspecialchars($data['product_id']));
        $t_id=mysqli_real_escape_string($this->Db,htmlspecialchars($data['transaction_id']));
        $t_qty=mysqli_real_escape_string($this->Db,htmlspecialchars($data['transaction_quantity']));
        $t_tf=mysqli_real_escape_string($this->Db,htmlspecialchars($data['transaction_to_from']));
        $t_type=mysqli_real_escape_string($this->Db,htmlspecialchars($data['t_type']));
        $lrp=mysqli_real_escape_string($this->Db,htmlspecialchars($data['ledger_reference_and_page']));
        $crnad=mysqli_real_escape_string($this->Db,htmlspecialchars($data['challan_receipt_no_and_date']));
        $sql="INSERT INTO `daily_transaction_register`(`id`, `product_id`, `transaction_id`, `transaction_quantity`, `ledger_reference_and_page`, `transaction_type`, `transaction_from`,`transaction_to`, `challan_receipt_no_and_date`, `date`) VALUES (0,'$p_id','$t_id',$t_qty,'$lrp','$t_type','$wm_id','$t_tf','$crnad',now())";
        if($this->Db->query($sql)):
            $num1=$this->Db->affected_rows;
            $stock=new Stock();
            $stock->subtractStock($p_id,$t_qty);
        endif;
    }
    public function viewDTR($criteria=null){
        $curr_user=$_SESSION['wm_id'];
        if($criteria==null):
            $sql="SELECT * FROM daily_transaction_register WHERE transaction_to='$curr_user' OR transaction_from='$curr_user'";
        else:
            $sql="SELECT * FROM daily_transaction_register WHERE ";
            foreach($criteria as $key => $val):
                if($key=='start_date')
                    $sql.= "date > '".$val."' and ";
                elseif ($key == 'end_date')
                    $sql.= "date < '".$val."' and ";

                else
                    $sql.= $key."='".$val."' and ";
            endforeach;
            $sql=substr(trim($sql),0,-3);
        endif;
        $res=$this->Db->query($sql);
        return $res;
    }

}

class Client{
    function __construct()
    {
        $this->Db = new Db();
        $this->Db =$this->Db->Dbase();
    }

    public function viewClient($user=null){
        if($user==null):
            $sql="SELECT * FROM client";
        else:
            $sql="SELECT * FROM client WHERE c_id='$user'";
        endif;
        return $this->Db->query($sql);
    }

    public function checkClient($user,$pass){
        $sql="SELECT * FROM client WHERE c_id='$user' AND c_pass='$pass'";
        return $this->Db->query($sql);
    }

    public function createClient($user, $pass){
        $sql="insert into users() values (0,'$')";
        return $this->Db->query($sql);
    }

    public function updateImage($c_id,$pic_path){
        $sql="UPDATE `client` SET `pic_path`='$pic_path' WHERE `c_id`='$c_id'";
        $query=$this->Db->query($sql);
        return mysqli_affected_rows($this->Db);
    }

    public function updateDetails($c_id,$data){
        $sql="UPDATE `client` SET ";
        foreach($data as $key=>$value):
            $sql.="$key = '$value',";
        endforeach;
        $sql=substr(trim($sql), 0, -1);
        $sql.=" where c_id='$c_id'";
        $sql;
        $this->Db->query($sql);
    }

    function createRequest($arr){
        $curr_user=$_SESSION['c_id'];
        $ware_id=$arr['warehouse_id'];
        $req_id=$arr['request_id'];
        $product_arr=$arr['product'];
        /*print_r($product_arr);*/
        $n=array_sum(array_map("count", $product_arr))/count($product_arr);
        $sql="INSERT INTO `request_list`(`id`, `request_id`, `request_by`, `request_to`, `request_time`) VALUES (0,'$req_id','$curr_user','$ware_id',now())";
        $sql1="INSERT INTO `product_request`(`id`, `request_id`, `product_id`, `product_qty`) VALUES ";
        for($i=0;$i<$n;$i++) {
                $sql1.="(0,'".$req_id."','".$product_arr['product_id'][$i]."',";
                $sql1.="'".$product_arr['product_qty'][$i]."'),";
        }
        $sql1=rtrim($sql1,',');
        $sql."\n".$sql1;
        if($query=$this->Db->query($sql)):
            $this->Db->query($sql1);
            return 1;
        else:
            return 0;
        endif;
    }

    function viewRequest(){
        $curr_user=$_SESSION['c_id'];
        $sql="SELECT * FROM request_list, product_request where request_list.request_id=product_request.request_id and request_by='$curr_user'";
        return $this->Db->query($sql);

    }
    function countRows(){
        $res=$this->viewWHM();
        return $res->num_rows;
    }
}

class Notification{
    function __construct(){
        $this->Db= new Db();
        $this->Db= $this->Db->Dbase();
    }

    function showLessProductNotification(){
        $curr_user=$_SESSION['wm_id'];
        $sql="SELECT * FROM warehouse_stock WHERE wm_id='$curr_user' and availability<10";
        return $this->Db->query($sql);
    }
    function countLessProducts(){
        $curr_user=$_SESSION['wm_id'];
        $sql="SELECT COUNT(id) as count FROM warehouse_stock WHERE wm_id='$curr_user' and availability<10";
        return $this->Db->query($sql);
    }
}
?>