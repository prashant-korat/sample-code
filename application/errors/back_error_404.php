<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>404 page not found</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="./css/404.css">
<script src="<?php echo './js/jquery-1.8.3.min.js'; ?>" type="text/javascript"></script>
</head>
<body>
<div class="bg-wrapper">
  <div class="bg-l3">
    <div class="content-container">
      <h1><?php echo $heading; ?></h1>
      <p><?php echo $message; ?></p>
    </div>
    <div class="dashboard-container">
      <div class="dashboard">
        <div class="button-container">
          <div class="icon-container">
            <div class="tooltip-container">
              <div class="tooltip-body">Go Back</div>
              <div class="tooltip-bottom"></div>
            </div>
            <?php $url = 'http://'.$_SERVER['SERVER_NAME'].(str_replace($_SERVER['REDIRECT_QUERY_STRING'],'',$_SERVER['REQUEST_URI']))."/"; ?>
            <span class="icon-hover"></span> 
            <a class="icon back" href="<?php echo (@$_SERVER['HTTP_REFERER']) ? @$_SERVER['HTTP_REFERER'] : $url; ?>"></a> </div>
          <div class="icon-container">
            <div class="tooltip-container">
              <div class="tooltip-body">Search</div>
              <div class="tooltip-bottom"></div>
            </div>
            <span class="icon-hover"></span> <a class="icon search" href="javascript:void(0)"></a> </div>
          <div class="icon-container">
            <div class="tooltip-container">
              <div class="tooltip-body">Site Map</div>
              <div class="tooltip-bottom"></div>
            </div>
            <span class="icon-hover"></span> <a class="icon sitemap" href="javascript:void(0)"></a> </div>
        </div>
      </div>
      <div class="dropdown">
        <div id="search" style="display: none">
          <div class="content-container">
            <div class="search-wrapper">
              <form action="<?php echo $url.('searchResult');?>" onsubmit="return searchValidate(); " method="post">
                <input type="text" id="search-field" name="search_field"/>
                <button>Search</button>
              </form>
            </div>
          </div>
        </div>
        <div id="sitemap" style="display: none">
          <div class="content-container">
            <ul>
              <li>
                <h2>Quick Links</h2>
              </li>
             	<li><a href="<?php echo $url.('videoLibrary'); ?>" >Video Library</a></li>
                <li><a href="<?php echo $url.('calculator'); ?>" >Safety Cost Calculator</a></li>
                <li><a href="<?php echo $url.('Resources') ?>">Resource Center</a></li>
            </ul>
            <ul>
              <li>
                <h2>Need Help ?</h2>
              </li>
                	<li><a href="<?php echo $url.('faqs'); ?>" class="footer_link">FAQs</a></li>
                    <li><a href="<?php echo $url.('profile'); ?>" class="footer_link">Account Settings</a></li>
                    <li><a href="<?php echo $url.('contact') ?>" class="footer_link">Contact Us</a></li>
                    <li><a href="<?php echo $url.('badgeTest') ?>" class="footer_link">Educate Yourself</a></li>
            </ul>
            
            <ul>
              <li>
                <h2>Company</h2>
              </li>
                	<li><a href="http://www.pssd.com/" class="footer_link">Corporate</a></li>
                    <li><a href="https://secure.mypss.com/" class="footer_link">My Pss</a></li>
                    <li><a href="<?php echo $url.('privacyPolicy') ?>" class="footer_link">Privacy</a></li>
                    <li><a href="<?php echo $url.('termConditions') ?>" class="footer_link">Terms & Conditions</a></li>
            </ul>
            
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $('.search').stop(true,true).on('click', function (e) {
        $(this).addClass('active-search');
        
		$('#sitemap').hide('fast');
        $('.sitemap').removeClass('active-sitemap');
        $('#search').show('fast');
    });
	
	
    $('.sitemap').stop(true,true).on('click', function (e) {
        $(this).addClass('active-sitemap');
        $('#search').hide('fast');
        $('.search').removeClass('active-search');
        $('#sitemap').show('fast');
    });
});
function searchValidate()
{
	if($.trim($('input[name=search_field]').val()) == '')
		return false;
	else
		return true;
}
</script>
</body>
</html>