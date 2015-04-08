<form action="<?php echo site_url('admin/'.$this->controller.'/addData') ?>" onsubmit="" method="post" class="recordManage" v='validation'>
							
    <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
        
        <p>
            <label>Username <span>*</span></label>
            <input type="text" id="username" name="username" class="text-input small-input" value="<?php echo $username;?>" />
        </p>
        
        <p>
            <label>Password <span>*</span></label>
            <input type="password" id="password" name="password" class="text-input small-input" />
        </p>
        
        <p>
            <label>Re-enter Password <span>*</span></label>
            <input type="password" id="re_psd" name="re_psd" class="text-input small-input" />
        </p>
		
        <p>
            <input type="hidden"  name="admin_id" id="recordId" value="<?php echo $admin_id;?>"/>
            <input type="hidden"  name="admin_type" id="admin_type" value="<?php echo $admin_type;?>"/>
            <input type="reset" id="reset" style="display:none;" />
            <input class="button " type="submit" value="Submit" />&nbsp;<input class="button" id="cancel_button" type="button" value="Cancel" />
        </p>
        
    </fieldset>
    
    <div class="clear"></div><!-- End .clear -->
    
</form>
