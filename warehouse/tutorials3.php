<!DOCTYPE html>
<html lang="en">
<head>
    <title>Aspect Ratio with Preview Pane | Jcrop Demo</title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery.Jcrop.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script type="text/javascript">
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
                aspectRatio: xsize / ysize
            },function(){
                // Use the API to get the real image size
                var bounds = this.getBounds();
                boundx = bounds[0];
                boundy = bounds[1];
                // Store the API in the jcrop_api variable
                jcrop_api = this;

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
            };

        });
        $(document).ready(function(){
            $("#my_modal").show();
        });
    </script>
    <link rel="stylesheet" href="demo_files/main.css" type="text/css" />
    <link rel="stylesheet" href="demo_files/demos.css" type="text/css" />
    <link rel="stylesheet" href="../css/jquery.Jcrop.css" type="text/css" />
    <style type="text/css">

        /* Apply these styles only when #preview-pane has
           been placed within the Jcrop widget */
        .jcrop-holder #preview-pane {
            display: block;
            position: absolute;
            z-index: 2000;
            top: 10px;
            right: -280px;
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
        #target{
            max-width:400px;
        }

    </style>

</head>
<body>

<div class="container">
    <div class="row">
        <div class="span12">
            <div class="jc-demo-box">

                <div class="page-header">
                    <ul class="breadcrumb first">
                        <li><a href="../index.html">Jcrop</a> <span class="divider">/</span></li>
                        <li><a href="../index.html">Demos</a> <span class="divider">/</span></li>
                        <li class="active">Aspect Ratio with Preview Pane</li>
                    </ul>
                    <h1>Aspect Ratio with Preview Pane</h1>
                </div>

                <div class="modal" id="my_modal">
                    <div class="modal-body">
                        <img src="./include/mm.png" id="target" alt="[Jcrop Example]" />

                        <div id="preview-pane">
                            <div class="preview-container">
                                <img src="./include/mm.png" class="jcrop-preview" alt="Preview" />
                            </div>
                        </div>

                        <div class="description">
                            <p>
                                <b>An example implementing a preview pane.</b>
                                Obviously the most visual demo, the preview pane is accomplished
                                entirely outside of Jcrop with a simple jQuery-flavored callback.
                                This type of interface could be useful for creating a thumbnail
                                or avatar. The onChange event handler is used to update the
                                view in the preview pane.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="tapmodo-footer">
                    <a href="http://tapmodo.com" class="tapmodo-logo segment">tapmodo.com</a>
                    <div class="segment"><b>&copy; 2008-2013 Tapmodo Interactive LLC</b><br />
                        Jcrop is free software released under <a href="../MIT-LICENSE.txt">MIT License</a>
                    </div>
                </div>

                <div class="clearfix"></div>

            </div>
        </div>
    </div>
</div>

</body>
</html>