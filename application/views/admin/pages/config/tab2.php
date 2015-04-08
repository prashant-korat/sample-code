<form action="<?php echo site_url('admin/'.$this->controller.'/addData') ?>" onsubmit="" method="post" class="recordManage" v='validation'>
							
    <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
        
        <p>
            <label>Name <span>*</span></label>
            <input type="text" id="config_name" name="config_name" class="text-input small-input" value="<?php echo $config_name;?>" />
        </p>
        
        <p>
            <label>Value <span>*</span></label>
            <input type="text" name="config_value" class="text-input small-input" value="<?php echo $config_value?>" />
        </p>
        
        <p>
            <input type="hidden"  name="config_id" id="recordId" value="<?php echo $config_id?>"/>
            <input type="reset" id="reset" style="display:none;" />
            <input class="button " type="submit" value="Submit" />&nbsp;<input class="button" id="cancel_button" type="button" value="Cancel" />
        </p>
        
    </fieldset>
    
    <div class="clear"></div><!-- End .clear -->
    
</form>
