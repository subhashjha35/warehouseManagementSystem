<?php
    session_start();
    include "../include/dbController.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="../js/jquery.min.js"></script>
    <script src="http://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../js/jquery.Jcrop.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/jquery.Jcrop.css">
    <link rel="stylesheet" href="../css/font-awesome.css">
    <script type="text/javascript">
        /*function enable_edit_profile(){
            var x=$("#profile_form");
            if($("#profile_form").prop("disabled",true)==true){
                x.prop("disabled",false);
                $("#profile_submit_btn_area").show();
            }
            else{
                x.prop("disabled",true);
                $("#profile_submit_btn_area").hide();
            }

        }*/

        $(document).ready(function(){
            $("#user_image").on("change",function(){
               $("#img_form").submit();
            });

        });
        jQuery(function($){

            // Create variables (in this scope) to hold the API and image size
            var jcrop_api,
                boundx,
                boundy,

                // Grab some information about the preview pane
                $preview = $('#preview-pane'),
                $pcnt = $('#preview-pane .preview-container'),
                $pimg = $('#preview-pane .preview-container img'),

                xsize = $pcnt.width(),
                ysize = $pcnt.height();

            console.log('init',[xsize,ysize]);
            $('#target').Jcrop({
                onChange: updatePreview,
                onSelect: updatePreview,
                onRelease: clearCoords,
                bgOpacity: 0.4,
                bgColor: 'black',
                addClass: 'jcrop-dark',
                boxWidth:280,
                aspectRatio: xsize / ysize
            },function(){
                // Use the API to get the real image size
                var bounds = this.getBounds();
                boundx = bounds[0];
                boundy = bounds[1];
                // Store the API in the jcrop_api variable
                jcrop_api = this;
                jcrop_api.setOptions({ bgFade: true });

                // Move the preview into the jcrop container for css positioning
                $preview.appendTo(jcrop_api.ui.holder);
            });

            function updatePreview(c)
            {
                if (parseInt(c.w) > 0)
                {
                    var rx = xsize / c.w;
                    var ry = ysize / c.h;

                    $pimg.css({
                        width: Math.round(rx * boundx) + 'px',
                        height: Math.round(ry * boundy) + 'px',
                        marginLeft: '-' + Math.round(rx * c.x) + 'px',
                        marginTop: '-' + Math.round(ry * c.y) + 'px'
                    });
                }

                $('#x1').val(c.x);
                $('#y1').val(c.y);
                $('#x2').val(c.x2);
                $('#y2').val(c.y2);
                $('#w').val(c.w);
                $('#h').val(c.h);
            };
            function clearCoords()
            {
                $('#coords input').val('');
            };

        });
        $(document).ready(function(){
            /*$("#my_modal").show();*/
        });

    </script>
    <style type="text/css">

        @media screen and (min-width: 768px){
            .left-menu-box{
                padding-bottom:99999px;!important;
                margin-bottom:-99999px;!important;
                overflow:hidden;
            }
            #my_modal .modal-content{
                min-width: 620px;!important;
                min-height: 450px;
                margin-left:-60px;
            }
        }


        /** The Magic **/

        .jcrop-holder #preview-pane {
            display: block;
            position: absolute;
            right:-280px;
            z-index: 2000;
            top: 0px;
            /*left: 100px;*/
            padding: 6px;
            border: 1px rgba(0,0,0,.4) solid;
            background-color: white;

            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            border-radius: 6px;

            -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
            box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
        }

        /* The Javascript code will set the aspect ratio of the crop
           area based on the size of the thumbnail preview,
           specified here */
        #preview-pane .preview-container {
            width: 250px;
            height: 250px;
            overflow: hidden;
        }
        .avatar {
            opacity: 1;
            display: block;
            width: 100%;
            height: auto;
            transition: .5s ease;
            backface-visibility: hidden;
        }
        .middle {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%)
        }
        .pic_text {

            color: rgba(0,101,144,0.75);
        }
        .pic_container:hover .avatar {
            opacity: 0.3;
        }

        .pic_container:hover .middle {
            opacity: 1;
        }
        .pic_container {
            position: relative;
            width: 100%;
        }

    </style>
