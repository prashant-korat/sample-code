<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
	function Login()
	{
		parent::__construct();
		$this->load->model('admin/model_login','mdLogin');
	}

	public function index()
	{
		//if admin already loggedin then we have to redirect to dashboard
		if($this->session->userdata('admin_id'))
			redirect('admin/login/dashboard');
		
		$this->form_validation->set_rules('username','Username','trim|required');
		$this->form_validation->set_rules('password','Password','trim|required');

		if($this->form_validation->run() == FALSE)
		{
			if($_POST):
				setFlashMessage('error',validation_errors());
			endif;
			
			$this->load->view('admin/login');
		}
		else if($this->form_validation->run() == TRUE)
		{
			$admin = $this->mdLogin->validateLogin();
					
			//if invalid Login
			if(!count($admin)):
				$error = "Invalid login credentials.";
				setFlashMessage('error',$error);
			
				$this->load->view('admin/login');
			else:	
			//setting session of admin.
			$session = array('admin_id'=>$admin['admin_id'],'admin_user'=>$admin['username'], 'admin_type'=>$admin['admin_type']);
			$this->session->set_userdata($session);
			
			//setting remember me credential if selected remember me checkbox
			if($this->input->post('remember_me') == '1')
				$this->_setLoginCookie();
			
			//redirecting to dashboard
			$redirect = getFlashMessage('referrer');
			
			if($redirect !='')
				redirect($redirect);
			else
				redirect('admin/login/dashboard');
			
			endif;
		}
	}
	
	public function dashboard()
	{
		if(!$this->session->userdata('admin_id'))
			redirect('admin/login');
			
		  $data['selectMenu'] = 'dashboard';
		  $data['title'] = 'dashboard';

		  $this->load->view('admin/elements/header',$data);
		  $this->load->view('admin/elements/sidebar');
//		  $this->load->view('admin/elements/ajax_load_data',$data);
		  $this->load->view('admin/elements/footer');
	}
	
	function logout()
	{
		$arr = array('admin_id'=>'','admin_user'=>'');
		$this->session->unset_userdata($arr);		
		
		//unsetting cookies.
		delete_cookie('c_admin');
		
		redirect('admin/login');
	}
	
	private function _setLoginCookie()
	{
		$this->encrypt->set_cipher(MCRYPT_GOST);
		
		$ck = array(
			'name'   => 'admin',
			'value'  => $this->encrypt->encode($this->input->post('username')),
			'expire' => 86500,
			'path'   => '/',
			'prefix' => 'c_',
			'secure' => FALSE
		);
		
		$this->input->set_cookie($ck);
	}
	
	function account_setting(){
		echo 'aa';
	}
}