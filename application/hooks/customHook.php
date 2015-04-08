<?php
// referrece link : http://codeigniter.com/user_guide/general/hooks.html
class customHook extends CI_Hooks{
	 public $CI;
	 function __construct() 
	 {
		parent::__construct();
		$this->CI = get_instance();
	 }
/*
+++++++++++++++++++++++++++++++++++++++++++++
	This function will detect admin url and 
	check for session, if session null then 
	check for cookie, if cookie exist then
	take username from it work ahead.
+++++++++++++++++++++++++++++++++++++++++++++
*/
	 function adminAutoLogin()
	 {
		 //check for admin url access or not
		if($this->CI->router->directory == 'admin/')
		{
			//checking for admin session.
			if(!$this->CI->session->userdata('admin_id') && $this->CI->input->cookie('c_admin') != ''):
				$this->CI->encrypt->set_cipher(MCRYPT_GOST); // set encryption type
				$admin = $this->CI->encrypt->decode($this->CI->input->cookie('c_admin')); // decode cookie value
				if(is_string($admin)):
					$admin_info = $this->CI->db->select('admin_id,username as admin_user', FALSE)->where('username',$admin)->get('c_admins')->row_array();
					$this->CI->session->set_userdata($admin_info);
				endif;
			elseif(!$this->CI->session->userdata('admin_id')):
					$this->_setReferrer();
					if($this->CI->router->class == 'login' && $this->CI->router->method != 'index')
						redirect('admin/login');
					else if($this->CI->router->class != 'login')
						redirect('admin/login');
			endif;
		}
		 
		 //echo 'Wow!! Great hook called';
	 }
/*
+++++++++++++++++++++++++++++++++++++++++++
setting referrring url. user will redirect 
this url after successfull login
+++++++++++++++++++++++++++++++++++++++++++
*/
	private function _setReferrer()
	{
		if(isset($_SERVER['REDIRECT_QUERY_STRING']))
		{	
			if(($this->CI->uri->rsegment('1') == 'login' && $this->CI->uri->rsegment('2') != 'index') || $this->CI->uri->rsegment('1') != 'login')
				setFlashMessage('referrer',$_SERVER['REDIRECT_QUERY_STRING']);	
			
		}
	}
}