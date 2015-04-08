<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>404 page not found</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="./css/404.css">
</head>
<?php $url = 'http://'.$_SERVER['SERVER_NAME'].(str_replace($_SERVER['REDIRECT_QUERY_STRING'],'',$_SERVER['REQUEST_URI']))."/"; ?>
<body>
<div class="main_wrapper" align="center">
<div class="error_container">
<img src="<?php echo $url."images/error_logo.png"; ?>" />
<p class="error_code">404.<span class="error_text"> That's an error.</span></p>
<p class="error_small_text">The page you requested is not available at this time.<br>
Please <a class="error_text" href="<?php echo $url; ?>">click here</a> to be redirected to the HOMEPAGE. </p>
</div>
</div>
</body>
</html>