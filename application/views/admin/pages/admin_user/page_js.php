<script type="text/javascript">
$(document).ready(function(e) {
	//Click on cancel button
	$('#cancel_button').live('click',function(){
		$('.content-box ul.content-box-tabs li a[rel="#tab1"]').trigger('click');
	})
});

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
	          divId -> main content box div name
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