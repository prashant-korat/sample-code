<form action="<?php echo site_url('admin/'.$this->controller.'/addData') ?>" onsubmit="" method="post" class="recordManage" v='validation'>
							
    <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
        
        <?php foreach($this->fieldArr as $field){?>
                  <p>
                      <label><?php echo ucfirst($field) ?> <span>*</span></label>
                      <input type="text" id="<?php echo $field ?>" name="<?php echo $field ?>" class="text-input small-input" />
                  </p>
        <?php } ?>
        
        
        <p>
            <input type="hidden"  name="admin_id" id="recordId" value=""/>
            <input type="hidden"  name="password1" id="password1" value=""/>
            <input type="reset" id="reset" style="display:none;" />
            <input class="button " type="submit" value="Submit" />
        </p>
        
    </fieldset>
    
    <div class="clear"></div><!-- End .clear -->
    
</form>
