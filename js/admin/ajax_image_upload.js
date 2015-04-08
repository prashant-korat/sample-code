// JavaScript Document
$(document).ready(function() {
		
		
		//COMMON FUNCTION FOR UPLOADDING..
		// '.uploadFile' APPLY THIS CLASS TO INPUT FILE TYPE WHICH WE HAVE TO USE FOR AJAX UPLOAD. 
		$('.uploadFile').live('change',function(){
				divId = $(this).parents('div.content-box');
				divId = '#'+divId.attr('id');
				
				formObj = $(this).parents('form');

				
				formObj.find('div.previewImg').html("<img src='"+base_url+"images/admin/loader.gif' alt='Uploading....'/>");
				hiddenInputId = $(this).attr('rel');

				$(formObj).ajaxForm({
						target: formObj.find('div.previewImg'),
						success:function(resp){
							try {
									var msg = $.parseJSON(resp);
									if(msg.error)
									{
										notificationBar('error', 'Please select valid file.');
										formObj.find('div.previewImg').html("");
										return false;
									}	
								} catch (e) {
									// not json
							}
							formObj.find('input[type="file"]').hide();
							formObj.find('div.previewImg').html(msg).show();
							$('#'+hiddenInputId).val(formObj.find('input[type="hidden"]').val());

						}
				}).submit();
				return false;
				
			});
			
		//click on submit for image
		$('#submit_btn').live('click',function() { $('#pform_submit').trigger('click'); });
	});