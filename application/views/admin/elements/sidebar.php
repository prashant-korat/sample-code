<div id="sidebar">
	<div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
    
          <h1 id="sidebar-title"><a href="#">Admin</a></h1>
        
          <!-- Logo (221px wide) -->
          <a href="<?php echo site_url('admin');?>"><img id="logo" src="<?php echo base_url() ?>images/admin/logo.png" alt="Simpla Admin logo" /></a>
        
          <!-- Sidebar Profile links -->
          <div id="profile-links">
              Hello, <a  href="<?php echo site_url('admin/login/account_setting') ?>" rel="modal" data-="account_setting"><?php echo ucfirst($this->session->userdata('admin_user')) ?></a><br />
              <br />
              <a href="<?php echo site_url() ?>" title="View the Site">View the Site</a> | <a href="<?php echo site_url('admin/login/logout'); ?>" title="Sign Out">Sign Out</a>
          </div>        
          
          <ul id="main-nav">  <!-- Accordion Menu -->
              
              <!--<li>
                  <a href="<?php echo site_url('admin/dashboard_content') ?>" rel="dashboard_content" class="nav-top-item no-submenu ">Dashboard</a>       
              </li>-->

              <li> 
                  <a rel="category" href="<?php echo site_url('admin/category') ?>" class="nav-top-item no-submenu">
                  	  Category
                  </a>
              </li>
			  
              <li> 
                  <a rel="question" href="<?php echo site_url('admin/question') ?>" class="nav-top-item no-submenu">
                  	  Questions
                  </a>
              </li>
			  
              <li> 
                  <a rel="test" href="<?php echo site_url('admin/test') ?>" class="nav-top-item no-submenu">
                  	  Set Questions Paper
                  </a>
              </li>
			  
              <li>
                  <a href="#" class="nav-top-item">
                      Student Corner
                  </a>
                  <ul>
                      <li><a rel="userlist" href="<?php echo site_url('admin/userlist'); ?>">Student List</a></li>
                  </ul>
              </li>        

              <li> 
                  <a rel="materials" href="<?php echo site_url('admin/materials') ?>" class="nav-top-item no-submenu">
                  	  Materials
                  </a>
              </li>
              

              <li> 
                  <a rel="news" href="<?php echo site_url('admin/news') ?>" class="nav-top-item no-submenu">
                  	  News
                  </a>
              </li>

              <li> 
                  <a rel="discussion" href="<?php echo site_url('admin/discussion') ?>" class="nav-top-item no-submenu">
                  	  Discussion
                  </a>
              </li>
              
              <?php /* ?>
              

               <li> 
                  <a rel="admin_user" href="<?php echo site_url('admin/admin_user') ?>" class="nav-top-item no-submenu">
                  	  User
                  </a>
              </li>

              <li> 
                  <a rel="config" href="<?php echo site_url('admin/config') ?>" class="nav-top-item no-submenu">
                  	  Manage Configuration
                  </a>
              </li>
			  <?php */ ?>

              <!--
              <li>
                  <a href="#" class="nav-top-item">
                      Settings
                  </a>
                  <ul>
                      <li><a href="#">General</a></li>
                      <li><a href="#">Design</a></li>
                      <li><a href="#">Your Profile</a></li>
                      <li><a href="#">Users and Permissions</a></li>
                  </ul>
              </li>      
              -->
              
          </ul> <!-- End #main-nav -->
          
          
          
      </div>
</div> <!-- End #sidebar -->
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<!-- Page Head -->
			<h2>Welcome <?php echo ucfirst($this->session->userdata('admin_user')); ?></h2>
	<div id="main-content-html" style="min-height:700px;">
<div id="account_setting"></div>