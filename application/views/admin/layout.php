<?php 
$this->load->view('admin/elements/header');

//check this view for admin panel is exist or not
//if file not exist then we have to show some error regrading load view 
/*if(file_exists(APPPATH."views/admin/".$pageName.".php") && $pageName != '')
	$this->load->view('admin/'.$pageName);
else
	log_message('error', 'This view file is not exist in admin folder.');*/
	
$this->load->view('admin/elements/footer');
?>