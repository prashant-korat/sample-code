
<form action="<?php echo site_url('admin/'.$this->controller.'/addData/') ?>" onsubmit="" method="post" class="recordManage" v='validation'>
							
    <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
    
    	<p>
        	<label>Test Name <span>*</span></label>
            <input type="text" name="test_name" value="<?php echo @$test_name ?>" class="text-input small-input" />
        </p>
    	<p>
        	<label>Test Timer <span>*</span></label>
            <input type="text" name="test_timer" value="<?php echo @$test_timer?>" class="text-input small-input" />
        </p>
        
    	<p>
        	<label>Release Date-Time  <span>*</span></label>
            <input type="text" name="test_release_on" value="<?php echo (@$test_release_on && @$test_release_on != '0000-00-00 00:00:00') ? date('m/d/Y H:i', strtotime(@$test_release_on)) : date('m/d/Y H:i'); ?>" class="text-input small-input date-time-picker" />
        </p>
        
    	<p>
        	<label>Select Category <span>*</span></label>
            <?php  $this->mdl_file->loadCategory(@$test_cat_id); ?>
        </p>
        
        <p>
            <table width="100%" class="que-holder">
            	<?php 
					if(@$test_que_ids && @$test_cat_id)
					$this->mdl_file->loadQue($test_cat_id, $test_que_ids)
				?>
           </table>
        </p>
        
        <p>
            <input type="hidden"  name="recordId" id="recordId" value="<?php echo $test_id;?>"/>
            <input type="reset" id="reset" style="display:none;" />
            <input id="pform_submit" class="button" type="submit" value="Submit" />
        </p>
        
    </fieldset>
    
    <div class="clear"></div><!-- End .clear -->
    
</form>

<script type="text/javascript">
$(document).ready(function(e) {
	$('.date-time-picker').each(function(index, element) {
	   $(this).datetimepicker(); 
	});
});
</script>