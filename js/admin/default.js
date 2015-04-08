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
		if(confirm('Are You Sure?'))
		{
			divId = $(this).parents('div.content-box');
			divId = '#'+divId.attr('id');
			
	
			url = $(divId+' #deleteDataURL').val()+"/"+$(this).attr('rel');
			//alert(url);
			ajaxLoad_json(url, divId, postData, selectMenu);
			
			if($(this).attr('data-') == 0)
				notiTxt = 'Archive';
			else
				notiTxt = 'Unarchive';
			notiTxt = 'Delete';
			notificationBar('success', 'Selected Record '+notiTxt);
		}
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
	
	
	/* FOR RESET SEARCH */
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
	
	/* FOR ENTER TO SEARCH */
	$('#searchText').keypress(function(e) {
		if(e.which == 13) {
			$('a#searchBtn').trigger('click');
		}
	});
	
	/* FOR PER PAGE RECORDS VIEW */
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
				url = $(divId+' #deleteDataURL').val()+ '/' + flag;
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

	/* FOR SORTING ORDER*/
	$('thead th').live('click',function(){
			f = $(this).attr('f'); //name of table field
			s = $(this).attr('s'); //name of sorting table field

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
			
			ajaxLoad_json(url, divId, postData, setData);
			
			return false;
		});
		
	/* FORM METHOD CLASS NAME */	
	$('.recordManage').live('submit', function(){

		divId = $(this).parents('div.content-box');
		divId = '#'+divId.attr('id');
		
		validationFunct = eval($(this).attr('v'));
		//Funct = eval($(this).attr('fn'));

	
		var postData = $(this).serialize();
		var formUrl = $(this).attr('action');

			if($.browser.msie && $.browser.version != '9.0')
			{
				var name = $('#textarea').attr('name');
				if(typeof(name) != 'undefined' && name != null )
				{
					var value = tinyMCE.activeEditor.getContent();
					postData = updateQueryStringParameter(postData,name,value);
				}
			}
 	
	    ajaxLoad_json(formUrl, divId, postData, validationFunct);
		
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
	
});

/* FOR MENU LOAD */
function contentLoad(selectMenu)
{
	divId = '#content-box_';

	if(selectMenu == 'dashboard')
		url = base_url+'admin/login/dashboard';
	else
		url = base_url+'admin/'+selectMenu+'/ajaxDataLoad';
	
	if(ajaxAutoLoadUrl)
		url = ajaxAutoLoadUrl;

	
	if(selectMenu == 'coupon' || 'config' || 'question1'){
		tinyMCE_bind = 1;
	}
	ajaxLoad_json(url, divId, postData);
}

var returnData, ParentDiv;
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

			if(callback_flag)
			{
				if(callback_flag != selectMenu)
				{
					callback_flag(html, divId);
					hidePreLoader(divId);
				}
				else
					contentLoad(callback_flag);	
			}
			else if(html)
			{
				if(html.session_error == true)
					window.location = html.redirect_url;

				if(divId)
				{
					  $('.qtip').remove();
					  $(divId+' tbody').html(html.tbody);
					  $(divId+' thead').html(html.thead);
					  $(divId+' #ajax_paging').html(html.links);
					  $(divId+' #popupData').html(html.popupData);
					  $(divId+' #tab_holder').html(html.tab_holder);
					  $(divId+' #tab2').html(html.tab2);
					 
					  if(html.tab3)
							$(divId+' #tab3').html(html.tab3);
					  
					  $(divId+' #deleteDataURL').val(html.deleteDataURL);
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
					  myDatepicker();

		  			  $('.content-box ul.content-box-tabs li a[rel=\"#tab1\"]').trigger('click');
					  
					  hidePreLoader(divId);

				}
			}
			
			//bind_editor('editor');
			//bind_tooltip(divId);
			
		}
	});
}

var interval ;

/*
+----------------------------------------------+
	This function will notification html
	@params : eventtype -> type of notification.
			  msg -> message you want dispaly as error.
			  object -> current element object
+----------------------------------------------+
*/
function notificationBar(eventtype, msg, object)
{
	$(window).scrollTop(0);

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
}

/*
+---------------------------------------------+
	Function will fill assign value from 
	edit form of any module.
+---------------------------------------------+
*/
function assignValue(obj, data, inputType)
{
	switch(inputType)
	{
		case 'text': //fill text value
			$(obj).html(data);
			break;
			
		case 'value': //input type in fill value 
			$(obj).val(data);
			break;
			
		case 'textarea': //select tinyMCE editor in fill value
			tinyMCE.getInstanceById(obj).execCommand('mceInsertContent',false,data);
			//tinyMCE.execCommand('mceInsertContent', false, data);
			break;
			
		case 'multiselect': //selected value in multiple dropdown
			var selected=data.split(',');
			for (var i in selected) {
				var data=selected[i];
				$(obj+' option[value=' + data + ']').attr('selected', true);
			}
			break;
	}
}

/*
+---------------------------------------------+
	show preloader at listing table.
+---------------------------------------------+
*/
function showPreLoader(parentId)
{
//	$(parentId).append('<img src="'+base_url+'images/preloader-white.gif" class="smallPreloader" alt="Loading..." />');
	if(parentId){
		$(parentId+' .pre_loader').show();
	}else{
		$('.pre_loader').show();
	}
}

/*
+---------------------------------------------+
	hide preloader at listing table.
+---------------------------------------------+
*/
function hidePreLoader(parentId)
{
	if(parentId){
		$(parentId+' .pre_loader').hide();
	}else{
		$('.pre_loader').hide();
	}
}

/*
+---------------------------------------------+
	Bind Tooltip with a:href in table.
+---------------------------------------------+
*/
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

/*
+---------------------------------------------+
	Function is binding datepicker, which have 
	class datepicker hasDatepicker.
+---------------------------------------------+
*/
function myDatepicker()
{
	if($('.datepicker').length){
		  $('.datepicker').datepicker({
				buttonImage: "images/calendar.gif",
				buttonImageOnly: true,
				dateFormat: "mm/dd/yy"
		  });
	  }
}

/*
+---------------------------------------------+
	Function is binding textarea area to tinymce 
	editor, which have class editor.
+---------------------------------------------+
*/
function bind_editor(element)
{
	tinyMCE.init({
						 // General options
						  mode : "textareas",
						  editor_selector : element,
						  theme : "advanced",
						  plugins :"autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

               // Theme options
               theme_advanced_buttons1 :"bold,italic,strikethrough,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,|,link,unlink,pagebreak,|,fullscreen,preview,insertimage,insertfile",
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


/*
+---------------------------------------------+
	Function is upload data set in div while
	editing phase
+---------------------------------------------+
*/
function setPriviewVal(rel, datafill, datafill_url)
{
	$('#tab2').find('input[rel="'+ rel +'"]').hide();
	assignValue($(divId+ ' #preview_'+rel), datafill, 'text');
	$('#'+rel).val(datafill_url);

}

//DRAG & DROP DISPLAY ORDER
function bind_sortable(post_url){
	$(".table_body").sortable({
			opacity: 0.6, cursor: 'move', update: function()
			{
				var order = $(this).sortable("serialize");
				showPreLoader('');					
				$.ajax({
					type: 'POST',
					url: post_url,
					data: order,
					dataType: 'json',
					success: function(data){
						$("tbody > tr:even").removeClass().addClass("alt-row sortable-cursor");
						$("tbody > tr:odd").removeClass().addClass(" sortable-cursor");
						hidePreLoader();
					  }
				});
			}
	});
}