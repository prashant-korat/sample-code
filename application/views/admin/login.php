<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Futurism Admin | Sign In</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/invalid.css" type="text/css" media="screen" />	
<style type="text/css">
.button, #login-content{
	border:#FFF solid 1px !important;
	background: #7db9e8 !important; /* Old browsers */
	background: -moz-linear-gradient(top,  #7db9e8 0%, #2989d8 27%, #1e5799 100%) !important; /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#7db9e8), color-stop(27%,#2989d8), color-stop(100%,#1e5799)) !important; /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #7db9e8 0%,#2989d8 27%,#1e5799 100%)!important; /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #7db9e8 0%,#2989d8 27%,#1e5799 100%) !important; /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #7db9e8 0%,#2989d8 27%,#1e5799 100%) !important; /* IE10+ */
	background: linear-gradient(to bottom,  #7db9e8 0%,#2989d8 27%,#1e5799 100%) !important; /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7db9e8', endColorstr='#1e5799',GradientType=0 ) !important; /* IE6-9 */
}
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js/admin/simpla.jquery.configuration.js"></script>
</head>
  
	<body id="login" style="background:#CCCCCC">
		
		<div id="login-wrapper" style="background:none;" class="png_bg">
			<div id="login-top">
			
				<h1>CVP Admin</h1>
				<!-- Logo (221px width) -->
				<img id="logo" src="<?php echo base_url(); ?>images/admin/logo.png" alt=" Admin logo" style="padding:5px;  border-radius:5px;" />
			</div> <!-- End #logn-top -->
			
			<div id="login-content" style="padding:40px 40px 65px 40px;border-radius:5px;">
				
				<form method="post">
				
				<?php $this->load->view('elements/notifications'); ?>
                
					<p>
						<label>Username</label>
						<input class="text-input" type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" />
					</p>
					<div class="clear"></div>
					<p>
						<label>Password</label>
						<input class="text-input" type="password" name="password" />
					</p>
					<div class="clear"></div>
					<p>
						<input class="button" type="submit" value="Sign In" style="margin-top:0px;" />
					</p>
					
				</form>
			</div> <!-- End #login-content -->
			
		</div> <!-- End #login-wrapper -->
  </body>
</html>
