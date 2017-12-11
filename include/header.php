<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rail Project</title>
    <script src="./js/jquery.js"></script>
    <script src="http://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="./js/bootstrap.js"></script>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/font-awesome.css">
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
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-toggleable-md navbar-inverse" style="background-color: rgba(0,101,144,0.75)">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="container">
                <a class="navbar-brand" href="#">S&T Allahabad</a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <?php if(isset($_SESSION['wm_id'])): ?>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item"><a class="nav-link" href="#">Sign Out</a></li>
                        </ul>
                    <?php else: ?>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item"><a class="nav-link" href="./login.php">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Sign Up</a></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
</body>
</html>