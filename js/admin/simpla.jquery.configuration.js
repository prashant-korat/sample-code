$(document).ready(function(){
	//bind_editor('editor');
				
		$("#main-nav li ul").hide(); // Hide all sub menus
		$("#main-nav li a.current").parent().find("ul").slideToggle("slow"); // Slide down the current menu item's sub menu
		
		$("#main-nav li a.nav-top-item").live('click', // When a top menu item is clicked...
			function () {
				$(this).parent().siblings().find("ul").slideUp("normal"); // Slide up all sub menus except the one clicked
				$(this).next().slideToggle("normal"); // Slide down the clicked sub menu
				return false;
			}
		);
		
		$("#main-nav li a.no-submenu").live('click', // When a menu item with no sub menu is clicked...
			function () {
				window.location.href=(this.href); // Just open the link instead of a sub menu
				return false;
			}
		); 

    // Sidebar Accordion Menu Hover Effect:
		
		$("#main-nav li .nav-top-item").hover(
			function () {
				$(this).stop().animate({ paddingRight: "25px" }, 200);
			}, 
			function () {
				$(this).stop().animate({ paddingRight: "15px" });
			}
		);

    //Minimize Content Box
		
		$(".content-box-header h3").css({ "cursor":"s-resize" }); // Give the h3 in Content Box Header a different cursor
		$(".closed-box .content-box-content").hide(); // Hide the content of the header if it has the class "closed"
		$(".closed-box .content-box-tabs").hide(); // Hide the tabs in the header if it has the class "closed"
		
		$(".content-box-header h3").live('click', // When the h3 is clicked...
			function () {
			  $(this).parent().next().toggle(); // Toggle the Content Box
			  $(this).parent().parent().toggleClass("closed-box"); // Toggle the class "closed-box" on the content box
			  $(this).parent().find(".content-box-tabs").toggle(); // Toggle the tabs
			}
		);

    // Content box tabs:
		
		$('.content-box ul.content-box-tabs li a').live('click', // When a tab is clicked...
			function() { 
				$(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
				$(this).addClass('current'); // Add class "current" to clicked tab
				var currentTab = $(this).attr('rel'); // Set variable "currentTab" to the value of href of clicked tab

				if(currentTab == '#tab1')
				{
					//$('option:selected').removeAttr('selected');
					clearForm();
				}else{
					//bind_editor('editor');
				}
				$('div.tab-content').hide(); // Hide all content divs
				$(currentTab).show(); // Show the content div with the id equal to the id of clicked tab

				return false; 
			}
		);


    //Close button:
		
		$(".close").live('click',function () {
			$(this).parent().slideUp(400);
				/*$(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
					$(this).slideUp(400);
				});*/
				return false;
			}
		);

    // Alternating table rows:
		
		$('tbody tr:even').addClass("alt-row"); // Add class "alt-row" to even table rows

    // Check all checkboxes when the one in a table head is checked:
		
		$('.check-all').live('click',function(){
				$(this).parent().parent().parent().parent().find("input[type='checkbox']").attr('checked', $(this).is(':checked'));   
			}
		);
		
   // Initialise Facebox Modal window:
			$('a[rel*=modal]').live('click',
				function(){
//					$('a[rel*=modal]').facebox()
					popupId = $(this).attr('data-');
					$.blockUI({ message: $('#'+popupId) });
					setOverlayPos();

					return false;
				}); // Applies modal window to any link with attribute rel="modal"

	
});
 
function clearForm()
{
			$('.previewImg').html('');
			$('.uploadFile').show();

	 $('#reset, .reset').trigger('click');
	 $(':input','.recordManage')
		 .not(':button, :submit, :reset, :radio')
		 .val('')
		 .removeAttr('checked')
		 .removeAttr('selected');
		 
	  //if($('.editor').length>0)
	 
	 //assignValue('textarea', '', 'textarea');
	 $('#link_yes').attr('checked','checked');
	 $('#hide_extlink').show();
	 $('#hide_imglink').hide();
	 $('#res_image').show();
	 $('#res_video').show();
	 $('#hover_image').show();
	 $('#active_image').show();
	 $('#home_icon').show();
	 $('#finish_icon').show();
	 $('#preview').html('');
	 $('#preview_video').html('');
	 $('#preview_hover').html('');
	 $('#preview_active').html('');
	 $('#preview_home_icon').html('');
	 $('#preview_finish_icon').html('');
	 $('#imgPart').html('');
	 
}