	<?php //$this->router->class == 'newsletter'
			$deleteOption = 'Unarchive';
			if(!@$extraClass){ 
				$deleteOption = 'Archive';
			
			?>
			<div id="notification" class="notification png_bg" style="display:none">
				<a href="#" class="close"><img src="<?php echo base_url() ?>images/admin/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div></div>
			</div>
	<?php } ?>
<div class="content-box " id="content-box_<?php echo @$extraClass ?>"><!-- Start Content Box -->
	<?php if(!@$extraClass){ ?>
              <div id="popupData" style="width:900px;"></div>
	<?php } ?>

    <input type="hidden" id="deleteDataURL" value="">
    <input type="hidden" id="searchURL" value="">
	<input type="hidden" id="downloadLinkURL" value="">
    <input type="hidden" id="ajaxFormData" value="">
    <input type="hidden" id="addDataURL" value="">

				<div class="content-box-header">
					
					<h3><?php echo ucfirst($title); ?></h3>
					<?php if(!@$extraClass){ ?>
                        <ul class="content-box-tabs" id="tab_holder">
                        </ul>
                    <?php } ?>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						 <form method="post" class="form" name="delete_form" id="delete_form" action="" onsubmit="return false;" style="position:relative">
                         <div class="pre_loader"><div class="listingPreloader"></div></div>
                         <table id="table">
                                                    
                            <thead>
                            </thead>
                            <?php if($selectMenu != 'home_content' && $selectMenu != 'dashboard_content' && $selectMenu != 'home_menu'){?>
							<tfoot>
                                <tr>
                                    <td colspan="7">
                                        <div class="bulk-actions align-left" style="width:100%">

                                            <input class="text-input" type="text" id="searchText" name="searchText" />
                                            <a class="button" href="javascript:void(0);" rel="" id="searchBtn">Search</a>
                                            <a class="button" href="javascript:void(0);" id="resetSearch">Reset</a>

                                            <select name="opt_action" id="opt_action">
                                                <option value="0">Choose an action...</option>
                                                <?php if($this->router->class != 'newsletter'){$deleteOption = 'Delete';} ?>
                                                <option value="delete"><?php echo $deleteOption; ?></option>
                                            </select>
                                            <a class="button" href="javascript:void(0);" id="applySelection">Apply to selected</a>

                                            
                                            <?php
												echo form_dropdown('per_page', per_page_drop(), '20', 'id="per_page"');  //per page dropdown
												if($selectMenu == 'newsletter' && !@$extraClass) 
													  echo '<a class="button" href="javascript:void(0)" data-="email_newsletter" style="margin-left:5px;" rel="modal">Send Newsletter Email</a>';
												
												?>
                                            <!--<span><img src="<?php echo base_url() ?>images/preloader-white.gif" class="smallPreloader" alt="Loading..." /></span>    -->
                                        </div>
                                        
                                        <div class="pagination" id="ajax_paging">
                                        
                                        </div> <!-- End .pagination -->
                                        
                                        <div class="clear"></div>
                                    </td>
                                </tr>
                            </tfoot>
                            <?php }?>
                            
                            <tbody class="table_body">
                            	<tr align="center" valign="middle">
                            		<td colspan="25" align="center" valign="middle" class="pre_loader"><!--<img src="<?php echo base_url() ?>images/admin/preloader.gif" alt="" />--></td>
                            	</tr>
                            </tbody>
                        </table>
                    </form>

						
					</div> <!-- End #tab1 -->
                    
                    
                    <?php if(!@$extraClass){ ?>
 	                   		<div class="tab-content" id="tab2" style="display:none;"> <!-- This is the target div. id must match the href of this div's tab --></div> <!-- End #tab2 -->
                            <div class="tab-content" id="tab3" style="display:none;"> <!-- This is the target div. id must match the href of this div's tab --></div> <!-- End #tab3 -->
                    <?php } ?>
                    
                     
					
				</div> <!-- End .content-box-content -->

				
			</div>
