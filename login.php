<?php
    session_start();
    include "./include/dbController.php";
    if(isset($_POST['redirect']))
        $path=$_POST['redirect'];
    if(isset($_POST['warehouse_login'])):
        $user=$_POST['username'];
        $pass=$_POST['pass'];
        $whm=new WHM();
        $result=$whm->checkWHM($user,$pass);
        if(mysqli_num_rows($result)>0):
            $row=mysqli_fetch_assoc($result);
            $_SESSION['wm_id']=$row['wm_id'];
            if($path):
                header("location:$path");
            else:
                header("location:./warehouse/");
            endif;
        else:
            header("location:login.php?error_w");
        endif;
    elseif(isset($_POST['client_login'])):
        $user=$_POST['username'];
        $pass=$_POST['pass'];
        $cli=new Client();
        $res=$cli->checkClient($user,$pass);
        if(mysqli_num_rows($res)>0):
            print_r($row=$res->fetch_assoc());
            $_SESSION['c_id']=$user;
            if($path)
                header("location:$path");
            else
                header("location:./client/");
        else:
            header("location:login.php?error_c");
        endif;
    endif;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        input:-webkit-autofill {
            -webkit-box-shadow: inset 0 0 0px 9999px white;
        }
        .shadow{
            -webkit-box-shadow: 4px 4px 8px #aaa;
        }
        .shadow-s{
            -webkit-box-shadow: 0px 0px 16px #fff inset;
        }
        .hole{
            height:30px;
            width:30px;
            border:1px solid #ccc;
            border-radius:15px;
            background:#eceeef;
        }
        .hole-l{
            box-shadow: 2px 0px 8px #888 inset;
        }
        .hole-r{
            box-shadow: -2px 0px 8px #888 inset;
        }
        .stripe{
            position:absolute;
            top:40px;
            left:-55px;
            width:250px;
            display:inline-block;
            text-align: center;
            padding:10px 0px;
            transform: rotate(-42deg);
        }
        .stripe-danger{
            background:#dc5c20;
        }
        .stripe-classic{
            background:#2a90b9;
        }
        .card{
            overflow:hidden;
        }
    </style>
</head>
<body>
<?php include "include/header.php"; ?>
<div class="jumbotron">
    <div class="container">
        <?php if(isset($_GET['redirect'])): ?>
            <div>
                <span class="alert alert-danger form-control">Please Login First to reach this Page</span>
            </div>
        <?php endif; ?>
        <?php if(isset($_GET['loggedOut'])): ?>
            <div>
                <span class="alert alert-info form-control fade show alert-dismissible"><strong>You have been logged out Successfully. </strong>Login again to continue. <a href="#" class="close" data-dismiss="alert"><i class="fa fa-close"></i></a> </span>
            </div>
        <?php endif; ?>
        <div class="row text-center">
            <div class="col-lg-4 col-md-5 offset-lg-2">
                <div class="card alert-info shadow">
                    <div class="card-header text-center">
                        <div class="hole hole-l float-left"></div>
                        <div class="hole hole-l float-right"></div>
                        <div class="fa fa-4x float-right fa-building alert-info btn-classic rounded-circle mt-3 mb-4" style="text-align:center;padding-top:18px;height:100px;width:100px;"></div>
                        <h3 class="stripe btn-classic">WareHouse</h3>
                        <form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" class="mt-4">
                            <div class="form-group">
                                <input type="text" id="uid" name="username" class="form-control" placeholder="Your Username">
                            </div>
                            <div class="form-group">
                                <input type="password" id="pass" name="pass" class="form-control" placeholder="Your Password">
                            </div>
                            <div class="form-group text-right">
                                <a href="#">Forgot Password?</a>
                                <div class="btn-group">
                                    <button class="btn pl-2 pr-2 btn-classic" type="submit">Login Now</button>
                                    <button class="btn pl-2 pr-2 btn-secondary" type="reset">Clear</button>
                                </div>
                            </div>
                            <input type="hidden" name="warehouse_login">
                            <input type="hidden" name="redirect" value="<?php echo (isset($_GET['redirect']))?$_GET['redirect']:""; ?>">
                            <?php if(isset($_GET['error_w'])):?>
                                <div class="form-group">
                                    <div class="alert alert-danger fade show alert-dismissible" role="alert">Wrong user credentials <a href="#" data-dismiss="alert" class="close" aria-label="Close">&times;</a></div>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5">
                <div class="card alert-danger shadow">
                    <div class="card-header text-center ">
                        <div class="hole hole-l float-left"></div>
                        <div class="hole hole-l float-right"></div>
                        <div class="fa fa-user fa-4x float-right rounded-circle alert-danger mt-3 mb-4" style="width:100px;height:100px;padding-top:13px;"></div>
                        <h3 class="stripe alert-danger">Client</h3>
                        <form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" class="mt-4">
                            <div class="form-group">
                                <input type="text" id="uid" name="username" class="form-control" placeholder="Your Username">
                            </div>
                            <div class="form-group">
                                <input type="password" id="pass" name="pass" class="form-control" placeholder="Your Password">
                            </div>
                                <div class="form-group text-right">
                                    <a href="#" class="text-left">Reset Password?</a>
                                    <div class="btn-group">
                                        <button class="btn pl-3 pr-2 btn-danger" type="submit">Login Now</button>
                                        <button class="btn pl-2 pr-3 btn-secondary" type="reset">Clear</button>
                                    </div>                                </div>
                                <input type="hidden" name="client_login">
                                <?php if(isset($_GET['error_c'])):?>
                                    <div class="form-group">
                                        <div class="alert alert-danger">Wrong user credentials</div>
                                    </div>
                            </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
