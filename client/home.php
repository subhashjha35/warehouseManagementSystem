<?php
    session_start();
    include "../include/dbController.php";
    $cm = new CM();

    $result=$cm->viewCM($_SESSION['c_id']);
    $sessionUser=mysqli_fetch_assoc($result);

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
                padding-bottom:99999px;!important;
                margin-bottom:-99999px;!important;
                overflow:hidden;
            }
        }
        .content-box{
            padding-top:10px;
        }
    </style>
</head>
<body>
<?php include "include/header.php"; ?>
<!--<div class="jumbotron text-center">
    <h1>Welcome to the Warehouse Management</h1>
</div>-->
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-2 col-sm-4 left-menu-box">
            <?php include "./include/left_menu.php"; ?>
        </div>
        <div class="col-lg-10 col-sm-8 content-box">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</a></li>
            </ol>
            <div class="alert alert-info alert-dismissible fade show"><strong>You are logged in to <?=$sessionUser['c_name'];?>.</strong> To User another account, signout first.<span class="close" data-dismiss="alert">&times;</span></div>
            <table class="table table-bordered table-striped alert-info">
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Description</th>
                </tr>
                <?php
                $cp=new ClientProduct();
                $result=$cp->viewCP();
                while($row=mysqli_fetch_assoc($result)):
                    ?>
                    <tr>
                        <td><?=$row['cp_name'];?></td>
                        <td><?=$row['cp_description'];?></td>
                        <td><?=$row['cp_quantity'];?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
            
        </div>
    </div>

</div>
</body>
</html>