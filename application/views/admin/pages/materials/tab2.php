
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
            <label>Book Name : <span>*</span></label>
            <input type="text" name="m_title" id="m_title"  value="<?php echo $m_title ?>" class="text-input small-input" />
        </p>
        
        <p>
            <label>Book Description : <span>*</span></label>
            <textarea name="m_desc" id="m_desc" class="" cols="70" style="width:60%;" rows="10"><?php echo @$m_desc ?></textarea>
        </p>
        
        <p>
            <input type="hidden"  name="recordId" id="recordId" value="<?php echo $material_id;?>"/>
            <input type="hidden"  name="m_images" id="m_images" value="<?php echo $m_images;?>"/>
            <input type="hidden"  name="m_document" id="m_document" value="<?php echo $m_document;?>"/>
            <input type="reset" id="reset" style="display:none;" />
            <input id="pform_submit" class="button" type="submit" value="Submit" style="display:none" />
        </p>
        
    </fieldset>
    
    <div class="clear"></div><!-- End .clear -->
    
</form>

<?php $fieldName = 'm_images'; ?>
<form action="<?php echo site_url('admin/materials/ajaxUploading/images/img/'.$fieldName); ?>" method="post" >
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

<?php $fieldName = 'm_document'; ?>
<form action="<?php echo site_url('admin/materials/ajaxUploading/docs/doc/'.$fieldName); ?>" method="post" >
    <fieldset>
        <p>
            <label>Document <span>*</span></label>
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

<p>
    <input id="submit_btn" class="button" type="button" value="Submit" />
</p>