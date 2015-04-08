<?php
$nt_arr = array('attention','information','success','error');
foreach($nt_arr as $nt)
{
	$flMessage = getFlashMessage($nt);
	if($flMessage != '')
	{
		$noti = $nt;
		break;
	}
}
		
if(isset($noti)):
?>
<div class="notification <?php echo $noti; ?> png_bg">
				<a href="#" class="close"><img src="<?php echo base_url(); ?>images/admin/cross_grey_small.png" title="Close this notification" alt="close"></a>
				<div>
					<?php echo $flMessage; ?>
				</div>
			</div>
<?php endif; ?>