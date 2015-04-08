<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_login extends CI_Model {
	
/*
++++++++++++++++++++++++++++++++++++++++++++++++++++
	Function validate the user credential. and if exist 
	then return whole array.
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
	public function validateLogin()
	{
		$username = $this->input->post('username');
		$password = (md5($this->input->post('password').$this->config->item('encryption_key')));

		$user = $this->db->where('username',$username)->where('password',$password)->where('del_in',0)->where('admin_type', 'A')->get('admins')->row_array();
		return $user;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */