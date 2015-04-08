<script type="text/javascript">
var levelCount = 1;
$(document).ready(function(e) {
//  bind_sortable('<?php echo site_url('admin/album_name/updateOrder') ?>');		

	$('.load_sub_cat').live('click', function (){
		
		if($(this).hasClass('back')) { 
			levelCount = levelCount - 1;
		}else{
			levelCount = levelCount + 1;
		}

		console.log(levelCount);
		divId = '#content-box_';

		parent_id = $(this).attr('rel');
		url = base_url+'admin/'+selectMenu+'/ajaxDataLoad/'+parent_id;
		
		ajaxAutoLoadUrl = url;
		
		$('#searchURL').val(ajaxAutoLoadUrl);

		ajaxLoad_json(url, divId, {levelCount : levelCount});

	});
	
	
});

var popContent = function(data, divId)
						{
							if(data.htmlContent){ //if popup
									$('#popup_main #htmlContent').html(data.htmlContent);
									$.blockUI({ message: $('#popup_main') });
									setOverlayPos();
								}	
						}
/*
+---------------------------------------------+
	Function will validation using ajax call.
	@params : data -> name of table field
	          divId -> main container div name
+---------------------------------------------+
*/
var validation = function(data, divId)
					  {
						  if(data.is_error)
							notificationBar('error', data.msg, $(divId + ' #'+data.obj));
						  else
						  {
							contentLoad(selectMenu);
							notificationBar('success', 'Save Record Successfully');
						  }
						  return false;
					  }
/*
+---------------------------------------------+
	Function will edit form data to database using ajax call
	@params : data -> name of table field
	          divId -> main container div name
+---------------------------------------------+
*/
var setData = function(data, divId)
						{
							$(divId+' #tab2').html(data.htmlContent);
				  	  
						    if(setDataFlag = 1)
						    {
							  $('.content-box ul.content-box-tabs li a[rel="#tab2"]').trigger('click');
						    }
						}
</script>