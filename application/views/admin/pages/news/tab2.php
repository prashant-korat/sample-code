
<form action="<?php echo site_url('admin/'.$this->controller.'/addData/') ?>" onsubmit="" method="post" class="recordManage" v='validation'>
							
    <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
    <!-- SELECT `news_id`, `news_title`, `news_img`, `news_text`, `created_on` FROM `fis_news` WHERE 1 -->
        <p>
            <label>Title : <span>*</span></label>
            <input type="text" name="news_title" id="news_title"  value="<?php echo $news_title ?>" class="text-input small-input" />
        </p>
        
        <p>
            <label>Description : <span>*</span></label>
            <textarea name="news_text" id="news_text" class="" cols="70" style="width:60%;" rows="10"><?php echo @$news_text ?></textarea>
        </p>
        
        <p>
            <input type="hidden"  name="recordId" id="recordId" value="<?php echo $news_id;?>"/>
            <input type="hidden"  name="news_img" id="news_img" value="<?php echo $news_img;?>"/>

            <input type="reset" id="reset" style="display:none;" />
            <input id="pform_submit" class="button" type="submit" value="Submit" style="display:none" />
        </p>
        
    </fieldset>
    
    <div class="clear"></div><!-- End .clear -->
    
</form>

<?php $fieldName = 'news_img'; ?>
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

<p>
    <input id="submit_btn" class="button" type="button" value="Submit" />
</p>