</head>
<body>
<?php
    $cli = new Client();
    $curr_wm=$_SESSION['c_id'];
    $result=$cli->viewClient($curr_wm);
    $sessionWarehouseUser=mysqli_fetch_assoc($result);
    $src=$sessionWarehouseUser['pic_path'];
    if(isset($_POST['x1'])):
        $x1 = $_POST['x1'];
        $y1 = $_POST['y1'];
        $x2 = $_POST['x2'];
        $y2 = $_POST['y2'];
        $h = $_POST['h'];
        $w = $_POST['w'];
        $img=imagecreatetruecolor(256,256);
        $enc_name=uniqid().$curr_wm;
        $image_type=substr($src,-3);
        shell_exec("sudo chmod -R 777 users_data");
        $cropped_image_dest = "users_data/$curr_wm/avatar/jpg-256/$enc_name" . ".$image_type";
        if($image_type=="png"){
            imageAlphaBlending($img, false);
            imageSaveAlpha($img, true);
        }
        $source_img=imagecreatefromstring(file_get_contents($src));

        if($source_img!=FALSE){
            imagecopyresampled($img,$source_img,0,0,$x1,$y1,256,256,$w,$h);
            switch ($image_type){
                case "jpg":
                {imagejpeg($img, $cropped_image_dest,100); break;}
                case "png":
                {imagepng($img, $cropped_image_dest,0); break;}
                case "gif":
                {imagegif($img, $cropped_image_dest);}
                default:echo "no image type";
            }

            shell_exec("cd users_data/".$curr_wm."/avatar/; sudo chmod -R 777 jpg-256/");
            $rowAffected=$cli->updateImage($curr_wm,$cropped_image_dest);
            if(!$rowAffected){
                echo "alert('couldnot update pic')";
                echo mysqli_error($db);
            }
        }

    endif;
    if(isset($_FILES['user_image'])):
        $img=$_FILES['user_image'];
        $img_name=$img['name'];
        print_r($img);
        $tmp=$img['tmp_name'];
        $size=$img['size'];
        if($size>40960):
            $dest="users_data/$curr_wm/avatar/".uniqid().$img_name;
            shell_exec("chmod -R 777 users_data");
            if(move_uploaded_file($tmp,$dest)):
                /*echo("image moved successfully");*/
                if($res=$cli->updateImage($curr_wm,$dest)):
                    ?>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('#my_modal').modal('show');
                        });
                    </script>
                    <?php
                endif;
            else:
                echo("error moving image");
            endif;
        else:
            echo("size of the image is beyond the limit");
        endif;

    endif;

    if(isset($_POST['profile_data'])):
        $client=new Client();
        $c_name=$_POST['c_name'];
        $c_pass=$_POST['c_pass'];
        $c_id=$_POST['c_id'];
        $c_designation=$_POST['c_designation'];
        $email=$_POST['email'];
        $contact_no=$_POST['contact_no'];
        $data=array('c_name'=>$c_name,
            'c_pass'=>$c_pass,
            'c_designation'=>$c_designation,
            'email'=>$email,
            'contact_no'=>$contact_no);
        /*print_r($data);*/
        $client->updateDetails($curr_wm,$data);
    endif;
