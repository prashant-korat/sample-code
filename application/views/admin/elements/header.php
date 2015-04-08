<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $controller = $this->router->class; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="icon" 
      type="image/png" 
      href="<?php echo site_url('images/FAVI.ico'); ?>">
<title>Admin Panel</title>
<link rel="stylesheet" href="<?php echo base_url() ?>css/admin/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url() ?>css/admin/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url() ?>css/admin/invalid.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url() ?>css/jquery-ui-1.10.0.custom.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url() ?>css/admin/jquery-ui-timepicker-addon.css" type="text/css" media="screen" />
<script type="text/javascript">
	var ajaxAutoLoadUrl = '<?php echo ($selectMenu == 'category') ? site_url('admin/'.$selectMenu.'/ajaxDataLoad/'.$parent_id) : ''; ?>';

	var selectMenu = '<?php echo $selectMenu ?>';
	var base_url = "<?php echo site_url(); ?>";
	var controller = "<?php echo $controller; ?>";
	var tinyMCE_bind = 0;
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.8.3.min.js"></script>

<?php
	$fileUploadScriptNotUse = array('image', 'materials', 'news', 'question'); 
	if(in_array($controller,$fileUploadScriptNotUse)){
?>
    <!-- Image Uploading Module-->
    <script type="text/javascript" src="<?php echo base_url() ?>js/jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/admin/ajax_image_upload.js"></script>
<?php }?>

<script type="text/javascript" src="<?php echo base_url() ?>js/admin/default.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/admin/simpla.jquery.configuration.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/admin/jquery.blockUI.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/qtip.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/form_validation.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/jquery-ui-1.10.0.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/jquery-ui-timepicker-addon.js"></script>

<style type="text/css">
.pre_loader{
	background:#000000;
	border-radius:5px;
	padding:5px;
	opacity:.3;
	alignment-adjust:central;
}
.pre_loader img{
	margin-left:50%;
}


.collspan{
	background:#CCC;
	color:#333;
	cursor:pointer;
	padding-left:10px;
}
.collspan_container{
	display:none;
}
.collspan .tab{
	color:#333;
	text-height:max-size;
	margin-right:10px;	
	float:right;
}

</style>
</head>
	<body>
    <div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
