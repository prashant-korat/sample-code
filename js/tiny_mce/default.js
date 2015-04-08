$(document).ready(function(e) {
	//Sidebar Accordion Menu:
	$('#main-nav a[rel='+selectMenu+']').addClass('current').parents('ul').siblings('a').addClass('current');

	url      = ''; 
	divid    = ''; 
	postData = '';
	divId    = '#content-box_';
	
	contentLoad(selectMenu);

	$(window).resize(function() {
		 setOverlayPos();
	});
		
		
	/* FOR FILE DOWNLOADS */
	$('tbody a.download_link').live('click',function(){

			divId = $(this).parents('div.content-box');
			divId = '#'+divId.attr('id');
			

			url = $(divId+' #downloadLinkURL').val()+"/"+$(this).attr('rel')+"/"+$(this).attr('data-');
			ajaxLoad_json(url, divId, postData);
			
			//window.location.reload();
			return false;
		});
	
			
	/* FOR PAGINATION */
	$('#ajax_paging a').live('click',function(){
	//	ajaxLoad($(this).attr('href'), 'main-content-html');

		divId = $(this).parents('div.content-box');
		divId = '#'+divId.attr('id');
		

		$(this).parent('tr').remove();
		perpage = $(divId+' select#per_page').val();
		searchTxt = $(divId + ' #searchText' ).val();

		postData = {perPage:   perpage , searchtxt : searchTxt};

		ajaxLoad_json($(this).attr('href'), divId, postData)
		return false;
		}
	);
	

	/* FOR DELETE RECORD */
	$('tbody a.delete').live('click',function(){
		divId = $(this).parents('div.content-box');
		divId = '#'+divId.attr('id');
		

		url = $(divId+' #delteDataURL').val()+"/"+$(this).attr('data-')+"/"+$(this).attr('rel');
		//alert(url);
		ajaxLoad_json(url, divId, postData, selectMenu);
		
		if($(this).attr('data-') == 0)
			notiTxt = 'Archive';
		else
			notiTxt = 'Unarchive';
		
		notificationBar('success', 'Selected Record '+notiTxt);
		return false;
	});

	/* FOR SEARCH */
	$('a#searchBtn').live('click',function(){
			divId = $(this).parents('div.content-box');
			divId = '#'+divId.attr('id');

			data = $(this).val();
			searchTxt = $(divId + ' #searchText' ).val();
			if(searchTxt == "")
				notificationBar('error', 'Please Enter Search');
				
			postData = {perPage:   data , searchtxt : searchTxt};

			url  = $(divId+' #searchURL').val(); 
			if(searchTxt != ''){
				
				ajaxLoad_json(url, divId, postData);
			}
		});
	
	/* FOR SEARCH */
	$('a#resetSearch').live('click',function(){
			divId = $(this).parents('div.content-box');
			divId = '#'+divId.attr('id');
			

			data = $(this).val();
			searchTxt = ' ';
			$('#searchText').val('');
			postData = {perPage:   data , searchtxt : searchTxt};

			url  = $(divId+' #searchURL').val(); 
			if(searchTxt != '')
				ajaxLoad_json(url, divId, postData);
		});
	
	$('#searchText').keypress(function(e) {
		if(e.which == 13) {
			$('a#searchBtn').trigger('click');
		}
	});
	
	/* FOR PER PAGE RECORDS VIEW  */
	$('.content-box select#per_page').live('change',function(){
			
			divId = $(this).parents('div.content-box');
			divId = '#'+divId.attr('id');
			

			data = $(this).val();
			searchTxt = $(divId + ' #searchText' ).val();
			postData = {perPage:   data , searchtxt : searchTxt};

			url  = $(divId+' #searchURL').val(); 

			ajaxLoad_json(url, divId, postData);
		});
	
	/* FOR DROPDOWN SELECTION IN ajax_load_data.php  */	
	$('#applySelection').live('click',function(){
		divId = $(this).parents('div.content-box');
		divId = '#'+divId.attr('id');
		
		selectVal = $(divId+' #opt_action').val();
		if(selectVal == 'delete')
		{
			var checkboxStatus = false;
			
			$(divId+' #delete_form input[type="checkbox"]').each(function(){
				if($(this).is(':checked'))
				{
					checkboxStatus= true;
				}
			});
			
			if(checkboxStatus)
			{
				flag = $(divId+ ' thead tr th .check-all').attr('rel');
				url = $(divId+' #delteDataURL').val()+ '/' + flag;
				postData = $(divId+' #delete_form').serialize();
				ajaxLoad_json(url, divId, postData, selectMenu);
				
				if(flag == 0)
					notiTxt = 'Archive';
				else
					notiTxt = 'Unarchive';
				
				notificationBar('success', 'Selected Record '+notiTxt);
			}else{
				notificationBar('error', 'Please Select Record')
			}
		}else
		{
			notificationBar('error', 'Please Select Option');
		}
		return false;
	
	});

	/* FOR SORTING */
	$('thead th').live('click',function(){
			f = $(this).attr('f');
			s = $(this).attr('s');

			divId = $(this).parents('div.content-box');
			divId = '#'+divId.attr('id');
			
			url  = $(divId+' #searchURL').val(); 

			data = $('#per_page').val();
			searchTxt = $(divId + ' #searchText' ).val();
			postData = {perPage:   data , searchtxt : searchTxt, f : f, s : s};
			
			if(s){
				
				ajaxLoad_json(url, divId, postData);
			}
			
		});
		
	/* FOR EDIT DATA */
	$('tbody a.edit').live('click',function(){
			divId = $(this).parents('div.content-box');
			divId = '#'+divId.attr('id');
			
			
			recordId = $(this).attr('rel');
			url = $(divId+' #ajaxFormData').val();
			postData = {recordId : recordId};
			
			ajaxLoad_json(url, divId, postData, 'false');
			
			return false;
		});
		
	/* FORM METHOD CLASS NAME*/	
	$('.recordManage').live('submit',function(){
		
		if(validation()){
			divId = $(this).parents('div.content-box');
			divId = '#'+divId.attr('id');
			
			
			//url = $(divId+' #addDataURL').val();
			var formUrl = $(this).attr('action');
			
			var postData = $(this).serialize();

			if($.browser.msie && $.browser.version != '9.0')
			{
				var name = $('#textarea').attr('name');
				if(typeof(name) != 'undefined' && name != null )
				{
					var value = tinyMCE.activeEditor.getContent();
					postData = updateQueryStringParameter(postData,name,value);
				}
			}
			
			$(divId+ ' #reset').trigger('click');	
					
			$('.content-box ul.content-box-tabs li a[rel=\"#tab1\"]').trigger('click');
		  	
			ajaxLoad_json(formUrl, divId, postData, selectMenu);

			notificationBar('success', 'Save Record Successfully');	
				
		}else{
			$(document).scroll(0);
//			window.scroll(0);
		}

		return false;
	});
	
var object ='';
// PRASHANT KORAT
	//REMOVE IMAGE UPLOADED USING AJAX FORM
	$('.remove_ajax_img').live('click',function(){
//		alert('remove_ajax_img');
		var path = $(this).parent().find('input[type="hidden"]').val();
		var auto_id = $(this).attr('data-');
		object = $(this);
		var classFunction = 'ajax_uploaded_remove';
		
		var name = object.parents('form').find('input[type="file"]').attr('name');

		$.ajax({ url:base_url+'admin/'+controller+'/'+classFunction+'/'+name,
				 type : 'POST',
				 data :{ path: path, auto_id: auto_id},
				 success : function(msg){

					 object.parents('form').find('input[type="file"]').val('').show();

					 inputHiddenId = object.parents('form').find('.uploadFile').attr('rel');
					 $('#'+inputHiddenId ).val('');

					 object.parents('form').find('div.previewImg').html('');

				}
			})
	});
	
	
	//REMOVE IMAGE UPLOADED USING AJAX FORM
	$('.ajax_uploaded_remove').live('click',function(){
		var path = $(this).parent().find('input#image_path').val();
		var auto_id = $(this).attr('data-');
		var object = $(this);
		$.ajax({ url:base_url+'admin/'+controller+'/deleteImage',
				 type : 'POST',
				 data :{ path: path, auto_id: auto_id},
				 success : function(msg){
					 //$(object).parent().prev().find('input').val('').show();
					 $('#res_image').show().val('');
					 $('#preview').html('');
				}
			})
	});

	//REMOVE VIDEO UPLOADED USING AJAX FORM
	$('.ajax_uploaded_remove_video').live('click',function(){
		var path = $(this).parent().find('input#video_path').val();
		var auto_id = $(this).attr('data-');
		$.ajax({ url:base_url+'admin/'+controller+'/deleteVideoLink',
				 type : 'POST',
				 data :{ path: path, auto_id: auto_id},
				 success : function(msg){
					 $('#res_video').show().val('');
					 $('#preview_video').html('');
				}
			})
	});
	
	//REMOVE HOVER IMAGE UPLOADED USING AJAX FORM
	$('.ajax_uploaded_remove_hover_img').live('click',function(){
		var path = $(this).parent().find('input#hover_image_path').val();
		var auto_id = $(this).attr('data-');
		$.ajax({ url:base_url+'admin/'+controller+'/deleteHoverImgLink',
				 type : 'POST',
				 data :{ path: path, auto_id: auto_id},
				 success : function(msg){
					 $('#hover_image').show().val('');
					 $('#preview_hover').html('');
				}
			})
	});
	
	//REMOVE ACTIVE IMAGE UPLOADED USING AJAX FORM
	$('.ajax_uploaded_remove_active_img').live('click',function(){
		var path = $(this).parent().find('input#active_image_path').val();
		var auto_id = $(this).attr('data-');
		$.ajax({ url:base_url+'admin/'+controller+'/deleteActiveImgLink',
				 type : 'POST',
				 data :{ path: path, auto_id: auto_id},
				 success : function(msg){
					 $('#active_image').show().val('');
					 $('#preview_active').html('');
				}
			})
	});

	//REMOVE HOME ICON IMAGE UPLOADED USING AJAX FORM
	/*$('.ajax_uploaded_remove_home_icon').live('click',function(){
		var path = $(this).parent().find('input#home_icon_path').val();
		var auto_id = $(this).attr('data-');
		$.ajax({ url:base_url+'admin/'+controller+'/deleteHomeIconLink',
				 type : 'POST',
				 data :{ path: path, auto_id: auto_id},
				 success : function(msg){
					 $('#home_icon').show().val('');
					 $('#preview_home_icon').html('');
				}
			})
	});*/
	
	//REMOVE TEST FINISH ICON IMAGE UPLOADED USING AJAX FORM
	$('.ajax_uploaded_remove_finish_icon').live('click',function(){
		var path = $(this).parent().find('input#finish_icon_path').val();
		var auto_id = $(this).attr('data-');
		$.ajax({ url:base_url+'admin/'+controller+'/deleteTestFinishIconLink',
				 type : 'POST',
				 data :{ path: path, auto_id: auto_id},
				 success : function(msg){
					 $('#finish_icon').show().val('');
					 $('#preview_finish_icon').html('');
				}
			})
	});

});
/* FOR MENU LOAD */
function contentLoad(selectMenu)
{
	divId = '#content-box_';
	
	switch(selectMenu){
	
		case 'newsletter':
			url = base_url+'admin/newsletter/ajaxDataLoad';
			/*ajaxLoad_json(url, divId, postData);
			divId = '#content-box_extraId';
			url = base_url+'admin/newsletter/ajaxDataLoad/1';*/
			break;
		
		case 'resources':
			url = base_url+'admin/resources/ajaxDataLoad';
			//ajaxLoad_json(url, divId, postData);
			//divId = '#content-box_extraId';
			//url = base_url+'admin/resources/ajaxDataLoad/1';
			break;
			
		case 'products':
			url = base_url+'admin/products/ajaxDataLoad';
			
			/*ajaxLoad_json(url, divId, postData);
			divId = '#content-box_extraId';
			url = base_url+'admin/products/ajaxDataLoad/1';*/
			break;
			
		case 'userlist':
			url = base_url+'admin/'+selectMenu+'/ajaxDataLoad';
			ajaxLoad_json(url, divId, postData);
			divId = '#content-box_extraId';
			url = base_url+'admin/'+selectMenu+'/ajaxDataLoad/1';
			break;
		
		case 'dashboard_content':
		case 'category':
		case 'resource_chapter':
		case 'home_menu':
		case 'newsletter_temp':
		case 'slider':
		case 'home_content':
		case 'news':
		case 'selfaudit':
		case 'wallarticle':
		case 'company_info':
		case 'configlist':
		case 'contactus_list':
		case 'faq':
		case 'video':
		case 'badges':
		case 'badges_que':
		case 'admin_user':
		case 'newsletter_track_report':
		case 'webinar':
			url = base_url+'admin/'+selectMenu+'/ajaxDataLoad';
			break;	
		default:
			url = base_url+'admin/login/dashboard';
			break;
			
	};
	
	if(selectMenu == 'home_content' || 'home_menu' || 'newsletter_temp' || 'webinar'){
		tinyMCE_bind = 1;
	}
	ajaxLoad_json(url, divId, postData);
}

