var noti_id = window.setInterval(hideNotification, 5000);
$(document).ready(function(e) {
	
	//setting first tab active
	$('.content-box .content-box-content div.tab-content').hide(); // Hide the content divs
	$('ul.content-box-tabs li a.default-tab').addClass('current'); // Add the class "current" to the default tab
	$('.content-box-content div.default-tab').show(); // Show the div with class "default-tab"
		
	//tabs binding 
		$('.content-box ul.content-box-tabs li a').click( // When a tab is clicked...
			function() { 
				$(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
				$(this).addClass('current'); // Add class "current" to clicked tab
				var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
				$(currentTab).siblings().hide(); // Hide all content divs
				$(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
				return false; 
			}
		);
		
	//manage pagination link and sort order.
	$('.listing_table thead tr th').live('click',function(){
		
		var field = $(this).attr('f');
		var srt = $(this).attr('s');
		
		if(typeof(field) != 'undefined' && typeof(srt) != 'undefined')
		{
			$(this).attr('s',srt);
					
			var lc = document.location.origin+document.location.pathname+"?f="+field+"&s="+srt;
			
			//collect table parent
			var parent_table = $(this).parents('table.listing_table');
			listInitialModule(lc,parent_table);
		}
			
	});
	//detect ajax start request and remove all tooltip
	$(document).ajaxSend(function() {
		$('.qtip').remove();
	});
	
    //Manage Pagination links and clicks
	$('.listing_table .pagination a').live('click',function(){
			
			//if there is no active class then we have to call ajax
			if(!$(this).hasClass('active'))
			{
				var href = $(this).attr('href');
				var parent_table = $(this).parents('table.listing_table');
				
				listInitialModule(href,parent_table);
				
			}
			return false;
		});
		
   
   //for sorting and also for and admin help
   	bind_tooltip();
	$('.search_input').live('click',function(){
		var sr_val = $(this).val();
		if($.trim(sr_val) == 'Search')
			$(this).val('').focus();
	});
	
	//blur event
	$('.search_input').live('blur',function(){
		var sr_val = $(this).val();
		if($.trim(sr_val) == '')
			$(this).val('Search');
	});
	
	
	//manage Searching in listing.
	$('#searchBtn').live('click',function(){
		var parent_table = $(this).parents('.listing_table');
		
		if($(this).prev().val() !='Search' && $(this).prev().val() != '')
			listInitialModule('',parent_table);
	});
	
	$('#clearSearch').live('click',function(){
		var parent_table = $(this).parents('.listing_table');
		$(parent_table).find('#searchText').val('');
		
		listInitialModule('',parent_table);
	});
	
	//sort binding with modules
	sortListing();
	
});
/*
+---------------------------------------------+
	Functiona called when apply selected button 
	clicked from listing of any module.
+---------------------------------------------+
*/
function applySelectedClicked(obj)
{
	var parent_table = $(obj).parents('table.listing_table');
	var opt_selected = $(obj).prev().val();
	
	if(opt_selected == '')
	{
		$(parent_table).prev().html(getNotificationHtml('error','Please choose an action you want apply.'));
		return false;
	}
	else if($(parent_table).find('input[name="'+controller.toLowerCase()+'[]"]:checked').size() == 0)
	{
		$(parent_table).prev().html(getNotificationHtml('error','Please select at least 1 item to '+opt_selected));
		return false;
	}
	
	//showing preloader
	showLoader(parent_table);
	
	//case: if admin select delete all item
	if(opt_selected == 'Delete')
	{
		deleteItem(null,parent_table);
	}
}
/*
+---------------------------------------------+
	Bind Tooltip with a:href in table.
+---------------------------------------------+
*/
function bind_tooltip()
{
	
	$('.listing_table a[title], .listing_table th[s]').qtip({
		position: { corner: {target : 'topLeft',tooltip : 'topRight'}, target : 'mouse' },
		adjust:{ mouse: true},
		style: {name : 'cream',tip: true} // Give it some style
	 });
	 
	 $('.listing_table tr:even').addClass("alt-row"); // Add class "alt-row" to even table rows
}
/*
+---------------------------------------------+
	Check for # if any # exist then functio will
	return it. 
	Identical to page number. Ex. 20,40,60
+---------------------------------------------+
*/
function checkForHash()
{
	var hash = document.location.hash;
	
}
/*
+---------------------------------------------+
	Make the single deletion or multiple deletion 
	of item using ajax. 
	@prams : Item_id - going to delete current item
	of deletion.
	obj - Parent table object
+---------------------------------------------+
*/
function deleteItem(item_id,obj)
{
	//if no item id passed then we consider that admin going for multiple delete.
	if(typeof(item_id) == 'undefined' || item_id == null) // case : multiple delete
	{
		var form_data = $(obj).find('input[name="'+controller.toLowerCase()+'[]"]:checked').serialize();
		
		//getting curent link from pagination
		var loc = $(obj).find('.pagination a.active').attr('data-');
		
		//show loader 
		showLoader(obj);
				
		//collect Link from pagination
		$.post(base_url+'admin/'+controller.toLowerCase()+'/delete'+controller,form_data,function(){ 
				//hide loader 
				hideLoader(obj);
				
				listInitialModule(loc,obj);
			});
	}
	else // if item id passed then we have delete manually current item by get request
	{
		//deleting row()
		$(obj).parents('tr').fadeOut(500,function(){ $(obj).parents('tr').remove(); });
				
		$.get(base_url+'admin/'+controller.toLowerCase()+'/delete'+controller,{item_id : item_id},function(){ 
			$(obj).parents('.listing_table').prev().html(getNotificationHtml('success','Record has been deleted successfully.'));
		});
	}
}
/*
+----------------------------------------------+
	This function will return notification html
	@params : type -> type of notification.
			  message - > message you want dispaly 
			  				as error.
+----------------------------------------------+
*/
function getNotificationHtml(type,message)
{
	var ht = '<div class="notification '+type+' png_bg"><a href="#" class="close"><img src="'+base_url+'images/admin/cross_grey_small.png" title="Close this notification" alt="close"></a><div>'+message+'</div></div>';
	
	clearInterval(noti_id);
	noti_id = window.setInterval(hideNotification, 5000);
	return ht;
}
/*
+---------------------------------------------+
	hide preloader at listing table.
+---------------------------------------------+
*/
function hideLoader(parentDiv)
{
	$(parentDiv).prev().prev().hide();
}
/*
+---------------------------------------------+
	AutoHide notification div. function call
	from timeout every 7 seconds.
+---------------------------------------------+
*/
function hideNotification(parentDiv)
{
	$('.notification').slideUp();
}

/*
+---------------------------------------------+
	Make initial ajax call to controller. detect 
	controller and which method this function have 
	to call
+---------------------------------------------+
*/
function listInitialModule(href,parent_table)
{
	var form_data = {perPage: $(parent_table).find('.perPageDropdown').val()};
	var str = $(parent_table).find('#searchText').val();
	
	//showing preloader
	showLoader(parent_table);
	
	if(typeof(href) == 'undefined' || href == '')
		href = base_url+'admin/'+controller.toLowerCase();
	
	//prepare for search criteria
	if(str != 'Search')
		form_data.searchText = str;
		
	$.post(href,form_data,function (msg) { 
					//hide preloader
					hideLoader(parent_table);
					//inserting content
					$(parent_table).replaceWith(msg);  
						
					//binding tooltip after response inserted on it.
					 bind_tooltip();
					 
					 //bind sorting js after ajax call
					 sortListing();  
					 
					});
}
/*
+---------------------------------------------+
	Per page record dropdown management. 
	@params : obj -> current element object
+---------------------------------------------+
*/
function perPageManage(obj)
{
	var parent_table = $(obj).parents('.listing_table');
	
	var hef = $(parent_table).find('.pagination a.active').attr('data-');
	
	listInitialModule(hef,parent_table);
}
/*
+---------------------------------------------+
	show preloader at listing table.
+---------------------------------------------+
*/
function showLoader(parentDiv)
{
	$(parentDiv).prev().prev().show();
}
/*
+---------------------------------------------+
	Function perform Sorting data of all module.
	Collect data using this selector
+---------------------------------------------+
*/
function sortListing()
{
	$(".table_body").sortable({ opacity: 0.6, cursor: 'move', update: function() 
	{ 
			var order = $(this).sortable("serialize");
			var start = $(this).find('.start_position').val();
			
			$.ajax({
				type: 'POST',
				url: base_url+'/admin/'+controller.toLowerCase()+'/ordering'+controller+'/'+start,
				data: order,
				dataType: 'json',
				success: function(data){}
			 });
	}
	});
}