<!-- View Users Information -->
<div>
    <div class="row_cont">
        <div>First Name:</div>
        <label><?php echo $viewInfo['fname'];?></label>
    </div>
    <div class="row_cont">
        <div>Last Name:</div>
        <label><?php echo $viewInfo['lname'];?></label>
    </div>
    <div class="row_cont">
        <div>Email:</div>
        <label><?php echo $viewInfo['email'];?></label>
    </div>
    <?php
	if($viewInfo['is_active'] == 0)
		$verify.= 'No';
	else
		$verify.= 'Yes';?>
    <div class="row_cont">
        <div>Verify:</div>
        <label><?php echo $verify ;?></label>
    </div>
</div>