function ajaxLoad_json(url, divId, postData, callback_flag)
{
	showPreLoader(divId);

	var formData = '';
	
	$.ajax({
		type: "POST",
		url: url,
		data: postData, //{key1: 'value1', key2: 'value2'}
		dataType: "json",
		async:true,
		success: function(html) {

	//		console.log(html);
			if(callback_flag)
			{
				if(callback_flag == 'false'){
					setData(html, divId);
				}else
					contentLoad(callback_flag);
			}
			else if(html)
			{
				if(divId)
				{
					$('.qtip').remove();
					
					if(typeof html.wholeContent != 'undefined')
					{
						$('.table_body').html(html.wholeContent);
						bind_tooltip(divId);
						hidePreLoader(divId);
						return false;
					}
					
					  $(divId+' tbody').html(html.tbody);
					  $(divId+' thead').html(html.thead);
					
					  $(divId+' #ajax_paging').html(html.links);
					  $(divId+' #popupData').html(html.popupData);
					  $(divId+' #tab_holder').html(html.tab_holder);
					  $(divId+' #tab2').html(html.tab2);
					 
					  if(html.tab3)
							$(divId+' #tab3').html(html.tab3);
					  
					  $(divId+' #delteDataURL').val(html.delteDataURL);
					  $(divId+' #searchURL').val(html.searchURL);
					  $(divId+' #downloadLinkURL').val(html.downloadLinkURL);
					  $(divId+' #ajaxFormData').val(html.ajaxFormData);
					  $(divId+' #addDataURL').val(html.addDataURL);
	  
					  $(divId+' .content-box .content-box-content div.tab-content').hide(); // Hide the content divs
					  $(divId+' ul.content-box-tabs li a.default-tab').addClass('current'); // Add the class "current" to the default tab
					  $(divId+' .content-box-content div.default-tab').show(); // Show the div with class "default-tab"
					  bind_tooltip(divId);
					  
					  if(tinyMCE_bind == 1){
						  bind_editor('editor');
						  tinyMCE_bind = 0;
					  }
					  if($('.datepicker').length){
						  $('.datepicker').datepicker({
								buttonImage: "images/calendar.gif",
								buttonImageOnly: true,
								dateFormat: "mm/dd/yy"
						  });
					  }

				}
			}
			
			//bind_editor('editor');
			//bind_tooltip(divId);
			hidePreLoader(divId);
		}
	});
}

