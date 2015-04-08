<?php $parent_id_form = ($parent_id) ? $parent_id : $this->uri->segments[4] ?>
<form action="<?php echo site_url('admin/'.$this->controller.'/addData/'.$parent_id_form) ?>" onsubmit="" method="post" class="recordManage" v='validation'>
							
    <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
        <p>
            <label>Category Name <span>*</span></label>
            <input type="text" id="cat_name" name="cat_name" class="text-input small-input" value="<?php echo $cat_name;?>" />
        </p>
        
        
        <p>
            <input type="hidden"  name="recordId" id="recordId" value="<?php echo $category_id;?>"/>
            <input type="reset" id="reset" style="display:none;" />
            <input id="pform_submit" class="button" type="submit" value="Submit" />
        </p>
        
    </fieldset>
    
    <div class="clear"></div><!-- End .clear -->
    
</form>
