<style type="text/css">
    .left-menu-box{
        background: #333;
        padding: 0px;
        border-color: #2c2c2c;
        white-space: nowrap;
    }
    .left-menu a{
        color:rgba(212,212,212,0.75);
    }
    .left-menu a:hover{
        color:rgba(240,240,240,0.75);
        background-color: rgba(25, 25, 25, 0.4);
        overflow:visible;
    }
    .left-menu{
        margin:0em;!important;
        padding:0px;!important;
    }
    .left-menu .navbar-nav a{
        padding:10px;!important;
    }
    a:hover{
        text-decoration:none;!important;
    }

</style>


<?php include_once "../include/dbController.php";

?>
<nav class="navbar navbar-inverse left-menu">
    <a class="navbar-link text-center" href="edit_profile.php" style="padding:20px;">
        <img src="<?=$wm_user['pic_path'];?>" class="img-fluid rounded-circle" alt="">
        <h3 class="text-center"><?=$wm_user['wm_name'];?></h3>
    </a>
    <ul class="nav navbar-nav">
        <li class="navbar-item"><a class="nav-link" href="#">Previous Orders</a></li>
        <li class="navbar-item"><a class="nav-link" href="stock_details.php">Stock Details</a></li>
        <li class="navbar-item"><a class="nav-link" href="">Product Requests</a></li>
        <li class="navbar-item"><a class="nav-link" href="#">Client Requests</a></li>
        <li class="navbar-item"><a class="nav-link" href="edit_profile.php">Edit Profile</a></li>
        <li class="navbar-item"><a class="nav-link" href="warehouses.php">All Warehouses</a></li>

    </ul>
</nav>