var interval ;

/* FOR NOTIFICATION BAR SHOW AND HIDE  */
function notificationBar(eventtype, msg, object)
{
	clearInterval(interval);
	interval = setInterval(function(){
		$('#notification').slideUp(400);
	},5000);
	//  eventtype  = success, attention, information, error
	$('#notification').removeClass('success').removeClass('attention').removeClass('information').removeClass('error');
	$('#notification').addClass(eventtype);
	$('#notification').slideDown(400);
	$('#notification div').html(msg);
	if(object)
	  object.focus();
	  
	$(window).scrollTop(0);  
}

function assignValue(obj, data, inputType)
{
	switch(inputType)
	{
		case 'text':
			$(obj).html(data);
			break;
			
		case 'value':
			$(obj).val(data);
			break;
			
		case 'textarea':
			tinyMCE.getInstanceById(obj).execCommand('mceInsertContent',false,data);
			//tinyMCE.execCommand('mceInsertContent', false, data);
			break;
			
		case 'multiselect':
			var selected=data.split(',');
			for (var i in selected) {
				var data=selected[i];
				$(obj+' option[value=' + data + ']').attr('selected', true);
			}
			break;
	}
}

function showPreLoader(parentId)
{
//	$(parentId).append('<img src="'+base_url+'images/preloader-white.gif" class="smallPreloader" alt="Loading..." />');
	if(parentId){
		$(parentId+' .pre_loader').show();
	}else{
		$('.pre_loader').show();
	}
}

