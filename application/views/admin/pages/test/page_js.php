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
	
	$('.load-que').live('change', function(){
		loadQue();
	});
	
	$('.show_selected').live('click', function(){
		$('.que-holder tr:not(tr:first-child)').hide();
		
		$('.que-holder input[type="checkbox"]').each(function(index, element) {
            if($(element).is(':checked'))
				$(element).parents('tr').show();
        });
		
	});

	$('.view_all').live('click', function(){
		$('.que-holder tr').show();
	});
	
	$('.content-box ul.content-box-tabs li a[rel="#tab1"]').live('click', function(){
		$('.que-holder').html('');
	});
	
});

function loadQue(){
	sVal = $('.load-que option:selected').val();
	$.post(base_url+'admin/test/ajaxLoadQue', {cat_id : sVal}, function(data){
		$('.que-holder').html(data);
	});
}

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
							$('.show_selected').trigger('click');
				  	  
						    if(setDataFlag = 1)
						    {
							  $('.content-box ul.content-box-tabs li a[rel="#tab2"]').trigger('click');
						    }
							
						}
</script>