
<form action="<?php echo site_url('admin/'.$this->controller.'/addData/') ?>" onsubmit="" method="post" class="recordManage" v='validation'>
							
    <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
    	<p>
        	<label>Category Name <span>*</span></label>
            <?php  
				if($cat_id){
					$this->mdl_file->loadAllCatInput($cat_id);
				}else{
					$res = $this->mdl_file->loadCategory();
					echo $res['htmlCont'];
				}
			?>
        </p>
        
        <p>
            <label>Questions : <span>*</span></label>
            <textarea name="question_txt" id="question_txt" class="" cols="70" style="width:60%;" rows="10"><?php echo @$question_txt ?></textarea>
        </p>
        
        <p>
            <label>Solution : <span></span></label>
            <textarea name="solution" id="solution" class="" cols="70" style="width:60%;" rows="10"><?php echo @$solution ?></textarea>
        </p>
        
        
        <table width="100%" cellspacing="3">
          <tr>
            <td width="80%"><strong>Answer</strong></td>
            <td><strong>is true</strong></td>
            <td><a href="javascript:;" class="add-ans-block">ADD</a></td>
          </tr>
          <?php foreach($ansData as $d){ ?>
                    <tr>
                      <td><textarea name="ans[]" cols="70" rows="10" style="width:70%;"><?php echo $d['ans_txt'] ?></textarea></td>
                      <td><?php echo form_dropdown('is_true[]', array('1' => 'YES', '0' => 'No'), $d['is_true']); ?></td>
                      <td><a href="javascript:;" class="remove-and-block">REMOVE</a><input type="hidden" name="ans_id[]" value="<?php echo $d['answer_id'] ?>" /></td>
                    </tr>
          <?php } ?>
          
        </table>
        
        <p>
            <input type="hidden"  name="recordId" id="recordId" value="<?php echo $question_id;?>"/>
            <input type="hidden"  name="question_img" id="question_img" value="<?php echo $question_img;?>"/>
            
            <input type="reset" id="reset" style="display:none;" />
            <input id="pform_submit" class="button" type="submit" value="Submit" />
        </p>
        
    </fieldset>
    
    <div class="clear"></div><!-- End .clear -->
    
</form>

<?php $fieldName = 'question_img'; ?>
<form action="<?php echo site_url('admin/question/ajaxUploading/images/img/'.$fieldName); ?>" method="post" >
    <fieldset>
        <p>
            <label>Image <span>*</span></label>
            <input class="uploadFile" type="file" name="<?php echo $fieldName ?>" rel="<?php echo $fieldName ?>" <?php if(${$fieldName}){echo ' style="display:none"';} ?>/>	
            <div id="preview_<?php echo $fieldName ?>" class="previewImg" style="position:relative;zoom:1;width:155px;">
            <?php 
				if(${$fieldName}){
					$img_src = image_src_common(${$fieldName});
					echo uploadPreview($img_src, ${$fieldName}, @$image_id);
				}
			
			?>

            </div>
        </p>
    </fieldset>
    <div class="clear"></div><!-- End .clear -->
</form>


<script type="text/javascript">
var addAnsHtml = <?php echo json_encode('<tr>
											<td><textarea name="ans[]" cols="70" rows="10" style="width:70%;"> </textarea></td>
											<td>'.form_dropdown('is_true[]', array('1' => 'YES', '0' => 'No'), '0').'</td>
											<td><a href="javascript:;" class="remove-and-block">REMOVE</a></td>
										  </tr>') ?>;
</script>