function hidePreLoader(parentId)
{
	if(parentId){
		$(parentId+' .pre_loader').hide();
	}else{
		$('.pre_loader').hide();
	}
}

function bind_tooltip(selector)
{
	if(typeof(selector) != 'undefined')
	{
		$(selector+' a[title]').qtip({
		position: { corner: {target : 'topLeft',tooltip : 'topRight'}, target : 'mouse' },
		adjust:{ mouse: true},
		style: {name : 'cream',tip: true} // Give it some style
		 });
	}
	 
	 //$('.listing_table tr:even').addClass("alt-row"); // Add class "alt-row" to even table rows
}

function bind_editor(element)
{
	tinyMCE.init({
						 // General options
						  mode : "textareas",
						  editor_selector : element,
						  theme : "advanced",
						  plugins :"autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

               // Theme options
               theme_advanced_buttons1 :"bold,italic,strikethrough,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,|,link,unlink,pagebreak,|,fullscreen,image,preview,insertfile",
               theme_advanced_buttons2 :"formatselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,media,charmap,emotions,|,outdent,indent,|,undo,redo,help,code",
						  theme_advanced_toolbar_location : "top",
						  theme_advanced_toolbar_align : "left",
						  theme_advanced_statusbar_location : "bottom",
						  theme_advanced_resizing : true,
						  forced_root_block : false,
						  force_p_newlines : "false",
						  remove_linebreaks : false,
						  force_br_newlines : true,
						  remove_trailing_nbsp : false,
						  verify_html : false,
				
				  
						  // Drop lists for link/image/media/template dialogs
						  template_external_list_url : "lists/template_list.js",
						  external_link_list_url : "lists/link_list.js",
						  external_image_list_url : "lists/image_list.js",
						  media_external_list_url : "lists/media_list.js"
				  
						 
					  });
}

function updateQueryStringParameter(uri, key, value) {
	
	var para = uri.split('&');
	for(i=0; i<para.length; i++)
	{
		var st = para[i].split('=');
		if(st[0] == key)
		{
			para[i] = key+'='+encodeURI(value);
			break;
		}
	}
	//para.key = value;
	var new_para = para.join('&');
	return (new_para);
}

//	UPLOAD DATA SET IN DIV WHILE EDITING PHASE.
function setPriviewVal(rel, datafill, datafill_url)
{
	$('#tab2').find('input[rel="'+ rel +'"]').hide();
	assignValue($(divId+ ' #preview_'+rel), datafill, 'text');
	$('#'+rel).val(datafill_url);

}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};