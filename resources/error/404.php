<html>
	<head><?php $root=$_SERVER['DOCUMENT_ROOT']; ?>
		<script src="../js/jquery.min.js"></script>
		<script src="http://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
	</head>
	<body>
		<?php include "../../include/header.php" ?>
	</body>
</html>
<?php
$request = $_SERVER['REDIRECT_URL'];

// explode on / to find all the different request parts
$parts = explode('/', $request);

// flag to determine whether or not we've found content
$found = false;

if ($found) {
    // output a header to say the content exists, other a 404 will be sent
    header('HTTP/1.1: 200 OK');
    echo $output;
}
else {
    // no content was found. this should be automatically sent by the
    // server anyway, but we'll specify anyway just in case
    header('HTTP/1.0 404 Not Found'); ?>

<div class="container text-center"><img src="/rail/resources/foxrate.jpg" class="img-fluid"></div>
<?php
}
?>