?>
<?php include "include/header.php"; ?>
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-3 col-sm-4 left-menu-box">
            <?php include "./include/left_menu.php"; ?>
        </div>
        <div class="col-lg-9 col-sm-8 content-box">
            <div class="container">
                <div class="row">
                    <div class="btn-group btn-breadcrumb">
                        <a href="index.php" class="btn btn-classic"><i class="fa fa-home" style="font-size:28px;"></i></a>
                        <a href="#" class="btn btn-classic">My Profile</a>
                    </div>
                </div>
            </div>
            <div class="jumbotron m-lg-0 p-lg-4" style="background:#fff;">
                <div class="main_container">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2>My Profile Details</h2>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset id="profile_form">
                                <form method="post" action="<?=$_SERVER['PHP_SELF'];?>" class="" >
                                    <div class="form-group">
                                        <label for="wm_id">Client ID</label>
                                        <input type="text" readonly name="c_id" class="form-control" value="<?=$sessionWarehouseUser['c_id'];?>">
                                    </div>
                                    <input type="hidden" name="c_id" value="<?=$sessionWarehouseUser['c_id'];?>">

                                    <div class="form-group">
                                        <label   for="wm_name">Your Name</label>
                                        <input type="text" name="c_name" class="form-control" value="<?=$sessionWarehouseUser['c_name'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email ID</label>
                                        <input type="email" name="email" class="form-control" value="<?=$sessionWarehouseUser['email'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Designation</label>
                                        <input type="text" name="c_designation" class="form-control" value="<?=$sessionWarehouseUser['c_designation'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Contact No.</label>
                                        <input type="number" name="contact_no" class="form-control" value="<?=$sessionWarehouseUser['contact_no'];?>">
                                    </div>
                                    <div class="form-group" id="profile_submit_btn_area">
                                        <button class="btn btn-classic" type="submit">Confirm Change</button>
                                        <button class="btn btn-secondary" type="reset">Cancel Change</button>
                                    </div>
                                    <input type="hidden" name="profile_data">
                                </form>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <div class="container">
                                <div class="row">
                                    <div class="offset-lg-2 col-lg-8">
                                        <div class="row">
                                            <form action="edit_profile.php" method="post" id="img_form" enctype="multipart/form-data">
                                                <input type="file" name="user_image" id="user_image" class="hidden-xs-up" accept=".bmp,.png,.jpg">
                                                <label for="user_image" id="image_label">
                                                    <?php
                                                        $cli=new Client();
                                                        $result=$cli->viewClient($_SESSION['c_id']);
                                                        $row=mysqli_fetch_assoc($result);
                                                        $user_img=$row['pic_path'];
                                                    ?>
                                                    <div class="pic_container">
                                                        <label for="user_image">
                                                            <img id="user_pic"src="<?=$user_img;?>" style="width:100%; max-width: 400px;" class="avatar img-thumbnail">
                                                        </label>
                                                        <div class="middle">
                                                            <span class="pic_text fa fa-3x fa-camera"></span>
                                                        </div>
                                                    </div>
                                            </form>
                                            <form action="" class="card p-2">
                                                <strong>Change Password</strong>
                                                <div class="form-group">
                                                    <input placeholder="Current Password" type="text" id="o_pass" name="o_pass" class="form-control" value="">
                                                </div>
                                                <div class="form-group">
                                                    <input placeholder="New Password" type="text" id="c_pass" name="c_pass" class="form-control" value="">
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-classic">Reset Password</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="my_modal" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <?php
                                $result=$cli->viewClient($_SESSION['c_id']);
                                $row=mysqli_fetch_assoc($result);
                                $user_img=$row['pic_path'];
                                ?>
                                <img src="<?=$user_img;?>" id="target" alt="[Jcrop Example]" />
                            </div>
                            <div class="col-md-4">
                                <div id="preview-pane" class="hidden-md-down">
                                    <div class="preview-container">

                                        <img src="<?=$user_img;?>" class="jcrop-preview" alt="Preview" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
                        <div class="inline-labels">
                            <label>X1 <input type="text" size="4" id="x1" name="x1" /></label>
                            <label>Y1 <input type="text" size="4" id="y1" name="y1" /></label>
                            <label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
                            <label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
                            <label>W <input type="text" size="4" id="w" name="w" /></label>
                            <label>H <input type="text" size="4" id="h" name="h" /></label>
                        </div>
                        <button type="submit" class="btn btn-info">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
