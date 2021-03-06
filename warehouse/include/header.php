<?php
    $path=$_SERVER['PHP_SELF'];
    if(!isset($_SESSION['wm_id']))
        header("location:../login.php?redirect=$path");

    $curr_wm=$_SESSION['wm_id'];
    $whm= new WHM();
    $res=$whm->viewWHM($curr_wm);
    $wm_user=mysqli_fetch_assoc($res);
?>
<style>
    .btn-classic{
        background-color: #4085ae;
        color:#fff;
    }
    .btn-classic:hover{
        background-color: #396f92;
    }
    .btn-classic:active{
        background-color: #2b4b67;
    }
    .dropdown{
        position:relative;
    }
    #profile_dropdown {
        top:58px;
    }
    #profile_dropdown:before{
        content:"";
        width:0;
        height:0;
        border-bottom:10px #222 solid;
        border-right:10px transparent solid;
        border-left:10px transparent solid;
        position:absolute;
        top:-10px;
        left:70px;
        z-index: 99;
    }
    #profile_dropdown:after{
        content:"";
        width:0;
        height:0;
        border-bottom:12px #fff solid;
        border-right:12px transparent solid;
        border-left:12px transparent solid;
        position:absolute;
        top:-10px;
        left:68px;
        z-index: 999;
    }

    /*Button Breadcrumb for navigation*/
    .btn-breadcrumb .btn:after {
        content: " ";
        display: block;
        width: 0;
        height: 0px;
        border-top: 15px solid transparent;
        border-bottom: 15px solid transparent;
        border-left: 10px solid white;
        position: absolute;
        top: 50%;
        margin-top: -15px;
        margin-left: -3px;
        left: 100%;
        z-index: 3;
    }
    .btn-breadcrumb .btn:before {
        content: " ";
        display: block;
        width: 0;
        height: 0;
        border-top: 15px solid transparent;
        border-bottom: 15px solid transparent;
        border-left: 10px solid rgb(173, 173, 173);
        position: absolute;
        top: 50%;
        margin-top: -15px;
        margin-left: -2px;
        padding:0px;
        left: 100%;
        z-index: 3;
    }

    /** The Spacing **/
    .btn-breadcrumb{
        margin-bottom:10px;
    }
    .btn-breadcrumb .btn {
        padding:4px 15px;!important;
        margin:0px;
    }
    .btn-breadcrumb .btn:first-child {
        padding:0px 6px 0px 10px;
    }
    .btn-breadcrumb .btn:last-child {
        padding:4px 18px 0px 24px;
    }

    /** Classic button **/
    .btn-breadcrumb .btn.btn-classic:after {
        border-left: 8px solid #4085ae;
    }
    .btn-breadcrumb .btn.btn-classic:before {
        border-left: 8px solid #2b4b67;
    }
    .btn-breadcrumb .btn.btn-classic:hover:after {
        border-left: 8px solid #396f92;
        -webkit-transition: all 0.3s;
    }
    .btn-breadcrumb .btn.btn-classic:hover:before {
        border-left: 8px solid #396f92;
    }

    .btn-breadcrumb .btn.btn-classic:last-child {
        background: #fff;
        color:#aaa;
        border-width:1px 0px;
        border-style: solid;
        border-color:#396f92;
    }
    .btn-breadcrumb .btn.btn-classic:last-child:before {
        border-left: 8px solid #396f92;
    }
    .btn-breadcrumb .btn.btn-classic:last-child:after {
        border-left: 8px solid #fff;
    }
    .btn-breadcrumb .btn.btn-classic:last-child a:hover{
        cursor:pointer;
    }
    .content-box{
        padding-top:10px;
        background-color: #EEEEEE;
    }
    @media screen and (min-width:768px){
        .content-box{
            padding-bottom:9999px;
            margin-bottom:-9999px;
            overflow:hidden;
        }
        .content-box .main_container{
            padding:60px;
        }
    }
    @media screen and (max-width:768px){
        .content-box .main_container{
            padding:10px;
        }
    }
    .content-box .main_container{
        background-color:#fff;
    }
</style>
<header class="hidden-print">
    <nav class="navbar navbar-toggleable-md navbar-inverse" style="background-color: rgba(0,101,144,0.75)">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="container">
            <a class="navbar-brand" href="./index.php">S&T Allahabad</a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="previous_orders.php">Previous Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="stock_details.php">Stock Details</a></li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="dtrDropdown">Daily Transaction</a>
                        <div class="dropdown-menu" aria-labelledby="dtrDropdown">
                            <a href="dtr_view.php" class="dropdown-item">View DTR</a>
                            <a href="dtr_registration.php" class="dropdown-item">Register DTR</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="productsDropdown">Products</a>
                        <div class="dropdown-menu" aria-labelledby="productsDropdown">
                            <a class="dropdown-item" href="products_view.php">View All Products</a>
                            <a class="dropdown-item" href="product_registration.php">Register a new Product</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" id="requestDropdown">Requests</a>
                        <div class="dropdown-menu" aria-labelledby="requestDropdown">
                            <a href="view_requests.php" class="dropdown-item">View Requests</a>
                            <a href="product_request.php" class="dropdown-item">Make a Request</a>
                        </div>
                    </li>
                </ul>
                <?php if(isset($_SESSION['wm_id'])): ?>
                    <?php $noti=new Notification();
                    $res=$noti->countLessProducts();
                    $numOfLessProducts=$res->fetch_assoc();?>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" id="notificationDropdown"><span class="fa fa-bell rounded-circle img-fluid"style="<?=($numOfLessProducts['count']>0)?'background:orange;font-size:22px;margin:0px;border-radius:2px;':null;?>"></span> Notification</a>
                        <div class="dropdown-menu" aria-lebelledby="notificationDropdown">
                            <a href="notifications.php" class="dropdown-item"><?=($numOfLessProducts['count']>0)?$numOfLessProducts['count']." Product(s) about to get over":"No New Notification";?></a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="navbarDropdownMenuLink">
                            <img src="<?=$wm_user['pic_path'];?>" style="height:26px;" class="rounded-circle img-fluid" alt=""><?=$wm_user['wm_name'];?></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" id="profile_dropdown">
                            <a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
                            <a class="dropdown-item" href="logout.php">LogOut</a>
                        </div>
                    </li>
                </ul>
                <?php else: ?>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="/login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Sign Up</a></li>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>