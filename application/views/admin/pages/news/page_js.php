<script type="text/javascript">
$(document).ready(function(e) {
//  bind_sortable('<?php echo site_url('admin/album_name/updateOrder') ?>');		

	$('.load_sub_cat').live('click', function (){
		divId = '#content-box_';

		parent_id = $(this).attr('rel');
		url = base_url+'admin/'+selectMenu+'/ajaxDataLoad/'+parent_id;
		
		ajaxAutoLoadUrl = url;
		
		$('#searchURL').val(ajaxAutoLoadUrl);

		ajaxLoad_json(url, divId, postData);
	});
	
	$('.load-sub-category, .load-sub-sub-category').live('change', function(){
		sVal = $(this).val();
		var that = $(this);
		
		if(parseInt(sVal) > 1){
			if($(this).hasClass('load-sub-category') ){
				$('.load-sub-sub-category').parents('p').remove();
			}
			
			$.post(base_url+'admin/question/ajaxLoadCategory', {cat_id : sVal}, function(data){
				if(data){
				  $('.load-sub-category').parents('p').append(data);
				}
			});
		}else{
			$('.load-sub-sub-category').parent('p').remove();
		}

	});
	
	$('.add-ans-block').live('click', function(){
		$(this).parents('table').append(addAnsHtml);
//		bind_editor('editor');
	});
	
	$('.content-box ul.content-box-tabs li a[rel="#tab1"]').live('click', function(){
		$('.load-sub-sub-category').parents('p').remove();
		$('.load-sub-category').html('<option value=" "></option>'+$('.load-sub-category').html());
		$('.load-sub-category').val(' ');
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