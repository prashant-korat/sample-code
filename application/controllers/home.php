<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {
	
	//var $dbTable_user = 'c_users';
	//var $dbTableId_user = 'user_id';

	function home()
	{
		parent::__construct();
		
	}

	//====================================================================================
	//                         		 HOME PAGE
	//====================================================================================
	public function index()
	{
		$this->load->view('header');
		$this->load->view('footer');
	}
	
	function aboutus()
	{
		$this->load->view('header');
		$this->load->view('aboutus');
		$this->load->view('footer');
	}
	
	function designers()
	{
		$this->load->view('header');
		$this->load->view('designers');
		$this->load->view('footer');
	}
	
	function catalouges()
	{
		$data['albums'] = $this->db ->select('l_album.*')
						  ->order_by('sort_order')
						  ->get('album')->result_array();
						  
						  
//		echo '<pre>';print_r($data);echo '</pre>';die;
		$this->load->view('header');
		$this->load->view('catalouges', $data);
		$this->load->view('footer');
	}
	
	function stores()
	{
		$this->load->view('header');
		$this->load->view('stores');
		$this->load->view('footer');
	}


	function order()
	{
		$this->form_validation->set_rules('name', 'M/S.', 'trim|required');
		$this->form_validation->set_rules('phone_no', 'Phone No.', 'trim|required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if ($this->form_validation->run() == FALSE)
		{
			//error
			$data = $_POST;
		}
		else
		{
			//success
			
			$saveData = $_POST;
			
			unset($saveData['perticulers']);
			unset($saveData['Pieces']);
			unset($saveData['Rate']);
			unset($saveData['Remark']);
			
			$postData = array();
			$postData['perticulers'] = $_POST['perticulers'];
			$postData['Pieces'] = $_POST['Pieces'];
			$postData['Rate'] = $_POST['Rate'];
			$postData['Remark'] = $_POST['Remark'];
			
			$saveData['order'] = json_encode($postData);
			
			$this->db->insert('order', $saveData);

			$toEmail = getField('config_value','config','config_keyword','admin_email');
			$from_email = $saveData['email'];
			$from_name = $saveData['name'];
			$mail_body = 'Name : '.$saveData['name'].'<br />
						  email : '.$saveData['name'].'<br />
						  Phone No :'.$saveData['phone_no'];
			$subject = 'Libaas Order';
			
			sendMail($toEmail, $subject, $mail_body, $from_email, $from_name);
			setFlashMessage('success', 'Your order submitted successfully.');
			redirect('order');
			
		}
		
		$this->load->view('header');
		$this->load->view('order', $data);
		$this->load->view('footer');
	}

	function contact()
	{
		$this->load->view('header');
		$this->load->view('contact');
		$this->load->view('footer');
	}
	
	function setAuth(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$this->db->where('admin_type','C');
		$response = $this->db->get('admins')->row_array();
		
		if($response)
			$this->session->set_userdata('client_id',$response['admin_id']);
		else
			echo 'Wrong Combination of Username Or Password';
	}
	
	function album($album_id){
		//SELECT `album_id`, `album_name`, `width`, `height`, `album_poster`, `is_private`, `sort_order`, `del_in` FROM `l_album` WHERE 1
		$albumRes = $this->db->where('album_id', $album_id)
							 ->where('del_in', 0)
							 ->get('album')->row_array();

		if($albumRes){

			if($albumRes['is_private'] == 1){
				if(!$this->session->userdata('client_id')){
					redirect('catalouges');
					die;
				}
			}

			$data['album_data'] = $albumRes;
			//SELECT `image_id`, `album_id`, `img_path`, `sort_order`, `del_in` FROM `l_images` WHERE 1
			$album_img_data = $this->db->where('album_id', $album_id)
											   ->where('del_in',0)
											   ->order_by('sort_order')
											   ->get('images')->result_array();
  
			if($album_img_data){
				$data['album_img_data'] = $album_img_data;
			}else{
				echo 'no image in album';
				die;
			}

			$this->load->view('album', $data);
		}else{
			echo '<div align="center"><h2>Sorry No Data Found. <br /><small><a href="'.site_url('catalouges').'">click here</a> for go back</small></h2></div>';
			die;
		}					  
	}
	
	function portfolio_req(){
		$data = $this->input->post();
		
		
		
		$this->db->insert('portfolio_req', $data);
		
		$mail_body = 'Firm Name :'. $data['company_name'] .'<br />
					  Address : '. $data['address'] .'<br />
					  Contact Person :'. $data['name'] .'<br />
					  Contact No. : '. $data['contact_no'] .'<br />
					  Email : '. $data['email'];
		$toEmail = getField('config_value','config','config_keyword','admin_email');
		$subject = 'Libaas Portfolio Request';
		$from_email = $data['email'];
		$from_name = $data['name'];
		
		sendMail($toEmail, $subject, $mail_body, $from_email, $from_name);
		
		redirect('catalouges');
	}
	
}