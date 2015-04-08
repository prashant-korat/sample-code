<script type="text/javascript">
$(document).ready(function(e) {
	
	//check user is active/de-active using ajax call
	$('.activeUser').live('click',function(){
		divId = $(this).parents('div.content-box');
		divId = '#'+divId.attr('id');
		
		recordId = $(this).attr('rel');
		flag = $(this).attr('data');
		
		url = base_url+'admin/userlist/verifyUser/'+recordId+'/'+flag;
		
		ajaxLoad_json(url, divId , '' , selectMenu);

		return false;
	});	
	
	//popup view on users information using ajax call
	$('a.view_users').live('click',function(){
			divId = $(this).parents('div.content-box');
			divId = '#'+divId.attr('id');

			recordId = $(this).attr('rel');
			url = '<?php echo site_url('admin/userlist/ajaxUsersView'); ?>/'+recordId;
		
			postData = '';
			ajaxLoad_json(url, divId, postData, setData);
	
		});
		
});

/*
+---------------------------------------------+
	Function will edit form data to database using ajax call
	@params : data -> name of table field
	          divId -> main container div name
+---------------------------------------------+
*/
var setData = function(data, divId)
						{
							if(!data)
								return false;
							if(data.htmlContent){ //if popup
								$('#popup_main #htmlContent').html(data.htmlContent);
								$.blockUI({ message: $('#popup_main') });
								setOverlayPos();
							}
						}
</script>