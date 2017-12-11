<?php
    $cli = new Client();
    $curr_user=$_SESSION['c_id'];
    $result=$cli->viewClient($curr_user);
    $sessionWarehouseUser=mysqli_fetch_assoc($result);
?>
    <style>
        #sidebar{
            background:#333;
            padding-bottom:9999px;
            margin-bottom: -9999px;
            overflow:hidden;
        }
        @media screen and (min-width: 768px){
            .left-menu-box{
                padding:0 40px 0 0;
                background-color: #EEEEEE;
            }
        }
        #sidebar .list-group-item {
            border-radius: 0;
            background-color: #333;
            color: #ccc;
            border-left: 0;
            border-right: 0;
            border-color: #2c2c2c;
            white-space: nowrap;
        }

        /* highlight active menu */
        #sidebar .list-group-item:not(.collapsed) {
            background-color: #222;
        }

        /* closed state */
        #sidebar .list-group .list-group-item[aria-expanded="false"]::after {
            content: " \f0d7";
            font-family: FontAwesome;
            display: inline;
            text-align: right;
            padding-left: 5px;
        }

        /* open state */
        #sidebar .list-group .list-group-item[aria-expanded="true"] {
            background-color: #222;
        }
        #sidebar .list-group .list-group-item[aria-expanded="true"]::after {
            content: " \f0da";
            font-family: FontAwesome;
            display: inline;
            text-align: right;
            padding-left: 5px;
        }

        /* level 1*/
        #sidebar .list-group .collapse .list-group-item  {
            padding-left: 20px;
        }

        /* level 2*/
        #sidebar .list-group .collapse > .collapse .list-group-item {
            padding-left: 30px;
        }

        /* level 3*/
        #sidebar .list-group .collapse > .collapse > .collapse .list-group-item {
            padding-left: 40px;
        }

        @media (max-width:48em) {
            /* overlay sub levels on small screens */
            #sidebar .list-group .collapse.in, #sidebar .list-group .collapsing {
                position: absolute;
                z-index: 1;
                width: 190px;
            }
            #sidebar .list-group > .list-group-item {
                text-align: center;
                padding: .75rem .5rem;
            }
            /* hide caret icons of top level when collapsed */
            #sidebar .list-group > .list-group-item[aria-expanded="true"]::after,
            #sidebar .list-group > .list-group-item[aria-expanded="false"]::after {
                display:none;
            }
        }

        /* change transition animation to width when entire sidebar is toggled */
        #sidebar.collapse {
            -webkit-transition-timing-function: ease;
            -o-transition-timing-function: ease;
            transition-timing-function: ease;
            -webkit-transition-duration: .2s;
            -o-transition-duration: .2s;
            transition-duration: .2s;
        }

        #sidebar.collapsing {
            opacity: 0.8;
            width: 0;
            -webkit-transition-timing-function: ease-in;
            -o-transition-timing-function: ease-in;
            transition-timing-function: ease-in;
            -webkit-transition-property: width;
            -o-transition-property: width;
            transition-property: width;

        }
    </style>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-1 p-l-0 p-r-0" id="sidebar">
            <div class="list-group card border-0">
                <a class="list-group-item collapsed" data-parent="#sidebar" href="./edit_profile.php" class="list-group-item collapsed" data-parent="#sidebar">
                    <img src="<?=$sessionWarehouseUser['pic_path'];?>" class="hidden-sm-down img-fluid rounded-circle" alt="">
                    <h2 class="hidden-sm-down"><?=$sessionWarehouseUser['c_name'];?></h2>
                </a>
                <a href="#menu3" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-envelope">&nbsp;</i> <span class="hidden-sm-down">Requests</span></a>
                <div class="collapse" id="menu3">
                    <a href="request_view.php" class="list-group-item" data-parent="#menu3"><i class="fa fa-eye">&nbsp;</i> <span class="hidden-sm-down">View Requests</span></a>
                    <a href="request_make.php" class="list-group-item" data-parent="#menu3"><i class="fa fa-plus">&nbsp;</i> <span class="hidden-sm-down">Make a Request</span></a>
                </div>
                <a href="products_view.php" class="list-group-item collapsed" data-parent="#sidebar"><i class="fa fa-user">&nbsp;</i> <span class="hidden-sm-down">View Products</span></a>
                <a href="edit_profile.php" class="list-group-item collapsed" data-parent="#sidebar"><i class="fa fa-user">&nbsp;</i> <span class="hidden-sm-down">Edit Profile</span></a>
            </div>
        </div>
    </div>
</div>