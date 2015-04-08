<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {
	
	var $dbTableUser = 'c_users';
	var $dbTableUserId = 'user_id';
	
	//====================================================================================
	//                         		 LOGIN PAGE
	//====================================================================================
	function index($msg_id = 0)
	{
		if($this->input->post())
		{
			//echo '<pre>';print_r($_POST);die;
			$email 	    = trim($this->input->post('email'));
		    $password   = md5($this->input->post('password'));
			
			$where['email'] = $email;
			$where['password'] = $password;
			
			$response = checkField($where, $this->dbTableUser)->row_array();
			
			if($response['email'] == $email && $response['password'] == $password){
				$data['user_id'] = $response['user_id'];
				$data['email'] = $response['email'];
				
				$this->session->set_userdata($data);
			}
			else
			{
				echo 'Invalid email address or password';
			}
		}
		else
		{
			if($msg_id > 0)
				$data['err_msg'] = Messages($msg_id); //called from common_helper
				
			$data['pageName'] = 'login';
			$data['title'] = 'Login';
			$this->load->view('layout', $data);		
		}
	}
	
	//====================================================================================
	//                         		 REGISTRATION PAGE
	//====================================================================================
	function register()
	{
		//echo '<pre>';print_r($_POST);die;
		if($this->input->post())
		{
			$data['firstname'] 	 = trim(mysql_escape_string($this->input->post('firstname')));
			$data['lastname']    = trim(mysql_escape_string($this->input->post('lastname')));
			$data['email']    	 = trim(mysql_escape_string($this->input->post('email')));
			$data['password']  	 = md5(mysql_escape_string(trim($this->input->post('password'))));
			$data['phone']    	 = trim(mysql_escape_string($this->input->post('phone')));
			
			saveData('',$data, $this->dbTableUser, $this->dbTableUserId); //saved data
			
			
			$from = strip_tags(getField('config_value','config','config_keyword','admin_email')); //get admin email
			$subject = 'Thanks for registering';
			$mail_body = '<table>
							<tr><td>FirstName : </td><td>'.$data['firstname'].'</td></tr>
							<tr><td>LastName : </td><td>'.$data['lastname'].'</td></tr>
							<tr><td>Email : </td><td>'.$data['email'].'</td></tr>
							<tr><td>Password : </td><td>'.$this->input->post('password').'</td></tr>
						 </table>';
			
			sendMail($data['email'], $subject, $mail_body, $from); //send mail	
		}
		else //redirect to register
		{
			$data['pageName'] = 'register';
			$data['title'] = 'Register';
			$this->load->view('layout', $data);
		}				
	}
	

	//====================================================================================
	//                         		CHANGE PASSWORD
	//====================================================================================
	function changepassword($hash_key)
	{
		if($hash_key)
		{
			$where['hash_key'] = $hash_key;
			
			$response = checkField($where, $this->dbTableUser)->row_array();
			if($response['hash_key'] == $hash_key)
			{
				$data['hash_key'] = $hash_key;
				$data['pageName'] = 'changepassword';
				$data['title'] = 'Change Password';
				$this->load->view('layout', $data);		
			}
			else
				redirect('login/index/2');
		}
		else
			redirect('login/index/1');
	}
	
	//====================================================================================
	//                         		UPDATE RESET/NEW PASSWORD
	//====================================================================================
	function saveResetPassword()
	{
		if($this->input->post())
		{
			$where['hash_key'] = $this->input->post('hash_key');
			$response = checkField($where, $this->dbTableUser)->row_array();
			
			$data['password'] = md5(mysql_escape_string(trim($this->input->post('new_password'))));
			$data['hash_key'] = '';
			
			saveData($response['user_id'], $data, $this->dbTableUser, $this->dbTableUserId);
			
			$data['user_id'] = $response['user_id'];
			$data['email'] = $response['email'];
			
			$this->session->set_userdata($data);
			
			echo '14'; //called from common_helper and redirect to login
		}
		else
			redirect('login/index/1');
	}
	
	//====================================================================================
	//                         		 FORGOT PASSWORD
	//====================================================================================
	function forgotpassword()
	{
		if($this->input->post())
		{
			$email = $this->input->post('email');
			$where['email']= $email;
			
			$response = checkField($where, $this->dbTableUser)->row_array();
			if($response['email'] == $email)
			{
				$data['hash_key']	= md5($email);
					  
				saveData($response['user_id'], $data, $this->dbTableUser, $this->dbTableUserId);
					  
				$subject 	= 'CVP Password Reset';
				
				$link = '<a href="'.site_url('login/changepassword/'.$data['hash_key']).'">Click here</a>';
				$mail_body = 'Hello '.$response['firstname'].' '.$response['lastname'].'<br><br>'.
				              'Please '.$link.' to reset your password.';
							  
				$fromEmail = strip_tags(getField('config_value','config','config_keyword','admin_email')); //get admin email
				
				sendMail($response['email'], $subject, $mail_body, $fromEmail); //send mail	
				//sendMail1($response['email'], $subject, $mail_body); //local to send
				
				echo 'Password reset information is sent to your email address. Please check your mailbox.';
			}
			else
				echo 'You are not registered';
		}
		else
		{
			$data['pageName'] = 'forgotpassword';
			$data['title'] = 'Forgot Password';
			$this->load->view('layout', $data);		
		}
	}
	
	//========================================================================================	
	//            AT REGITRATION FORM, THIS FUNCTION CHECK EMAIL ID IN DBTABLE
	//========================================================================================	
	function is_in_db()
	{
		$email = $this->input->post('email');
		
		$where['email'] = $email;
		$response = checkField($where, $this->dbTableUser)->row_array();
		
		if($response)
		  echo $email .' is already Registered';
		  
	}
	
	//========================================================================================	
	//             			USER LOGOUT FUNCTIONALITY
	//========================================================================================	
	function logout()
	{
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('email');
		
		redirect('/');
	}

}