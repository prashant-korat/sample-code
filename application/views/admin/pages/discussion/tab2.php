<form action="<?php echo site_url('admin/'.$this->controller.'/addData/') ?>" onsubmit="" method="post" class="recordManage" v='validation'>
							
    <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
    <!-- SELECT `news_id`, `news_title`, `news_img`, `news_text`, `created_on` FROM `fis_news` WHERE 1 -->
        <p>
            <label>Question:</label>
            <div>
            	<?php echo $discussion_text; ?>
	            <span style="float:right;">
                   	<b>POSTED ON :</b> <?php echo date('m-d-Y H:i:s', strtotime($created_on)); ?>&nbsp;&nbsp;
                	<b>LIKES :</b> <?php echo $like_count ?>&nbsp;&nbsp;
                    <b>UNLIKES :</b> <?php echo $unlike_count ?>&nbsp;&nbsp;
					<a href="javascript:void(0)" class="delete" rel="<?php echo $discussion_id ?>" title="Delete">
		            	<img src="<?php echo base_url() ?>images/admin/cross.png" alt="Delete" />
        			</a>
                </span>
            </div>
        </p>
        <?php //echo '<pre>';print_r($ansData);echo '</pre>'; ?>
        <p>
            <label>Answer:</label>
            <ul>
                <?php foreach($ansData as $ans){ ?>
                        <li><?php echo $ans['discussion_text'] ?> 
                            <span style="float:right;">
                                <b>POSTED ON :</b>  <?php echo date('m-d-Y H:i:s', strtotime($ans['created_on'])); ?>&nbsp;&nbsp;
                                <!-- <b>LIKES :</b> <?php echo ($ans['like_count']) ? $ans['like_count'] : 0 ?>&nbsp;&nbsp; -->
                                <!-- <b>UNLIKES :</b> <?php echo ($ans['unlike_count']) ? $ans['unlike_count'] : 0 ?>&nbsp;&nbsp; -->
                                <a href="javascript:void(0)" class="delete" rel="<?php echo $ans['discussion_id'] ?>" title="Delete">
                                  <img src="<?php echo base_url() ?>images/admin/cross.png" alt="Delete" />
                                </a>
                                
                            </span> 
                        </li>
                <?php } ?>
            </ul>
            
        </p>
        
    </fieldset>
    
    <div class="clear"></div><!-- End .clear -->
    
</form>

